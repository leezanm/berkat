<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\AssistanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Senarai semua pembayaran.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['assistanceRequest.requestType', 'user'])
            ->latest('payment_date');

        // Filter tahun
        if ($year = $request->query('filter_year')) {
            $query->whereRaw('YEAR(payment_date) = ?', [(int) $year]);
        }

        // Filter kaedah
        if ($method = $request->query('filter_method')) {
            $query->where('payment_method', $method);
        }

        // Filter nama pemohon
        if ($name = $request->query('filter_applicant')) {
            $query->whereHas('assistanceRequest', function ($q) use ($name) {
                $q->where('applicant_name', 'like', "%{$name}%");
            });
        }

        $payments = $query->paginate(15)->withQueryString();

        $availableYears = Payment::selectRaw('YEAR(payment_date) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $totalPaid = Payment::sum('amount');

        return view('admin.payments.index', compact(
            'payments', 'availableYears', 'totalPaid'
        ));
    }

    /**
     * Borang rekod pembayaran baru untuk permohonan yang diluluskan.
     */
    public function create(Request $request)
    {
        $assistanceRequestId = $request->query('assistance_request_id');
        $assistanceRequest   = null;

        if ($assistanceRequestId) {
            $assistanceRequest = AssistanceRequest::with(['requestType', 'user'])
                ->where('status', 'approved')
                ->findOrFail($assistanceRequestId);
        }

        // Senarai permohonan diluluskan yang belum ada pembayaran penuh
        $approvedRequests = AssistanceRequest::with(['requestType', 'user'])
            ->where('status', 'approved')
            ->orderByDesc('approved_at')
            ->get();

        return view('admin.payments.create', compact('assistanceRequest', 'approvedRequests'));
    }

    /**
     * Simpan rekod pembayaran baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'assistance_request_id' => ['required', 'exists:assistance_requests,id'],
            'amount'                => ['required', 'numeric', 'min:0.01'],
            'payment_method'        => ['required', 'in:pindahan_bank,cek,tunai,lain'],
            'payment_reference'     => ['nullable', 'string', 'max:100'],
            'payment_date'          => ['required', 'date'],
            'notes'                 => ['nullable', 'string', 'max:1000'],
        ]);

        $assistanceRequest = AssistanceRequest::where('status', 'approved')
            ->findOrFail($validated['assistance_request_id']);

        Payment::create([
            'assistance_request_id' => $assistanceRequest->id,
            'user_id'               => $assistanceRequest->user_id,
            'paid_by'               => Auth::id(),
            'amount'                => $validated['amount'],
            'payment_method'        => $validated['payment_method'],
            'payment_reference'     => $validated['payment_reference'] ?? null,
            'payment_date'          => $validated['payment_date'],
            'notes'                 => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Rekod pembayaran berjaya disimpan.');
    }

    /**
     * Papar detail satu rekod pembayaran.
     */
    public function show(Payment $payment)
    {
        $payment->load(['assistanceRequest.requestType', 'user', 'paidByUser']);
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Padam rekod pembayaran.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Rekod pembayaran berjaya dipadam.');
    }
}
