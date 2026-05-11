@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="row mb-4 align-items-center">
        <div class="col-lg-6">
            <span class="page-kicker"><i class="fas fa-chart-line"></i> Dashboard Admin</span>
            <h3 class="mb-1">Pelaporan Ringkas</h3>
            <p class="page-subtitle mb-0">
                @if($selectedYear && $selectedMonth)
                    Data untuk {{ \Carbon\Carbon::createFromDate(null, $selectedMonth, 1)->translatedFormat('F') }} {{ $selectedYear }}
                @elseif($selectedYear)
                    Data untuk tahun {{ $selectedYear }}
                @else
                    Semua tahun permohonan
                @endif
            </p>
        </div>
        <div class="col-lg-6 mt-3 mt-lg-0 d-flex flex-column flex-sm-row justify-content-lg-end gap-2 align-items-sm-center">
            <form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex flex-row gap-2 align-items-center" id="dashboard-filter-form">
                <select name="year" class="form-select form-select-sm" style="min-width: 115px;" onchange="document.getElementById('dashboard-filter-form').submit()">
                    <option value="">Semua Tahun</option>
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ (string) $selectedYear === (string) $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
                <select name="month" class="form-select form-select-sm" style="min-width: 130px;" onchange="document.getElementById('dashboard-filter-form').submit()" {{ !$selectedYear ? 'disabled' : '' }}>
                    <option value="">Semua Bulan</option>
                    @foreach([
                        1=>'Januari', 2=>'Februari', 3=>'Mac', 4=>'April',
                        5=>'Mei', 6=>'Jun', 7=>'Julai', 8=>'Ogos',
                        9=>'September', 10=>'Oktober', 11=>'November', 12=>'Disember'
                    ] as $num => $name)
                        <option value="{{ $num }}" {{ (string) $selectedMonth === (string) $num ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @if($selectedYear || $selectedMonth)
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-soft text-nowrap">Reset</a>
                @endif
            </form>
            <a href="{{ route('assistance-requests.index') }}" class="btn btn-sm btn-secondary text-nowrap">
                <i class="fas fa-list"></i> Senarai Permohonan
            </a>
        </div>
    </div>

    {{-- Stats Row 1 --}}
    <div class="row g-3 mb-3">
        <div class="col-6 col-xl-2">
            <div class="stat-card stat-card-dark text-center py-3">
                <div style="font-size: 1.8rem;"><i class="fas fa-folder-open"></i></div>
                <div style="font-size: 0.8rem; opacity: 0.8; margin-top: 0.25rem;">Jumlah</div>
                <div style="font-size: 1.8rem; font-weight: 700;">{{ $totalRequests }}</div>
            </div>
        </div>
        <div class="col-6 col-xl-2">
            <div class="stat-card stat-card-light text-center py-3">
                <div style="font-size: 1.8rem; color: var(--primary-color);"><i class="fas fa-user-clock"></i></div>
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">Menunggu Agen</div>
                <div style="font-size: 1.8rem; font-weight: 700; color: var(--text-dark);">{{ $submittedRequests }}</div>
            </div>
        </div>
        <div class="col-6 col-xl-2">
            <div class="stat-card stat-card-orange text-center py-3">
                <div style="font-size: 1.8rem;"><i class="fas fa-people-group"></i></div>
                <div style="font-size: 0.8rem; opacity: 0.9; margin-top: 0.25rem;">Dalam Proses</div>
                <div style="font-size: 1.8rem; font-weight: 700;">{{ $inProcessRequests }}</div>
            </div>
        </div>
        <div class="col-6 col-xl-2">
            <div class="stat-card stat-card-light text-center py-3">
                <div style="font-size: 1.8rem; color: var(--success-color);"><i class="fas fa-check-circle"></i></div>
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">Diluluskan</div>
                <div style="font-size: 1.8rem; font-weight: 700; color: var(--success-color);">{{ $approvedRequests }}</div>
            </div>
        </div>
        <div class="col-6 col-xl-2">
            <div class="stat-card stat-card-light text-center py-3">
                <div style="font-size: 1.8rem; color: var(--danger-color);"><i class="fas fa-times-circle"></i></div>
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">Ditolak</div>
                <div style="font-size: 1.8rem; font-weight: 700; color: var(--danger-color);">{{ $rejectedRequests }}</div>
            </div>
        </div>
        <div class="col-6 col-xl-2">
            <div class="stat-card stat-card-light text-center py-3">
                <div style="font-size: 1.8rem; color: var(--success-color);"><i class="fas fa-sack-dollar"></i></div>
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">Wang Diluluskan</div>
                <div style="font-size: 1.1rem; font-weight: 700; color: var(--text-dark); margin-top: 0.15rem;">RM {{ number_format($totalApprovedAmount, 2) }}</div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="row g-4 mb-4">

        {{-- Action Requests --}}
        <div class="col-lg-8">
            <div class="card h-100 mb-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-exclamation-circle"></i> Permohonan Perlu Tindakan</h5>
                    <a href="{{ route('assistance-requests.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>No. Rujukan</th>
                                    <th>Pemohon</th>
                                    <th>Jenis</th>
                                    <th>Status</th>
                                    <th class="text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($actionRequests as $request)
                                    <tr>
                                        <td class="fw-bold text-nowrap">#{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $request->user->name }}</div>
                                            <div class="text-muted small">{{ $request->submitted_at?->format('d M Y') ?? 'Belum dihantar' }}</div>
                                        </td>
                                        <td class="small">{{ $request->requestType->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $request->getStatusBadgeClass() }}">
                                                {{ $request->getStatusLabel() }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('assistance-requests.show', $request) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4"><i class="fas fa-check-circle text-success me-1"></i> Tiada permohonan yang memerlukan tindakan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4 d-flex flex-column gap-4">
            <div class="card mb-0">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-layer-group"></i> Permohonan Mengikut Jenis Bantuan</h5>
                </div>
                <div class="card-body section-stack">
                    @foreach($requestTypeSummary as $type)
                        <div class="detail-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="detail-label">{{ $type->name }}</span>
                                <p class="detail-value mb-0 text-muted" style="font-size:0.8rem;">{{ $type->categories_count }} kategori</p>
                            </div>
                            <span class="badge bg-info" title="{{ $type->requests_count }} permohonan">{{ $type->requests_count }} <span class="fw-normal" style="font-size:0.75em;">permohonan</span></span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card mb-0">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt"></i> Tindakan Segera</h5>
                </div>
                <div class="card-body">
                    @php $urgent = $submittedRequests + $inProcessRequests; @endphp
                    @if($urgent > 0)
                        <p class="mb-2">
                            <span class="badge bg-warning me-1">{{ $urgent }}</span>
                            permohonan memerlukan semakan lanjut.
                        </p>
                        <a href="{{ route('assistance-requests.index') }}" class="btn btn-sm btn-warning w-100">
                            <i class="fas fa-arrow-right me-1"></i> Semak Sekarang
                        </a>
                    @else
                        <p class="text-muted mb-0"><i class="fas fa-check-circle text-success me-1"></i> Tiada tindakan segera diperlukan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Agent Summary --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-user-tie"></i> Ringkasan Pemprosesan Mengikut Agen</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Agen</th>
                            <th>Pejabat</th>
                            <th class="text-center">Ditetapkan</th>
                            <th class="text-center">Sedang Proses</th>
                            <th class="text-center">Diluluskan</th>
                            <th class="text-center">Ditolak</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($agentSummary as $agent)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $agent->staff_name }}</div>
                                    <div class="text-muted small">{{ $agent->staff_email }}</div>
                                </td>
                                <td class="small">{{ $agent->office_name }}</td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $agent->total_assigned }}</span>
                                </td>
                                <td class="text-center">
                                    @if($agent->pending_count > 0)
                                        <span class="badge bg-warning">{{ $agent->pending_count }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($agent->approved_count > 0)
                                        <span class="badge bg-success">{{ $agent->approved_count }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($agent->rejected_count > 0)
                                        <span class="badge bg-danger">{{ $agent->rejected_count }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $agent->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ $agent->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Tiada agen didaftarkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
