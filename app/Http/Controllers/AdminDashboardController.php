<?php

namespace App\Http\Controllers;

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

        $selectedYear = $request->query('year');

        if ($selectedYear !== null && !$availableYears->contains((string) $selectedYear)) {
            $selectedYear = null;
        }

        $baseQuery = AssistanceRequest::query()
            ->when($selectedYear, function ($query, $year) {
                $query->whereYear('created_at', (int) $year);
            });

        $totalRequests = (clone $baseQuery)->count();
        $submittedRequests = (clone $baseQuery)->where('status', 'submitted')->count();
        $inProcessRequests = (clone $baseQuery)->where('status', 'in_process')->count();
        $approvedRequests = (clone $baseQuery)->where('status', 'approved')->count();
        $rejectedRequests = (clone $baseQuery)->where('status', 'rejected')->count();
        $totalApprovedAmount = (clone $baseQuery)->where('status', 'approved')->sum('approved_amount');

        $latestRequests = (clone $baseQuery)
            ->with(['user', 'requestType', 'agent'])
            ->latest()
            ->take(8)
            ->get();

        $requestTypeSummary = RequestType::withCount('categories')
            ->get()
            ->map(function ($type) use ($selectedYear) {
                $type->requests_count = AssistanceRequest::query()
                    ->where('request_type_id', $type->id)
                    ->when($selectedYear, function ($query, $year) {
                        $query->whereYear('created_at', (int) $year);
                    })
                    ->count();

                return $type;
            })
            ->sortByDesc('requests_count')
            ->take(5)
            ->values();

        return view('admin.dashboard', compact(
            'totalRequests',
            'submittedRequests',
            'inProcessRequests',
            'approvedRequests',
            'rejectedRequests',
            'totalApprovedAmount',
            'latestRequests',
            'requestTypeSummary',
            'availableYears',
            'selectedYear'
        ));
    }
}
