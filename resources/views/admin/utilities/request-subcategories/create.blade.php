@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><i class="fas fa-plus-circle"></i> Tambah Sub-Kategori Bantuan Baru</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('admin.request-subcategories.store') }}" method="POST">
                @csrf

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="request_category_id" class="form-label">Kategori Bantuan <span class="text-danger">*</span></label>
                            <select class="form-select @error('request_category_id') is-invalid @enderror" id="request_category_id" name="request_category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('request_category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->requestType->name }} - {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('request_category_id') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Sub-Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Keterangan</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label"><i class="fas fa-money-bill"></i> Amaun Bantuan (RM)</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}" step="0.01" min="0">
                            <div class="form-text">Tinggalkan kosong jika tidak ada amaun tetap.</div>
                            @error('amount') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('admin.request-subcategories.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
