@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h3><i class="fas fa-plus-circle"></i> Tambah Kategori Bantuan Baru</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('admin.request-categories.store') }}" method="POST">
                @csrf

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="request_type_id" class="form-label">Jenis Bantuan <span class="text-danger">*</span></label>
                            <select class="form-select @error('request_type_id') is-invalid @enderror" id="request_type_id" name="request_type_id" required>
                                <option value="">Pilih Jenis Bantuan</option>
                                @foreach($requestTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('request_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('request_type_id') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Huraian</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('admin.request-categories.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
