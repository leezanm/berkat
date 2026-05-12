@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <span class="page-kicker"><i class="fas fa-money-bill-wave"></i> Laporan</span>
            <h1 class="page-title mt-1 mb-0">Laporan Pembayaran Mengikut Bulan</h1>
        </div>
        <button onclick="window.print()" class="btn no-print" style="border: 2px solid #0d9488; color: #0d9488; background: transparent; border-radius: 6px; padding: 7px 18px; font-weight: 500; transition: all .2s;" onmouseover="this.style.background='#0d9488';this.style.color='#fff'" onmouseout="this.style.background='transparent';this.style.color='#0d9488'">
            <i class="fas fa-print me-1"></i> Cetak
        </button>
    </div>

    {{-- Filter --}}
    <div class="surface-panel p-3 mb-4 no-print">
        <form method="GET" action="{{ route('admin.reports.payment') }}" class="row g-2 align-items-end">
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
                <a href="{{ route('admin.reports.payment', ['year' => $selectedYear]) }}"
                   class="btn btn-outline-secondary btn-sm" title="Padam penapis jenis">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            @endif
        </form>
    </div>

    {{-- Kad Ringkasan --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="surface-panel p-3 text-center">
                <div style="font-size:1.8rem;font-weight:800;color:var(--primary-color);">{{ $yearlyCount }}</div>
                <div class="text-muted" style="font-size:0.8rem;">Jumlah Rekod Bayaran {{ $selectedYear }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="surface-panel p-3 text-center">
                <div style="font-size:1.3rem;font-weight:800;color:#2E7D32;">RM {{ number_format($yearlyAmount, 2) }}</div>
                <div class="text-muted" style="font-size:0.8rem;">Jumlah Keseluruhan Dibayar</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="surface-panel p-3 text-center">
                <div style="font-size:1.8rem;font-weight:800;color:#1565C0;">{{ $byType->count() }}</div>
                <div class="text-muted" style="font-size:0.8rem;">Jenis Bantuan Ada Pembayaran</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="surface-panel p-3 text-center">
                <div style="font-size:1.4rem;font-weight:800;color:#6A1B9A;">
                    RM {{ $yearlyCount > 0 ? number_format($yearlyAmount / $yearlyCount, 2) : '0.00' }}
                </div>
                <div class="text-muted" style="font-size:0.8rem;">Purata Setiap Bayaran</div>
            </div>
        </div>
    </div>

    {{-- Jadual Bulanan --}}
    <div class="surface-panel p-0 overflow-hidden mb-4">
        <div class="px-4 py-3" style="background:#f8f9fa;border-bottom:1px solid #e5e9e5;">
            <h5 class="mb-0">
                <i class="fas fa-calendar-alt me-2" style="color:#2E7D32;"></i>
                Pembayaran Mengikut Bulan — {{ $selectedYear }}
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
                        <th style="min-width:110px;">Bulan</th>
                        <th class="text-center">Bil. Rekod</th>
                        <th class="text-end">Jumlah Dibayar (RM)</th>
                        <th class="text-end">Purata (RM)</th>
                        <th class="text-center no-print">Nisbah</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $malay_months_full = ['','Januari','Februari','Mac','April','Mei','Jun','Julai','Ogos','September','Oktober','November','Disember'];
                    $malay_months = ['','Jan','Feb','Mac','Apr','Mei','Jun','Jul','Ogos','Sep','Okt','Nov','Dis'];
                    $maxMonthAmt = $months->max('amount');
                    @endphp
                    @foreach($months as $m)
                    <tr class="{{ $m['count'] == 0 ? 'text-muted' : '' }}">
                        <td class="fw-semibold">{{ $malay_months_full[$m['month']] }}</td>
                        <td class="text-center">
                            {{ $m['count'] > 0 ? $m['count'] : '—' }}
                        </td>
                        <td class="text-end fw-semibold" style="{{ $m['amount'] > 0 ? 'color:#2E7D32;' : '' }}">
                            {{ $m['amount'] > 0 ? number_format($m['amount'], 2) : '—' }}
                        </td>
                        <td class="text-end" style="font-size:0.88rem;">
                            {{ $m['count'] > 0 ? number_format($m['amount'] / $m['count'], 2) : '—' }}
                        </td>
                        <td class="text-center no-print">
                            @if($maxMonthAmt > 0 && $m['amount'] > 0)
                            <div style="background:#eee;border-radius:999px;height:8px;min-width:80px;max-width:160px;margin:0 auto;">
                                <div style="width:{{ round(($m['amount'] / $maxMonthAmt) * 100) }}%;background:linear-gradient(90deg,#2E7D32,#66BB6A);border-radius:999px;height:8px;"></div>
                            </div>
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
                        <td class="text-center" style="color:var(--primary-color);">{{ $yearlyCount ?: '—' }}</td>
                        <td class="text-end" style="color:#2E7D32;">
                            {{ $yearlyAmount > 0 ? 'RM '.number_format($yearlyAmount, 2) : '—' }}
                        </td>
                        <td class="text-end" style="font-size:0.88rem;">
                            {{ $yearlyCount > 0 ? 'RM '.number_format($yearlyAmount / $yearlyCount, 2) : '—' }}
                        </td>
                        <td class="no-print"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Breakdown Jenis Bantuan --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-7">
            <div class="surface-panel p-0 overflow-hidden h-100">
                <div class="px-4 py-3" style="background:#f8f9fa;border-bottom:1px solid #e5e9e5;">
                    <h5 class="mb-0">
                        <i class="fas fa-layer-group me-2" style="color:var(--primary-color);"></i>
                        Pembayaran Mengikut Jenis Bantuan — {{ $selectedYear }}
                    </h5>
                </div>
                <div class="table-responsive">
                    @if($byType->count() > 0)
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Jenis Bantuan</th>
                                <th class="text-center">Bil. Pembayaran</th>
                                <th class="text-end">Jumlah (RM)</th>
                                <th class="text-center no-print">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($byType as $type)
                            <tr>
                                <td class="fw-semibold">{{ $type['name'] }}</td>
                                <td class="text-center">{{ $type['count'] }}</td>
                                <td class="text-end fw-semibold" style="color:#2E7D32;">
                                    {{ number_format($type['total_amount'], 2) }}
                                </td>
                                <td class="text-center no-print">
                                    @php $pct = $yearlyAmount > 0 ? round(($type['total_amount'] / $yearlyAmount) * 100) : 0; @endphp
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="flex-grow-1" style="background:#eee;border-radius:999px;height:6px;min-width:50px;">
                                            <div style="width:{{ $pct }}%;background:#2E7D32;border-radius:999px;height:6px;"></div>
                                        </div>
                                        <span style="font-size:0.78rem;min-width:28px;">{{ $pct }}%</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="background:#f8f9fa;border-top:2px solid #dee2e6;">
                            <tr class="fw-bold">
                                <td>JUMLAH</td>
                                <td class="text-center">{{ $byType->sum('count') }}</td>
                                <td class="text-end" style="color:#2E7D32;">{{ number_format($yearlyAmount, 2) }}</td>
                                <td class="no-print"></td>
                            </tr>
                        </tfoot>
                    </table>
                    @else
                    <div class="p-4 text-muted text-center">Tiada rekod pembayaran untuk {{ $selectedYear }}.</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kaedah Pembayaran --}}
        <div class="col-lg-5">
            <div class="surface-panel p-0 overflow-hidden h-100">
                <div class="px-4 py-3" style="background:#f8f9fa;border-bottom:1px solid #e5e9e5;">
                    <h5 class="mb-0">
                        <i class="fas fa-credit-card me-2" style="color:#1565C0;"></i>
                        Mengikut Kaedah Bayaran — {{ $selectedYear }}
                    </h5>
                </div>
                @if($byMethod->count() > 0)
                <div class="p-4">
                    @php
                    $methodLabels = [
                        'pindahan_bank' => ['Pindahan Bank', '#1565C0'],
                        'cek'           => ['Cek',           '#6A1B9A'],
                        'tunai'         => ['Tunai',          '#E65100'],
                        'lain'          => ['Lain-lain',     '#37474F'],
                    ];
                    $maxMethodAmt = $byMethod->max('total_amount');
                    @endphp
                    <div class="d-flex flex-column gap-3">
                        @foreach($byMethod as $bm)
                        @php
                            [$label, $color] = $methodLabels[$bm->payment_method] ?? [$bm->payment_method, '#555'];
                            $pct = $maxMethodAmt > 0 ? round(($bm->total_amount / $maxMethodAmt) * 100) : 0;
                        @endphp
                        <div>
                            <div class="d-flex justify-content-between mb-1" style="font-size:0.88rem;">
                                <span class="fw-semibold">{{ $label }}</span>
                                <span class="text-muted">{{ $bm->count }} rekod</span>
                            </div>
                            <div style="background:#eee;border-radius:999px;height:10px;">
                                <div style="width:{{ $pct }}%;background:{{ $color }};border-radius:999px;height:10px;transition:width 0.5s;"></div>
                            </div>
                            <div class="text-end mt-1 fw-semibold" style="font-size:0.9rem;color:{{ $color }};">
                                RM {{ number_format($bm->total_amount, 2) }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="p-4 text-muted text-center">Tiada rekod pembayaran.</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Graf Bar Bulanan --}}
    <div class="surface-panel p-4 mb-4 no-print">
        <h5 class="mb-3">
            <i class="fas fa-chart-bar me-2" style="color:#2E7D32;"></i>
            Graf Amaun Pembayaran Bulanan — {{ $selectedYear }}
        </h5>
        <div style="height:260px;display:flex;align-items:flex-end;gap:6px;padding-bottom:28px;position:relative;">
            @php $maxAmt = $months->max('amount'); @endphp
            @foreach($months as $m)
            @php $h = $maxAmt > 0 ? max(4, round(($m['amount'] / $maxAmt) * 220)) : 0; @endphp
            <div class="flex-fill d-flex flex-column align-items-center">
                <div style="font-size:0.62rem;color:#2E7D32;font-weight:700;margin-bottom:3px;text-align:center;">
                    {{ $m['amount'] > 0 ? number_format($m['amount']/1000, 1).'k' : '' }}
                </div>
                <div style="width:100%;display:flex;flex-direction:column;justify-content:flex-end;align-items:center;height:220px;">
                    <div style="width:75%;height:{{ $h }}px;background:linear-gradient(180deg,#43A047,#1B5E20);border-radius:6px 6px 0 0;opacity:{{ $m['amount'] > 0 ? '1' : '0.15' }};"></div>
                </div>
                <div style="font-size:0.65rem;color:#888;margin-top:4px;text-align:center;">
                    {{ $malay_months[$m['month']] }}
                </div>
            </div>
            @endforeach
        </div>
        <p class="text-muted mb-0" style="font-size:0.78rem;text-align:center;">
            * Nilai dalam ribuan (k). Bulan tiada bayaran ditunjukkan sebagai bar kosong.
        </p>
    </div>

    <div class="mt-2 no-print">
        <a href="{{ route('admin.reports.monthly') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-chart-bar"></i> Laporan Bulanan
        </a>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Dashboard
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
