@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4 align-items-end">
        <div class="col-lg-8">
            <span class="page-kicker"><i class="fas fa-user-tie"></i> Pengurusan</span>
            <h1><i class="fas fa-users"></i> Senarai Agen</h1>
            <p class="page-subtitle">Papar dan urus maklumat kakitangan agen yang disahkan oleh Jabatan Akauntan Negara.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <a href="{{ route('admin.agents.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Tambah Agen Baharu
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.agents.index') }}" class="d-flex flex-column flex-md-row gap-3 align-items-md-center">
                <div class="flex-grow-1">
                    <label for="search_name" class="form-label mb-2 mb-md-0"><i class="fas fa-search"></i> Cari Mengikut Nama</label>
                    <input type="text" id="search_name" name="search_name" class="form-control" placeholder="Nama agen atau kakitangan" value="{{ $searchName ?? '' }}">
                </div>
                <div class="d-flex gap-2 pt-2 pt-md-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    @if($searchName)
                        <a href="{{ route('admin.agents.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times-circle"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Agents Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th><i class="fas fa-hashtag"></i> No.</th>
                        <th><i class="fas fa-user"></i> Nama (Login)</th>
                        <th><i class="fas fa-id-card"></i> No. KP</th>
                        <th><i class="fas fa-signature"></i> Nama Kakitangan</th>
                        <th><i class="fas fa-building"></i> Pejabat Perakaunan</th>
                        <th><i class="fas fa-briefcase"></i> Jawatan</th>
                        <th><i class="fas fa-badge"></i> Status</th>
                        <th><i class="fas fa-cogs"></i> Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agents as $agent)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $agent->user->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $agent->user->email }}</small>
                            </td>
                            <td>{{ $agent->staff_ic }}</td>
                            <td>{{ $agent->staff_name }}</td>
                            <td>{{ $agent->accounting_office }}</td>
                            <td>
                                {{ $agent->position }}
                                @if($agent->grade)
                                    <br><small class="text-muted">{{ $agent->grade }}</small>
                                @endif
                            </td>
                            <td>
                                @if($agent->status === 'active')
                                    <span class="badge bg-success"><i class="fas fa-check-circle"></i> Aktif</span>
                                @elseif($agent->status === 'on_leave')
                                    <span class="badge bg-warning"><i class="fas fa-clock"></i> Cuti</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-ban"></i> Digantung</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.agents.edit', $agent) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.agents.destroy', $agent) }}" method="POST" style="display: inline;" onsubmit="return confirm('Padam agen ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Padam">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-inbox"></i> Tiada data agen.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($agents->hasPages())
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Menunjukkan {{ $agents->firstItem() }} hingga {{ $agents->lastItem() }} dari {{ $agents->total() }} agen
                </div>
                {{ $agents->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
