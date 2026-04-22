@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><i class="fas fa-user-plus"></i> Tambah Agen Baharu</h1>
            <p class="text-muted">Daftarkan kakitangan JAN yang akan bertindak sebagai agen pengesahan permohonan bantuan BERKAT.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.agents.store') }}" method="POST" novalidate>
                        @csrf

                        <!-- User Selection -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label"><i class="fas fa-user"></i> Pilih Pengguna Sistem <span class="text-danger">*</span></label>
                            <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                <option value="">Pilih Pengguna</option>
                                @foreach($usersNotAgents as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <hr>

                        <!-- Staff Information -->
                        <div class="mb-3">
                            <label for="staff_name" class="form-label"><i class="fas fa-signature"></i> Nama Kakitangan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('staff_name') is-invalid @enderror" id="staff_name" name="staff_name" value="{{ old('staff_name') }}" required>
                            @error('staff_name') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="staff_ic" class="form-label"><i class="fas fa-id-card"></i> No. KP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('staff_ic') is-invalid @enderror" id="staff_ic" name="staff_ic" value="{{ old('staff_ic') }}" maxlength="12" required>
                                @error('staff_ic') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="staff_email" class="form-label"><i class="fas fa-envelope"></i> Email Kakitangan <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('staff_email') is-invalid @enderror" id="staff_email" name="staff_email" value="{{ old('staff_email') }}" required>
                                @error('staff_email') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="staff_mobile" class="form-label"><i class="fas fa-mobile-alt"></i> No. HP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('staff_mobile') is-invalid @enderror" id="staff_mobile" name="staff_mobile" value="{{ old('staff_mobile') }}" required>
                            @error('staff_mobile') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <hr>

                        <!-- Office Information -->
                        <div class="mb-3">
                            <label for="accounting_office" class="form-label"><i class="fas fa-building"></i> Pejabat Perakaunan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('accounting_office') is-invalid @enderror" id="accounting_office" name="accounting_office" value="{{ old('accounting_office') }}" required>
                            @error('accounting_office') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="position" class="form-label"><i class="fas fa-briefcase"></i> Jawatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position') }}" required>
                                @error('position') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="grade" class="form-label"><i class="fas fa-badge"></i> Gred</label>
                                <input type="text" class="form-control @error('grade') is-invalid @enderror" id="grade" name="grade" value="{{ old('grade') }}">
                                @error('grade') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="office_name" class="form-label"><i class="fas fa-landmark"></i> Nama Pejabat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('office_name') is-invalid @enderror" id="office_name" name="office_name" value="{{ old('office_name') }}" required>
                            @error('office_name') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="office_address" class="form-label"><i class="fas fa-map-marker-alt"></i> Alamat Pejabat</label>
                            <textarea class="form-control @error('office_address') is-invalid @enderror" id="office_address" name="office_address" rows="2">{{ old('office_address') }}</textarea>
                            @error('office_address') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="office_phone" class="form-label"><i class="fas fa-phone"></i> No. Telefon Pejabat</label>
                                <input type="text" class="form-control @error('office_phone') is-invalid @enderror" id="office_phone" name="office_phone" value="{{ old('office_phone') }}">
                                @error('office_phone') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="office_email" class="form-label"><i class="fas fa-envelope-open"></i> Email Pejabat</label>
                                <input type="email" class="form-control @error('office_email') is-invalid @enderror" id="office_email" name="office_email" value="{{ old('office_email') }}">
                                @error('office_email') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <hr>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label"><i class="fas fa-toggle-on"></i> Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="on_leave" {{ old('status') === 'on_leave' ? 'selected' : '' }}>Cuti</option>
                                <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>Digantung</option>
                            </select>
                            @error('status') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Agen
                            </button>
                            <a href="{{ route('admin.agents.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
