@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <span class="page-kicker"><i class="fas fa-chart-bar"></i> Laporan</span>
            <h1 class="page-title mt-1 mb-0">Laporan Permohonan Mengikut Bulan</h1>
        </div>
        <button onclick="window.print()" class="btn no-print" style="border: 2px solid #0d9488; color: #0d9488; background: transparent; border-radius: 6px; padding: 7px 18px; font-weight: 500; transition: all .2s;" onmouseover="this.style.background='#0d9488';this.style.color='#fff'" onmouseout="this.style.background='transparent';this.style.color='#0d9488'">
            <i class="fas fa-print me-1"></i> Cetak
        </button>
    </div>

    {{-- Filter --}}
    <div class="surface-panel p-3 mb-4 no-print">
        <form method="GET" action="{{ route('admin.reports.monthly') }}" class="row g-2 align-items-end">
            <div class="col-sm-6 col-lg-2">
                <label class="form-label form-label-sm">Tahun</label>
                <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                    @foreach($availableYears as $y)
                        <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 col-lg-3">
                <label class="form-label form-label-sm">Jenis Bantuan</label>
                <select name="request_type_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Jenis</option>
                    @foreach($requestTypes as $rt)
                        <option value="{{ $rt->id }}" {{ $selectedTypeId == $rt->id ? 'selected' : '' }}>
                            {{ $rt->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @if($selectedTypeId)
            <div class="col-auto">
                <a href="{{ route('admin.reports.monthly', ['year' => $selectedYear]) }}"
                   class="btn btn-outline-secondary btn-sm" title="Padam penapis jenis">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            @endif
        </form>
    </div>

    {{-- Ringkasan Tahunan --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="surface-panel p-3 text-center">
                <div style="font-size:1.8rem;font-weight:800;color:var(--primary-color);">{{ $yearlyTotal }}</div>
                <div class="text-muted" style="font-size:0.8rem;">Jumlah Permohonan {{ $selectedYear }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="surface-panel p-3 text-center">
                <div style="font-size:1.8rem;font-weight:800;color:#2E7D32;">{{ $yearlyApproved }}</div>
                <div class="text-muted" style="font-size:0.8rem;">Diluluskan</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="surface-panel p-3 text-center">
                <div style="font-size:1.8rem;font-weight:800;color:#C62828;">{{ $yearlyRejected }}</div>
                <div class="text-muted" style="font-size:0.8rem;">Ditolak</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="surface-panel p-3 text-center">
                <div style="font-size:1.4rem;font-weight:800;color:#1565C0;">RM {{ number_format($yearlyAmount, 2) }}</div>
                <div class="text-muted" style="font-size:0.8rem;">Jumlah Bantuan Diluluskan</div>
            </div>
        </div>
    </div>

    {{-- Jadual Bulanan --}}
    <div class="surface-panel p-0 overflow-hidden mb-4">
        <div class="px-4 py-3" style="background:#f8f9fa;border-bottom:1px solid #e5e9e5;">
            <h5 class="mb-0">
                <i class="fas fa-calendar-alt text-primary me-2"></i>
                Permohonan Mengikut Bulan — {{ $selectedYear }}
                @if($selectedTypeId)
                    <span class="badge bg-secondary ms-2" style="font-size:0.75rem;">
                        {{ $requestTypes->firstWhere('id', $selectedTypeId)?->name }}
                    </span>
                @endif
            </h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:140px;">Bulan</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Draf</th>
                        <th class="text-center">Dihantar</th>
                        <th class="text-center">Dalam Proses</th>
                        <th class="text-center">
                            <span class="text-success">Lulus</span>
                        </th>
                        <th class="text-center">
                            <span class="text-danger">Tolak</span>
                        </th>
                        <th class="text-end">Amaun Lulus (RM)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $malay_months = ['','Jan','Feb','Mac','Apr','Mei','Jun','Jul','Ogos','Sep','Okt','Nov','Dis'];
                    $malay_months_full = ['','Januari','Februari','Mac','April','Mei','Jun','Julai','Ogos','September','Oktober','November','Disember'];
                    @endphp
                    @foreach($months as $m)
                    <tr class="{{ $m['total'] == 0 ? 'text-muted' : '' }}">
                        <td class="fw-semibold">
                            {{ $malay_months_full[$m['month']] }}
                        </td>
                        <td class="text-center">
                            @if($m['total'] > 0)
                                <span class="fw-bold" style="color:var(--primary-color);">{{ $m['total'] }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="{{ $m['draft'] > 0 ? '' : 'text-muted' }}">
                                {{ $m['draft'] > 0 ? $m['draft'] : '—' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="{{ $m['submitted'] > 0 ? 'text-info fw-semibold' : 'text-muted' }}">
                                {{ $m['submitted'] > 0 ? $m['submitted'] : '—' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="{{ $m['in_process'] > 0 ? 'text-warning fw-semibold' : 'text-muted' }}">
                                {{ $m['in_process'] > 0 ? $m['in_process'] : '—' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="{{ $m['approved'] > 0 ? 'text-success fw-bold' : 'text-muted' }}">
                                {{ $m['approved'] > 0 ? $m['approved'] : '—' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="{{ $m['rejected'] > 0 ? 'text-danger fw-semibold' : 'text-muted' }}">
                                {{ $m['rejected'] > 0 ? $m['rejected'] : '—' }}
                            </span>
                        </td>
                        <td class="text-end">
                            @if($m['total_approved_amount'] > 0)
                                <span class="fw-semibold" style="color:#2E7D32;">
                                    {{ number_format($m['total_approved_amount'], 2) }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot style="background:#f8f9fa;border-top:2px solid #dee2e6;">
                    <tr class="fw-bold">
                        <td>JUMLAH</td>
                        <td class="text-center" style="color:var(--primary-color);">{{ $yearlyTotal }}</td>
                        <td class="text-center">{{ $months->sum('draft') ?: '—' }}</td>
                        <td class="text-center text-info">{{ $months->sum('submitted') ?: '—' }}</td>
                        <td class="text-center text-warning">{{ $months->sum('in_process') ?: '—' }}</td>
                        <td class="text-center text-success">{{ $yearlyApproved ?: '—' }}</td>
                        <td class="text-center text-danger">{{ $yearlyRejected ?: '—' }}</td>
                        <td class="text-end" style="color:#2E7D32;">
                            {{ $yearlyAmount > 0 ? number_format($yearlyAmount, 2) : '—' }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Breakdown Mengikut Jenis Bantuan --}}
    @if(!$selectedTypeId)
    <div class="surface-panel p-0 overflow-hidden mb-4">
        <div class="px-4 py-3" style="background:#f8f9fa;border-bottom:1px solid #e5e9e5;">
            <h5 class="mb-0">
                <i class="fas fa-layer-group me-2" style="color:var(--primary-color);"></i>
                Pecahan Mengikut Jenis Bantuan — {{ $selectedYear }}
            </h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Jenis Bantuan</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center text-success">Lulus</th>
                        <th class="text-center text-danger">Tolak</th>
                        <th class="text-center">% Lulus</th>
                        <th class="text-end">Amaun Lulus (RM)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($byType as $type)
                    @if($type->total > 0)
                    <tr>
                        <td class="fw-semibold">{{ $type->name }}</td>
                        <td class="text-center">{{ $type->total }}</td>
                        <td class="text-center text-success fw-semibold">{{ $type->approved }}</td>
                        <td class="text-center text-danger">{{ $type->rejected }}</td>
                        <td class="text-center">
                            @php $pct = $type->total > 0 ? round(($type->approved / $type->total) * 100) : 0; @endphp
                            <div class="d-flex align-items-center gap-2">
                                <div class="flex-grow-1" style="background:#eee;border-radius:999px;height:6px;min-width:60px;">
                                    <div style="width:{{ $pct }}%;background:#2E7D32;border-radius:999px;height:6px;"></div>
                                </div>
                                <span style="font-size:0.82rem;min-width:32px;">{{ $pct }}%</span>
                            </div>
                        </td>
                        <td class="text-end fw-semibold" style="color:#2E7D32;">
                            {{ $type->approved_amount_sum > 0 ? number_format($type->approved_amount_sum, 2) : '—' }}
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    @if($byType->sum('total') == 0)
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Tiada data untuk tahun {{ $selectedYear }}.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Bar chart visual --}}
    <div class="surface-panel p-4 mb-4 no-print">
        <h5 class="mb-3">
            <i class="fas fa-chart-bar me-2" style="color:var(--primary-color);"></i>
            Graf Permohonan Bulanan — {{ $selectedYear }}
        </h5>
        <div id="monthChart" style="height:260px;display:flex;align-items:flex-end;gap:6px;padding-bottom:24px;position:relative;">
            @php $maxVal = $months->max('total'); @endphp
            @foreach($months as $m)
            @php
                $h = $maxVal > 0 ? round(($m['total'] / $maxVal) * 220) : 0;
                $hApproved = $maxVal > 0 && $m['total'] > 0 ? round(($m['approved'] / $maxVal) * 220) : 0;
            @endphp
            <div class="flex-fill d-flex flex-column align-items-center" style="position:relative;">
                <div style="font-size:0.7rem;color:var(--primary-color);font-weight:700;margin-bottom:3px;">
                    {{ $m['total'] > 0 ? $m['total'] : '' }}
                </div>
                <div style="width:100%;display:flex;flex-direction:column;justify-content:flex-end;align-items:center;height:220px;gap:0;">
                    <div style="width:70%;border-radius:6px 6px 0 0;height:{{ $h }}px;background:rgba(255,87,34,0.18);position:relative;overflow:hidden;">
                        <div style="position:absolute;bottom:0;width:100%;height:{{ $hApproved }}px;background:#2E7D32;opacity:0.7;border-radius:4px 4px 0 0;"></div>
                    </div>
                </div>
                <div style="font-size:0.65rem;color:#888;margin-top:4px;text-align:center;">
                    {{ $malay_months[$m['month']] }}
                </div>
            </div>
            @endforeach
        </div>
        <div class="d-flex gap-3 justify-content-center mt-1" style="font-size:0.78rem;">
            <span><span style="display:inline-block;width:12px;height:12px;background:rgba(255,87,34,0.18);border-radius:3px;vertical-align:middle;"></span> Jumlah permohonan</span>
            <span><span style="display:inline-block;width:12px;height:12px;background:#2E7D32;opacity:0.7;border-radius:3px;vertical-align:middle;"></span> Diluluskan</span>
        </div>
    </div>

    <div class="mt-2 no-print">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
@media print {
    .no-print { display: none !important; }
    .surface-panel { box-shadow: none !important; border: 1px solid #ccc; }
    .navbar, footer { display: none !important; }
    main { padding: 0 !important; }
    body { background: white !important; }
}
</style>
@endpush
