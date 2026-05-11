<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AssistanceRequestDocument;
use App\Models\AssistanceRequest;
use App\Models\AssistanceRequestChild;
use App\Models\RequestType;
use App\Models\RequestCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssistanceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $filterYear      = $request->get('filter_year');
        $filterTypeId    = $request->get('filter_type_id');
        $filterStatus    = $request->get('filter_status');
        $filterApplicant = $request->get('filter_applicant');

        $buildQuery = function ($base) use ($filterYear, $filterTypeId, $filterStatus, $filterApplicant) {
            if ($filterYear) {
                $base->whereRaw('strftime("%Y", assistance_requests.created_at) = ?', [$filterYear]);
            }
            if ($filterTypeId) {
                $base->where('request_type_id', $filterTypeId);
            }
            if ($filterStatus) {
                $base->where('status', $filterStatus);
            }
            if ($filterApplicant) {
                $base->where('applicant_name', 'like', "%{$filterApplicant}%");
            }
            return $base;
        };

        if ($user->role === 'member') {
            $base = AssistanceRequest::with('user', 'requestType')->where('user_id', $user->id)->latest();
            $requests = $buildQuery($base)->paginate(10)->withQueryString();
        } elseif ($user->role === 'agent') {
            $agent = Agent::where('user_id', $user->id)->first();
            $base = AssistanceRequest::with('user', 'requestType')
                ->when($agent, fn ($q) => $q->where('agent_id', $agent->id), fn ($q) => $q->whereRaw('1 = 0'))
                ->latest();
            $requests = $buildQuery($base)->paginate(10)->withQueryString();
        } elseif ($user->role === 'jk') {
            $base = AssistanceRequest::with('user', 'requestType')->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhereIn('status', ['in_process', 'approved', 'rejected']);
            })->latest();
            $requests = $buildQuery($base)->paginate(10)->withQueryString();
        } else {
            $base = AssistanceRequest::with('user', 'requestType')->latest();
            $requests = $buildQuery($base)->paginate(10)->withQueryString();
        }

        $availableYears = AssistanceRequest::selectRaw('strftime("%Y", created_at) as year')
            ->distinct()->orderByDesc('year')->pluck('year');

        $requestTypes = RequestType::orderBy('name')->get();

        $statusOptions = [
            'draft'      => 'Draf',
            'submitted'  => 'Dihantar',
            'in_process' => 'Dalam Proses',
            'approved'   => 'Diluluskan',
            'rejected'   => 'Ditolak',
        ];

        return view('assistance-requests.index', compact(
            'requests', 'availableYears', 'requestTypes', 'statusOptions',
            'filterYear', 'filterTypeId', 'filterStatus', 'filterApplicant'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $requestTypes = RequestType::all();
        $agentQuery = Agent::where('status', 'active')
            ->with('user')
            ->orderBy('staff_name');
        $currentAgent = null;

        if (Auth::user()->role === 'agent') {
            $currentAgent = Agent::where('user_id', Auth::id())->first();
            $agentQuery->whereKey($currentAgent?->id);
        }

        $agents = $agentQuery->get();
        $documentRequirements = config('assistance_documents.categories', []);

        return view('assistance-requests.create', compact('requestTypes', 'agents', 'documentRequirements', 'currentAgent'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'request_type_id' => 'required|exists:request_types,id',
            'request_category_id' => 'required|exists:request_categories,id',
            'request_subcategory_id' => 'required|exists:request_subcategories,id',
            'purpose' => 'required|string',
            'applicant_name' => 'required|string',
            'applicant_ic' => 'required|string',
            'applicant_salary' => 'nullable|numeric',
            'applicant_position' => 'nullable|string',
            'applicant_office_address' => 'nullable|string',
            'applicant_accounting_office' => 'nullable|string',
            'applicant_phone' => 'required|string',
            'applicant_email' => 'required|email',
            'applicant_bank_account' => 'nullable|string',
            'household_income' => 'nullable|numeric',
            'dependents_count' => 'nullable|integer',
            'disabled_dependents_count' => 'nullable|integer',
            'spouse_name' => 'nullable|string',
            'spouse_ic' => 'nullable|string',
            'spouse_salary' => 'nullable|numeric',
            'spouse_position' => 'nullable|string',
            'agent_id' => 'required|exists:agents,id',
            'children' => 'nullable|array',
            'children.*.child_name' => 'required_with:children|string|max:255',
            'children.*.child_ic' => 'nullable|string|max:12',
            'children.*.age' => 'nullable|integer|min:0|max:25',
            'children.*.school_name' => 'nullable|string|max:255',
        ] + $this->documentValidationRules((int) $request->input('request_category_id')));

        unset($validated['documents']);
        $childrenData = $validated['children'] ?? [];
        unset($validated['children']);

        if (Auth::user()->role === 'agent') {
            $currentAgent = Agent::where('user_id', Auth::id())->firstOrFail();
            $validated['agent_id'] = $currentAgent->id;
        }

        $validated = $this->normalizeAssistanceRequestData($validated);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'draft';

        $assistanceRequest = AssistanceRequest::create($validated);

        // Store child information if provided
        if (!empty($childrenData)) {
            foreach ($childrenData as $childData) {
                if (!empty($childData['child_name'])) {
                    AssistanceRequestChild::create([
                        'assistance_request_id' => $assistanceRequest->id,
                        'child_name' => $childData['child_name'],
                        'child_ic' => $childData['child_ic'] ?? null,
                        'age' => $childData['age'] ?? null,
                        'school_name' => $childData['school_name'] ?? null,
                    ]);
                }
            }
        }

        $this->syncDocuments($request, $assistanceRequest);

        return redirect()->route('assistance-requests.show', $assistanceRequest)
            ->with('success', 'Permohonan telah disimpan sebagai draf');
    }

    /**
     * Display the specified resource.
     */
    public function show(AssistanceRequest $assistanceRequest)
    {
        if (!$this->canViewRequest(Auth::user(), $assistanceRequest)) {
            abort(403);
        }

        $assistanceRequest->load(['documents', 'children', 'requestType', 'category', 'subcategory', 'agent']);

        return view('assistance-requests.show', compact('assistanceRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssistanceRequest $assistanceRequest)
    {
        if ($assistanceRequest->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $requestTypes = RequestType::all();
        $selectedType = $assistanceRequest->requestType;
        $categories = $selectedType ? $selectedType->categories : [];
        $agentQuery = Agent::where('status', 'active')
            ->with('user')
            ->orderBy('staff_name');
        $currentAgent = null;

        if (Auth::user()->role === 'agent') {
            $currentAgent = Agent::where('user_id', Auth::id())->first();
            $agentQuery->whereKey($currentAgent?->id);
        }

        $agents = $agentQuery->get();
        $documentRequirements = config('assistance_documents.categories', []);

        $assistanceRequest->load('documents', 'children');

        return view('assistance-requests.edit', compact('assistanceRequest', 'requestTypes', 'categories', 'agents', 'documentRequirements', 'currentAgent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssistanceRequest $assistanceRequest)
    {
        if ($assistanceRequest->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'request_type_id' => 'required|exists:request_types,id',
            'request_category_id' => 'required|exists:request_categories,id',
            'request_subcategory_id' => 'required|exists:request_subcategories,id',
            'purpose' => 'required|string',
            'applicant_name' => 'required|string',
            'applicant_ic' => 'required|string',
            'applicant_salary' => 'nullable|numeric',
            'applicant_position' => 'nullable|string',
            'applicant_office_address' => 'nullable|string',
            'applicant_accounting_office' => 'nullable|string',
            'applicant_phone' => 'required|string',
            'applicant_email' => 'required|email',
            'applicant_bank_account' => 'nullable|string',
            'household_income' => 'nullable|numeric',
            'dependents_count' => 'nullable|integer',
            'disabled_dependents_count' => 'nullable|integer',
            'spouse_name' => 'nullable|string',
            'spouse_ic' => 'nullable|string',
            'spouse_salary' => 'nullable|numeric',
            'spouse_position' => 'nullable|string',
            'agent_id' => 'required|exists:agents,id',
            'children' => 'nullable|array',
            'children.*.child_name' => 'required_with:children|string|max:255',
            'children.*.child_ic' => 'nullable|string|max:12',
            'children.*.age' => 'nullable|integer|min:0|max:25',
            'children.*.school_name' => 'nullable|string|max:255',
        ] + $this->documentValidationRules((int) $request->input('request_category_id'), $assistanceRequest));

        unset($validated['documents']);
        $childrenData = $validated['children'] ?? [];
        unset($validated['children']);

        if (Auth::user()->role === 'agent') {
            $currentAgent = Agent::where('user_id', Auth::id())->firstOrFail();
            $validated['agent_id'] = $currentAgent->id;
        } elseif (Auth::user()->role !== 'admin' && $assistanceRequest->status !== 'draft') {
            $validated['agent_id'] = $assistanceRequest->agent_id;
        }

        $validated = $this->normalizeAssistanceRequestData($validated);

        $assistanceRequest->update($validated);

        // Update child information
        $assistanceRequest->children()->delete(); // Remove old records
        if (!empty($childrenData)) {
            foreach ($childrenData as $childData) {
                if (!empty($childData['child_name'])) {
                    AssistanceRequestChild::create([
                        'assistance_request_id' => $assistanceRequest->id,
                        'child_name' => $childData['child_name'],
                        'child_ic' => $childData['child_ic'] ?? null,
                        'age' => $childData['age'] ?? null,
                        'school_name' => $childData['school_name'] ?? null,
                    ]);
                }
            }
        }

        $this->syncDocuments($request, $assistanceRequest);

        return redirect()->route('assistance-requests.show', $assistanceRequest)
            ->with('success', 'Permohonan telah dikemas kini');
    }

    /**
     * Submit the assistance request.
     */
    public function submit(AssistanceRequest $assistanceRequest)
    {
        if ($assistanceRequest->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $assistanceRequest->update([
            'status' => 'submitted',
            'submitted_at' => now(),
            'agent_verification' => 'pending'
        ]);

        return redirect()->route('assistance-requests.show', $assistanceRequest)
            ->with('success', 'Permohonan telah dihantar untuk semakan');
    }

    /**
     * Process agent verification.
     */
    public function verifyByAgent(Request $request, AssistanceRequest $assistanceRequest)
    {
        if (!in_array(Auth::user()->role, ['agent', 'admin'], true)) {
            abort(403);
        }

        if (Auth::user()->role === 'agent') {
            $currentAgent = Agent::where('user_id', Auth::id())->first();
            if (!$currentAgent || $assistanceRequest->agent_id !== $currentAgent->id) {
                return redirect()->route('assistance-requests.show', $assistanceRequest)
                    ->with('error', 'Permohonan ini tidak ditetapkan kepada anda.');
            }
        }

        if (!in_array($assistanceRequest->status, ['submitted', 'in_process'], true)) {
            return redirect()->route('assistance-requests.show', $assistanceRequest)
                ->with('error', 'Permohonan ini tidak boleh disemak oleh agen pada masa ini.');
        }

        $validated = $request->validate([
            'agent_verification' => 'required|in:verified,rejected',
            'rejection_reason' => 'nullable|string|required_if:agent_verification,rejected',
        ]);

        $updates = [
            'agent_verification' => $validated['agent_verification'],
            'agent_filled' => true,
        ];

        if ($validated['agent_verification'] === 'verified') {
            $updates['status'] = 'in_process';
            $updates['rejection_reason'] = null;
        } else {
            $updates['status'] = 'rejected';
            $updates['rejection_reason'] = $validated['rejection_reason'];
            $updates['approved_amount'] = null;
            $updates['approved_at'] = null;
        }

        $assistanceRequest->update($updates);

        return redirect()->route('assistance-requests.show', $assistanceRequest)
            ->with('success', $validated['agent_verification'] === 'verified'
                ? 'Permohonan telah disahkan oleh agen dan dihantar ke peringkat JK.'
                : 'Permohonan telah ditolak pada peringkat semakan agen.');
    }

    /**
     * Record JK recommendation.
     */
    public function recommendByJk(Request $request, AssistanceRequest $assistanceRequest)
    {
        if (!in_array(Auth::user()->role, ['jk', 'admin'], true)) {
            abort(403);
        }

        if ($assistanceRequest->status !== 'in_process' || $assistanceRequest->agent_verification !== 'verified') {
            return redirect()->route('assistance-requests.show', $assistanceRequest)
                ->with('error', 'Permohonan ini belum bersedia untuk pengesyoran JK.');
        }

        $validated = $request->validate([
            'jk_recommendation_status' => 'required|in:recommended,recommended_with_conditions,not_recommended',
            'jk_recommendation' => 'required|string',
        ]);

        $assistanceRequest->update([
            'jk_recommendation_status' => $validated['jk_recommendation_status'],
            'jk_recommendation' => $validated['jk_recommendation'],
        ]);

        return redirect()->route('assistance-requests.show', $assistanceRequest)
            ->with('success', 'Pengesyoran JK telah direkodkan.');
    }

    /**
     * Final decision by admin.
     */
    public function decideByAdmin(Request $request, AssistanceRequest $assistanceRequest)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        if (
            $assistanceRequest->status !== 'in_process'
            || $assistanceRequest->agent_verification !== 'verified'
            || !$assistanceRequest->jk_recommendation_status
        ) {
            return redirect()->route('assistance-requests.show', $assistanceRequest)
                ->with('error', 'Permohonan ini mesti melalui pengesyoran JK sebelum keputusan admin dibuat.');
        }

        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'approved_amount' => 'nullable|numeric|required_if:status,approved',
            'rejection_reason' => 'nullable|string|required_if:status,rejected',
        ]);

        $updates = [
            'status' => $validated['status'],
            'approved_at' => now(),
        ];

        if ($validated['status'] === 'approved') {
            $updates['approved_amount'] = $validated['approved_amount'];
            $updates['rejection_reason'] = null;
        } else {
            $updates['approved_amount'] = null;
            $updates['rejection_reason'] = $validated['rejection_reason'];
        }

        $assistanceRequest->update($updates);

        return redirect()->route('assistance-requests.show', $assistanceRequest)
            ->with('success', $validated['status'] === 'approved'
                ? 'Permohonan telah diluluskan oleh admin.'
                : 'Permohonan telah ditolak oleh admin.');
    }

    private function canViewRequest($user, AssistanceRequest $assistanceRequest): bool
    {
        if ($assistanceRequest->user_id === $user->id) {
            return true;
        }

        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'agent') {
            $agent = Agent::where('user_id', $user->id)->first();

            if ($agent) {
                return $assistanceRequest->agent_id === $agent->id;
            }

            return false;
        }

        if ($user->role === 'jk') {
            return in_array($assistanceRequest->status, ['in_process', 'approved', 'rejected'], true);
        }

        return false;
    }

    private function normalizeAssistanceRequestData(array $validated): array
    {
        foreach (['dependents_count', 'disabled_dependents_count'] as $field) {
            if (!array_key_exists($field, $validated) || $validated[$field] === null || $validated[$field] === '') {
                $validated[$field] = 0;
            }
        }

        return $validated;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssistanceRequest $assistanceRequest)
    {
        if ($assistanceRequest->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        foreach ($assistanceRequest->documents as $document) {
            Storage::disk('local')->delete($document->file_path);
        }

        $assistanceRequest->delete();

        return redirect()->route('assistance-requests.index')
            ->with('success', 'Permohonan telah dipadam');
    }

    /**
     * Get categories for a request type.
     */
    public function getCategories(RequestType $requestType)
    {
        return $requestType->categories;
    }

    /**
     * Get subcategories for a category.
     */
    public function getSubcategories(RequestCategory $requestCategory)
    {
        return $requestCategory->subcategories;
    }

    public function downloadDocument(AssistanceRequest $assistanceRequest, AssistanceRequestDocument $document)
    {
        if ($document->assistance_request_id !== $assistanceRequest->id) {
            abort(404);
        }

        if (!$this->canViewRequest(Auth::user(), $assistanceRequest)) {
            abort(403);
        }

        if (!Storage::disk('local')->exists($document->file_path)) {
            abort(404);
        }

        return response()->download(
            Storage::disk('local')->path($document->file_path),
            $document->original_name
        );
    }

    private function documentValidationRules(int $categoryId, ?AssistanceRequest $assistanceRequest = null): array
    {
        $category = RequestCategory::find($categoryId);
        $requirements = $category ? $this->documentRequirementsForCategoryName($category->name) : [];
        $rules = [];

        foreach ($requirements as $requirement) {
            $existingDocument = $assistanceRequest?->documents?->firstWhere('document_key', $requirement['key']);
            $requiredRule = $existingDocument ? 'nullable' : 'required';
            $rules['documents.' . $requirement['key']] = [
                $requiredRule,
                'file',
                'mimes:' . config('assistance_documents.accepted_mimes', 'pdf,jpg,jpeg,png'),
                'max:' . config('assistance_documents.max_size_kb', 5120),
            ];
        }

        return $rules;
    }

    private function syncDocuments(Request $request, AssistanceRequest $assistanceRequest): void
    {
        $requirements = $this->documentRequirementsForCategoryName($assistanceRequest->category->name);
        $requirementKeys = collect($requirements)->pluck('key')->all();

        $staleDocuments = empty($requirementKeys)
            ? $assistanceRequest->documents()->get()
            : $assistanceRequest->documents()->whereNotIn('document_key', $requirementKeys)->get();

        foreach ($staleDocuments as $staleDocument) {
            Storage::disk('local')->delete($staleDocument->file_path);
            $staleDocument->delete();
        }

        foreach ($requirements as $requirement) {
            $file = $request->file('documents.' . $requirement['key']);

            if (!$file) {
                continue;
            }

            $existingDocument = $assistanceRequest->documents()->where('document_key', $requirement['key'])->first();

            if ($existingDocument) {
                Storage::disk('local')->delete($existingDocument->file_path);
            }

            $storedPath = $file->storeAs(
                'assistance-documents/' . $assistanceRequest->id,
                $requirement['key'] . '-' . time() . '.' . $file->getClientOriginalExtension(),
                'local'
            );

            $assistanceRequest->documents()->updateOrCreate(
                ['document_key' => $requirement['key']],
                [
                    'document_label' => $requirement['label'],
                    'file_path' => $storedPath,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]
            );
        }
    }

    private function documentRequirementsForCategoryName(?string $categoryName): array
    {
        if (!$categoryName) {
            return [];
        }

        return config('assistance_documents.categories.' . $categoryName . '.documents', []);
    }
}
