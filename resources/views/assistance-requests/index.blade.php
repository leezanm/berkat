@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-5 align-items-center">
        <div class="col-md-8">
            <h1><i class="fas fa-list"></i> Senarai Permohonan Bantuan</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('assistance-requests.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Permohonan Baru
            </a>
        </div>
    </div>

    <!-- Stats Row -->
    @if(auth()->check())
        <div class="row mb-5">
            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-dark">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div style="font-size: 0.9rem; opacity: 0.8;">Jumlah Permohonan</div>
                    <div style="font-size: 2rem; margin-top: 0.5rem; font-weight: 700;">{{ $requests->total() }}</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-orange">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div style="font-size: 0.9rem; opacity: 0.9;">Diluluskan</div>
                    <div style="font-size: 2rem; margin-top: 0.5rem; font-weight: 700;">
                        {{ $requests->getCollection()->where('status', 'approved')->count() }}
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-light">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem; color: var(--primary-color);">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div style="font-size: 0.9rem; color: var(--text-muted);">Sedang Proses</div>
                    <div style="font-size: 2rem; margin-top: 0.5rem; font-weight: 700; color: var(--text-dark);">
                        {{ $requests->getCollection()->whereIn('status', ['submitted', 'in_process'])->count() }}
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-light">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem; color: var(--primary-color);">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div style="font-size: 0.9rem; color: var(--text-muted);">Draf</div>
                    <div style="font-size: 2rem; margin-top: 0.5rem; font-weight: 700; color: var(--text-dark);">
                        {{ $requests->getCollection()->where('status', 'draft')->count() }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($requests->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag"></i> No. Rujukan</th>
                        <th><i class="fas fa-briefcase"></i> Jenis Permohonan</th>
                        <th><i class="fas fa-calendar-alt"></i> Tarikh Dihantar</th>
                        <th><i class="fas fa-chart-pie"></i> Status</th>
                        <th><i class="fas fa-money-bill-wave"></i> Jumlah</th>
                        <th><i class="fas fa-cog"></i> Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                        <tr>
                            <td>
                                <span class="fw-bold">#{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>
                                <span class="d-inline-block" style="color: var(--primary-color); font-weight: 600;">
                                    {{ $request->requestType->name }}
                                </span>
                            </td>
                            <td>
                                {!! $request->submitted_at ? $request->submitted_at->format('d M Y') : '<span class="text-muted">-</span>' !!}
                            </td>
                            <td>
                                <span class="badge bg-{{ $request->getStatusBadgeClass() }}">
                                    <i class="fas fa-{{ $request->getStatusIcon() }}"></i>
                                    {{ $request->getStatusLabel() }}
                                </span>
                            </td>
                            <td>
                                @if($request->approved_amount)
                                    <span style="color: var(--success-color); font-weight: 600;">RM {{ number_format($request->approved_amount, 2) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('assistance-requests.show', $request) }}" class="btn btn-sm btn-primary" title="Lihat Butiran">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($request->status === 'draft' && auth()->id() === $request->user_id)
                                    <a href="{{ route('assistance-requests.edit', $request) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            <div class="pagination-info">
                Menunjukkan {{ $requests->firstItem() }} hingga {{ $requests->lastItem() }} dari {{ $requests->total() }} hasil
            </div>
            {{ $requests->links() }}
        </div>
    @else
        <div class="card border-0 bg-light">
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem; opacity: 0.6;"></i>
                <h4 class="mt-3 mb-3" style="color: var(--text-dark);">Tiada Permohonan</h4>
                <p class="text-muted mb-4">Anda belum membuat sebarang permohonan. Mulai dengan membuat permohonan baru sekarang.</p>
                <a href="{{ route('assistance-requests.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus-circle"></i> Buat Permohonan Baru
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
