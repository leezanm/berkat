@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4 align-items-end">
        <div class="col-lg-8">
            <span class="page-kicker"><i class="fas fa-cogs"></i> Utiliti Admin</span>
            <h1><i class="fas fa-list"></i> Senarai Jenis Bantuan</h1>
            <p class="page-subtitle">Urus semua jenis bantuan yang tersedia dalam sistem BERKAT.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <a href="{{ route('admin.request-types.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Tambah Jenis Bantuan
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

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th><i class="fas fa-hashtag"></i> No.</th>
                        <th><i class="fas fa-heading"></i> Nama Jenis Bantuan</th>
                        <th><i class="fas fa-tasks"></i> Bilangan Kategori</th>
                        <th><i class="fas fa-cogs"></i> Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requestTypes as $requestType)
                        <tr>
                            <td>{{ $requestType->id }}</td>
                            <td>{{ $requestType->name }}</td>
                            <td><span class="badge bg-info">{{ $requestType->categories()->count() }}</span></td>
                            <td>
                                <a href="{{ route('admin.request-types.edit', $requestType) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.request-types.destroy', $requestType) }}" method="POST" style="display: inline;" onsubmit="return confirm('Padam jenis bantuan ini?');">
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
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-inbox"></i> Tiada data jenis bantuan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($requestTypes->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $requestTypes->links() }}
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
