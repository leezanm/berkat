@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4 align-items-end">
        <div class="col-lg-8">
            <span class="page-kicker"><i class="fas fa-user-tie"></i> Pengurusan</span>
            <h3><i class="fas fa-users"></i> Senarai Agen</h3>
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

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.agents.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label"><i class="fas fa-search"></i> Nama Agen</label>
                        <input type="text" name="search_name" class="form-control" placeholder="Nama agen atau kakitangan" value="{{ $searchName ?? '' }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label"><i class="fas fa-calendar"></i> Tahun</label>
                        <select name="filter_year" class="form-select">
                            <option value="">Semua Tahun</option>
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}" {{ ($filterYear ?? '') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><i class="fas fa-list-alt"></i> Jenis Bantuan</label>
                        <select name="filter_type_id" class="form-select">
                            <option value="">Semua Jenis</option>
                            @foreach($requestTypes as $type)
                                <option value="{{ $type->id }}" {{ ($filterTypeId ?? '') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label"><i class="fas fa-user"></i> Nama Pemohon</label>
                        <input type="text" name="filter_applicant" class="form-control" placeholder="Nama pemohon" value="{{ $filterApplicant ?? '' }}">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="fas fa-search"></i> Tapis
                        </button>
                        @if($searchName || $filterYear || $filterTypeId || $filterApplicant)
                            <a href="{{ route('admin.agents.index') }}" class="btn btn-outline-secondary" title="Reset">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
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
