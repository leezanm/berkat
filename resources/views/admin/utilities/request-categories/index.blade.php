@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4 align-items-end">
        <div class="col-lg-8">
            <span class="page-kicker"><i class="fas fa-cogs"></i> Utiliti Admin</span>
            <h1><i class="fas fa-folder"></i> Senarai Kategori Bantuan</h1>
            <p class="page-subtitle">Urus semua kategori bantuan yang tersedia dalam sistem BERKAT.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <a href="{{ route('admin.request-categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Tambah Kategori
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
            <form method="GET" action="{{ route('admin.request-categories.index') }}" class="d-flex flex-column flex-md-row gap-3 align-items-md-center">
                <div class="flex-grow-1">
                    <label for="type_id" class="form-label mb-2 mb-md-0"><i class="fas fa-filter"></i> Penapis Jenis Bantuan</label>
                    <select id="type_id" name="type_id" class="form-select">
                        <option value="">Semua Jenis Bantuan</option>
                        @foreach($requestTypes as $type)
                            <option value="{{ $type->id }}" {{ $selectedType == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex gap-2 pt-2 pt-md-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Tapis
                    </button>
                    @if($selectedType)
                        <a href="{{ route('admin.request-categories.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times-circle"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th><i class="fas fa-hashtag"></i> No.</th>
                        <th><i class="fas fa-list"></i> Jenis Bantuan</th>
                        <th><i class="fas fa-heading"></i> Nama Kategori</th>
                        <th><i class="fas fa-tags"></i> Bilangan Sub-Kategori</th>
                        <th><i class="fas fa-cogs"></i> Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td><span class="badge bg-secondary">{{ $category->requestType->name }}</span></td>
                            <td>{{ $category->name }}</td>
                            <td><span class="badge bg-info">{{ $category->subcategories()->count() }}</span></td>
                            <td>
                                <a href="{{ route('admin.request-categories.edit', $category) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.request-categories.destroy', $category) }}" method="POST" style="display: inline;" onsubmit="return confirm('Padam kategori ini?');">
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
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-inbox"></i> Tiada data kategori bantuan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($categories->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $categories->links() }}
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
