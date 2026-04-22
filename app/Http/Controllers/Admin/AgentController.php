<?php

namespace App\Http\Controllers\Admin;

use App\Models\Agent;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgentController extends Controller
{
    /**
     * Display a listing of agents
     */
    public function index(Request $request)
    {
        $query = Agent::with('user');
        $searchName = $request->get('search_name');

        if ($searchName) {
            $query->whereHas('user', function ($q) use ($searchName) {
                $q->where('name', 'like', "%{$searchName}%");
            })->orWhere('staff_name', 'like', "%{$searchName}%");
        }

        $agents = $query->paginate(15);

        return view('admin.agents.index', compact('agents', 'searchName'));
    }

    /**
     * Show the form for creating a new agent
     */
    public function create()
    {
        // Get users that are not yet agents
        $usersNotAgents = User::where('role', 'agent')
            ->whereDoesntHave('agent')
            ->get();

        return view('admin.agents.create', compact('usersNotAgents'));
    }

    /**
     * Store a newly created agent
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:agents,user_id',
            'staff_name' => 'required|string|max:255',
            'staff_ic' => 'required|string|max:12',
            'staff_email' => 'required|email',
            'staff_mobile' => 'required|string|max:20',
            'accounting_office' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'grade' => 'nullable|string|max:50',
            'office_name' => 'required|string|max:255',
            'office_address' => 'nullable|string',
            'office_phone' => 'nullable|string|max:20',
            'office_email' => 'nullable|email',
            'status' => 'required|in:active,on_leave,suspended',
        ]);

        $validated['registered_by'] = auth()->id();
        $validated['registered_at'] = now();

        Agent::create($validated);

        return redirect()->route('admin.agents.index')
            ->with('success', 'Agen berjaya ditambah');
    }

    /**
     * Show the form for editing an agent
     */
    public function edit(Agent $agent)
    {
        $agent->load('user');

        return view('admin.agents.edit', compact('agent'));
    }

    /**
     * Update the specified agent
     */
    public function update(Request $request, Agent $agent)
    {
        $validated = $request->validate([
            'staff_name' => 'required|string|max:255',
            'staff_ic' => 'required|string|max:12',
            'staff_email' => 'required|email',
            'staff_mobile' => 'required|string|max:20',
            'accounting_office' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'grade' => 'nullable|string|max:50',
            'office_name' => 'required|string|max:255',
            'office_address' => 'nullable|string',
            'office_phone' => 'nullable|string|max:20',
            'office_email' => 'nullable|email',
            'status' => 'required|in:active,on_leave,suspended',
        ]);

        $agent->update($validated);

        return redirect()->route('admin.agents.index')
            ->with('success', 'Maklumat agen berjaya dikemas kini');
    }

    /**
     * Delete an agent
     */
    public function destroy(Agent $agent)
    {
        // Check if agent has verified requests
        if ($agent->verifiedRequests()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Tidak dapat memadam agen kerana mempunyai permohonan yang disahkan');
        }

        $agent->delete();

        return redirect()->route('admin.agents.index')
            ->with('success', 'Agen berjaya dipadam');
    }
}
