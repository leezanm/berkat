@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-end">
        <div class="col-lg-8">
            <span class="page-kicker"><i class="fas fa-chart-line"></i> Dashboard Admin</span>
            <h1>Ringkasan Pentadbiran BERKAT</h1>
            <p class="page-subtitle">Paparan ringkas untuk melihat prestasi permohonan, status semasa dan rekod terkini tanpa perlu masuk ke setiap permohonan satu per satu.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <a href="{{ route('assistance-requests.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> Senarai Permohonan
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3">
            <div>
                <span class="detail-label">Penapis Data</span>
                <p class="mb-0 text-muted">
                    {{ $selectedYear ? 'Memaparkan data untuk tahun ' . $selectedYear : 'Memaparkan semua tahun permohonan.' }}
                </p>
            </div>
            <form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex flex-column flex-sm-row gap-2 align-items-sm-center">
                <label for="year" class="form-label mb-0">Tahun Permohonan</label>
                <select id="year" name="year" class="form-select">
                    <option value="">Semua Tahun</option>
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ (string) $selectedYear === (string) $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Tapis</button>
                @if($selectedYear)
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-soft">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="stat-card stat-card-dark">
                <div style="font-size: 2.2rem;"><i class="fas fa-folder-open"></i></div>
                <div style="font-size: 0.88rem; opacity: 0.8;">Jumlah Permohonan</div>
                <div style="font-size: 2rem; font-weight: 700;">{{ $totalRequests }}</div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card stat-card-light">
                <div style="font-size: 2.2rem; color: var(--primary-color);"><i class="fas fa-user-clock"></i></div>
                <div class="detail-label">Menunggu Agen</div>
                <div class="detail-value" style="font-size: 1.9rem;">{{ $submittedRequests }}</div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card stat-card-orange">
                <div style="font-size: 2.2rem;"><i class="fas fa-people-group"></i></div>
                <div style="font-size: 0.88rem; opacity: 0.9;">Dalam Proses</div>
                <div style="font-size: 2rem; font-weight: 700;">{{ $inProcessRequests }}</div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card stat-card-light">
                <div style="font-size: 2.2rem; color: var(--success-color);"><i class="fas fa-sack-dollar"></i></div>
                <div class="detail-label">Jumlah Diluluskan</div>
                <div class="detail-value" style="font-size: 1.45rem;">RM {{ number_format($totalApprovedAmount, 2) }}</div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card mb-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-clock-rotate-left"></i> Permohonan Terkini</h5>
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
                                    <th>Agen</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestRequests as $request)
                                    <tr>
                                        <td>#{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $request->user->name }}</div>
                                            <div class="text-muted small">{{ $request->submitted_at?->format('d M Y') ?? 'Belum dihantar' }}</div>
                                        </td>
                                        <td>{{ $request->requestType->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $request->getStatusBadgeClass() }}">
                                                {{ $request->getStatusLabel() }}
                                            </span>
                                        </td>
                                        <td>{{ $request->agent?->name ?? 'Belum ditetapkan' }}</td>
                                        <td>
                                            <a href="{{ route('assistance-requests.show', $request) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">Tiada data permohonan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="section-stack">
                <div class="card mb-0">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Ringkasan Status</h5>
                    </div>
                    <div class="card-body section-stack">
                        <div class="detail-item">
                            <span class="detail-label">Diluluskan</span>
                            <p class="detail-value text-success">{{ $approvedRequests }} permohonan</p>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Ditolak</span>
                            <p class="detail-value text-danger">{{ $rejectedRequests }} permohonan</p>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Tindakan Segera</span>
                            <p class="detail-value">{{ $submittedRequests + $inProcessRequests }} permohonan perlukan semakan lanjut</p>
                        </div>
                    </div>
                </div>

                <div class="card mb-0">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-layer-group"></i> Kategori Aktif</h5>
                    </div>
                    <div class="card-body section-stack">
                        @foreach($requestTypeSummary as $type)
                            <div class="detail-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="detail-label">{{ $type->name }}</span>
                                    <p class="detail-value">{{ $type->categories_count }} kategori</p>
                                </div>
                                <span class="badge bg-info">{{ $type->requests_count }} permohonan</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- <div class="card mb-0">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-cogs"></i> Utiliti Pentadbiran</h5>
                    </div>
                    <div class="card-body section-stack">
                        <div class="detail-item">
                            <a href="{{ route('admin.request-types.index') }}" class="btn btn-outline-primary w-100 justify-content-start">
                                <i class="fas fa-list me-2"></i> Urus Jenis Bantuan
                            </a>
                        </div>
                        <div class="detail-item">
                            <a href="{{ route('admin.request-categories.index') }}" class="btn btn-outline-primary w-100 justify-content-start">
                                <i class="fas fa-folder me-2"></i> Urus Kategori Bantuan
                            </a>
                        </div>
                        <div class="detail-item">
                            <a href="{{ route('admin.request-subcategories.index') }}" class="btn btn-outline-primary w-100 justify-content-start">
                                <i class="fas fa-tags me-2"></i> Urus Sub-Kategori & Amaun
                            </a>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection
