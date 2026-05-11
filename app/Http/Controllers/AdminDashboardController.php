<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AssistanceRequest;
use App\Models\RequestType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $availableYears = AssistanceRequest::query()
            ->selectRaw('DISTINCT strftime("%Y", created_at) as year')
            ->whereNotNull('created_at')
            ->orderByDesc('year')
            ->pluck('year')
            ->filter()
            ->values();

        $selectedYear  = $request->query('year');
        $selectedMonth = $request->query('month');

        if ($selectedYear !== null && !$availableYears->contains((string) $selectedYear)) {
            $selectedYear = null;
        }

        if ($selectedMonth !== null && (!is_numeric($selectedMonth) || $selectedMonth < 1 || $selectedMonth > 12)) {
            $selectedMonth = null;
        }

        // Month filter only applies when a year is selected
        if (!$selectedYear) {
            $selectedMonth = null;
        }

        $baseQuery = AssistanceRequest::query()
            ->when($selectedYear, function ($query, $year) {
                $query->whereRaw('strftime("%Y", created_at) = ?', [(string) $year]);
            })
            ->when($selectedMonth, function ($query, $month) {
                $query->whereRaw('strftime("%m", created_at) = ?', [str_pad($month, 2, '0', STR_PAD_LEFT)]);
            });

        $totalRequests = (clone $baseQuery)->count();
        $submittedRequests = (clone $baseQuery)->where('status', 'submitted')->count();
        $inProcessRequests = (clone $baseQuery)->where('status', 'in_process')->count();
        $approvedRequests = (clone $baseQuery)->where('status', 'approved')->count();
        $rejectedRequests = (clone $baseQuery)->where('status', 'rejected')->count();
        $totalApprovedAmount = (clone $baseQuery)->where('status', 'approved')->sum('approved_amount');

        $actionRequests = (clone $baseQuery)
            ->with(['user', 'requestType', 'agent'])
            ->whereIn('status', ['submitted', 'in_process'])
            ->latest()
            ->take(10)
            ->get();

        $requestCountsByType = (clone $baseQuery)
            ->selectRaw('request_type_id, count(*) as total')
            ->groupBy('request_type_id')
            ->pluck('total', 'request_type_id');

        $requestTypeSummary = RequestType::withCount('categories')
            ->get()
            ->each(function ($type) use ($requestCountsByType) {
                $type->requests_count = $requestCountsByType->get($type->id, 0);
            })
            ->sortByDesc('requests_count')
            ->values();

        $agentSummary = Agent::with('user')
            ->get()
            ->map(function ($agent) use ($selectedYear, $selectedMonth) {
                $q = AssistanceRequest::query()
                    ->where('agent_id', $agent->id)
                    ->when($selectedYear, fn ($query, $year) => $query->whereRaw('strftime("%Y", created_at) = ?', [(string) $year]))
                    ->when($selectedMonth, fn ($query, $month) => $query->whereRaw('strftime("%m", created_at) = ?', [str_pad($month, 2, '0', STR_PAD_LEFT)]));

                $agent->total_assigned = (clone $q)->count();
                $agent->pending_count  = (clone $q)->whereIn('status', ['submitted', 'in_process'])->count();
                $agent->approved_count = (clone $q)->where('status', 'approved')->count();
                $agent->rejected_count = (clone $q)->where('status', 'rejected')->count();

                return $agent;
            })
            ->sortByDesc('total_assigned')
            ->values();

        return view('admin.dashboard', compact(
            'totalRequests',
            'submittedRequests',
            'inProcessRequests',
            'approvedRequests',
            'rejectedRequests',
            'totalApprovedAmount',
            'actionRequests',
            'requestTypeSummary',
            'agentSummary',
            'availableYears',
            'selectedYear',
            'selectedMonth'
        ));
    }
}
