<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssistanceRequest;
use App\Models\Payment;
use App\Models\RequestType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function monthly(Request $request)
    {
        // Available years
        $availableYears = AssistanceRequest::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->filter()
            ->values();

        $selectedYear = $request->query('year', now()->year);

        // Validate year
        if (!$availableYears->contains((int) $selectedYear)) {
            $selectedYear = $availableYears->first() ?? now()->year;
        }

        $selectedTypeId = $request->query('request_type_id');

        $requestTypes = RequestType::orderBy('name')->get();

        // Monthly summary: 12 bulan
        $months = collect(range(1, 12))->map(function ($month) use ($selectedYear, $selectedTypeId) {
            $base = AssistanceRequest::whereRaw('YEAR(created_at) = ?', [(int) $selectedYear])
                ->whereRaw('MONTH(created_at) = ?', [$month])
                ->when($selectedTypeId, fn ($q) => $q->where('request_type_id', $selectedTypeId));

            return [
                'month'       => $month,
                'total'       => (clone $base)->count(),
                'draft'       => (clone $base)->where('status', 'draft')->count(),
                'submitted'   => (clone $base)->where('status', 'submitted')->count(),
                'in_process'  => (clone $base)->where('status', 'in_process')->count(),
                'approved'    => (clone $base)->where('status', 'approved')->count(),
                'rejected'    => (clone $base)->where('status', 'rejected')->count(),
                'total_approved_amount' => (clone $base)->where('status', 'approved')->sum('approved_amount'),
            ];
        });

        // Breakdown by request type for the selected year
        $byType = RequestType::withCount([
            'assistanceRequests as total' => function ($q) use ($selectedYear) {
                $q->whereRaw('YEAR(created_at) = ?', [(int) $selectedYear]);
            },
            'assistanceRequests as approved' => function ($q) use ($selectedYear) {
                $q->whereRaw('YEAR(created_at) = ?', [(int) $selectedYear])
                  ->where('status', 'approved');
            },
            'assistanceRequests as rejected' => function ($q) use ($selectedYear) {
                $q->whereRaw('YEAR(created_at) = ?', [(int) $selectedYear])
                  ->where('status', 'rejected');
            },
        ])
        ->withSum([
            'assistanceRequests as approved_amount_sum' => function ($q) use ($selectedYear) {
                $q->whereRaw('YEAR(created_at) = ?', [(int) $selectedYear])
                  ->where('status', 'approved');
            }
        ], 'approved_amount')
        ->orderByDesc('total')
        ->get();

        // Yearly totals
        $yearlyTotal    = $months->sum('total');
        $yearlyApproved = $months->sum('approved');
        $yearlyRejected = $months->sum('rejected');
        $yearlyAmount   = $months->sum('total_approved_amount');

        return view('admin.reports.monthly', compact(
            'months', 'availableYears', 'selectedYear',
            'requestTypes', 'selectedTypeId',
            'byType', 'yearlyTotal', 'yearlyApproved', 'yearlyRejected', 'yearlyAmount'
        ));
    }

    public function payment(Request $request)
    {
        // Available years based on payment_date
        $availableYears = Payment::selectRaw('YEAR(payment_date) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->filter()
            ->values();

        // Fallback to assistance_requests years if no payments yet
        if ($availableYears->isEmpty()) {
            $availableYears = collect([now()->year]);
        }

        $selectedYear = (int) $request->query('year', now()->year);
        if (!$availableYears->contains($selectedYear)) {
            $selectedYear = (int) ($availableYears->first() ?? now()->year);
        }

        $selectedTypeId = $request->query('request_type_id');
        $requestTypes   = RequestType::orderBy('name')->get();

        // Monthly payment summary
        $months = collect(range(1, 12))->map(function ($month) use ($selectedYear, $selectedTypeId) {
            $base = Payment::whereRaw('YEAR(payment_date) = ?', [$selectedYear])
                ->whereRaw('MONTH(payment_date) = ?', [$month])
                ->when($selectedTypeId, fn ($q) => $q->whereHas('assistanceRequest', fn ($r) =>
                    $r->where('request_type_id', $selectedTypeId)
                ));

            $count  = (clone $base)->count();
            $amount = (clone $base)->sum('amount');

            // Breakdown by method
            $methods = (clone $base)->selectRaw('payment_method, COUNT(*) as cnt, SUM(amount) as total')
                ->groupBy('payment_method')
                ->pluck('cnt', 'payment_method');

            return [
                'month'   => $month,
                'count'   => $count,
                'amount'  => $amount,
                'methods' => $methods,
            ];
        });

        // Breakdown by request type
        $byType = RequestType::get()->map(function ($type) use ($selectedYear) {
            $payments = Payment::whereRaw('YEAR(payment_date) = ?', [$selectedYear])
                ->whereHas('assistanceRequest', fn ($q) => $q->where('request_type_id', $type->id))
                ->selectRaw('COUNT(*) as count, SUM(amount) as total_amount')
                ->first();

            return [
                'name'         => $type->name,
                'count'        => $payments->count ?? 0,
                'total_amount' => $payments->total_amount ?? 0,
            ];
        })->filter(fn ($t) => $t['count'] > 0)->sortByDesc('total_amount')->values();

        // Breakdown by payment method
        $byMethod = Payment::whereRaw('YEAR(payment_date) = ?', [$selectedYear])
            ->when($selectedTypeId, fn ($q) => $q->whereHas('assistanceRequest', fn ($r) =>
                $r->where('request_type_id', $selectedTypeId)
            ))
            ->selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total_amount')
            ->groupBy('payment_method')
            ->get();

        $yearlyCount  = $months->sum('count');
        $yearlyAmount = $months->sum('amount');

        return view('admin.reports.payment', compact(
            'months', 'availableYears', 'selectedYear',
            'requestTypes', 'selectedTypeId',
            'byType', 'byMethod',
            'yearlyCount', 'yearlyAmount'
        ));
    }
}
