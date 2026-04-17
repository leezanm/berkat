@extends('layouts.app')

@section('content')
<div class="container py-4 py-lg-5">
    <div class="row justify-content-center align-items-stretch g-4">
        <div class="col-lg-5 col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <div class="py-2">
                        <span class="page-kicker mb-3"><i class="fas fa-lock"></i> Akses Pengguna</span>
                        <h3 class="mb-2 text-white">Masuk ke Sistem BERKAT</h3>
                        <p class="mb-0" style="color: rgba(255,255,255,0.8);">Selamat kembali. Sila masukkan maklumat anda untuk meneruskan.</p>
                    </div>
                </div>
                <div class="card-body p-4 p-lg-4">
                    <form action="{{ route('login') }}" method="POST" novalidate class="section-stack">
                        @csrf

                        <div>
                            <label for="email" class="form-label"><i class="fas fa-envelope"></i> Emel <span style="color: var(--danger-color);">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="contoh@berkat.com">
                            <div class="form-hint">Gunakan emel akaun yang telah didaftarkan dalam sistem.</div>
                            @error('email') <span class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="password" class="form-label"><i class="fas fa-lock"></i> Kata Laluan <span style="color: var(--danger-color);">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Masukkan kata laluan anda">
                            @error('password') <span class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-sign-in-alt"></i> Masuk
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="stat-card stat-card-dark h-100 mb-0">
                <div style="font-size: 2.25rem;"><i class="fas fa-key"></i></div>
                <div class="text-white-50" style="font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.08em;">Akses Ujian</div>
                <div style="font-size: 1.55rem; font-weight: 700;">Akaun contoh untuk semakan sistem</div>
                <div class="soft-panel" style="background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.08);">
                    <div class="mb-3">
                        <span class="detail-label" style="color: rgba(255,255,255,0.65);">Member</span>
                        <p class="mb-1 text-white">member@test.com</p>
                        <p class="mb-0" style="color: rgba(255,255,255,0.72);">Kata laluan: password</p>
                    </div>
                    <div>
                        <span class="detail-label" style="color: rgba(255,255,255,0.65);">Lain-lain</span>
                        <p class="mb-1 text-white">agent@berkat.com</p>
                        <p class="mb-1 text-white">jk@berkat.com</p>
                        <p class="mb-0 text-white">admin@berkat.com</p>
                    </div>
                </div>
                <p class="mb-0" style="color: rgba(255,255,255,0.72);">Semua akaun ujian menggunakan kata laluan yang sama untuk tujuan demonstrasi.</p>
            </div>
        </div>
    </div>
</div>
@endsection
