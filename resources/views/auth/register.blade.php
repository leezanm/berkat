@extends('layouts.app_login')

@push('styles')
<style>
    main { padding: 0 !important; }

    .login-wrapper {
        display: flex;
        min-height: calc(100vh - 62px);
        overflow: hidden;
    }

    /* Left: image panel */
    .login-img-panel {
        flex: 0 0 58%;
        position: relative;
        background-image: url("{{ asset('images/login_img.jpeg') }}");
        background-size: cover;
        background-position: center;
        min-height: 500px;
    }

    .login-img-panel::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(160deg, rgba(0,0,0,0.28) 0%, rgba(0,0,0,0.05) 60%);
    }

    .login-img-caption {
        position: absolute;
        bottom: 2.5rem;
        left: 2.5rem;
        right: 2.5rem;
        z-index: 2;
        color: #fff;
    }

    .login-img-caption h2 {
        font-size: 1.45rem;
        font-weight: 700;
        text-shadow: 0 2px 10px rgba(0,0,0,0.5);
        margin-bottom: 0.35rem;
    }

    .login-img-caption p {
        font-size: 0.92rem;
        opacity: 0.9;
        text-shadow: 0 1px 6px rgba(0,0,0,0.4);
        margin: 0;
    }

    /* Right: form panel */
    .login-form-panel {
        flex: 0 0 42%;
        background: #fff;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 2.5rem 3.25rem;
        overflow-y: auto;
    }

    .login-logo {
        width: 72px;
        height: 72px;
        object-fit: contain;
    }

    .login-info-banner {
        background: rgba(255, 87, 34, 0.07);
        border: 1px solid rgba(255, 87, 34, 0.22);
        border-radius: 10px;
        padding: 0.85rem 1.1rem;
    }

    .login-info-banner .banner-title {
        color: var(--primary-color);
        font-weight: 600;
        font-size: 0.95rem;
    }

    .login-info-banner .banner-sub {
        color: #666;
        font-size: 0.83rem;
        margin-top: 0.1rem;
    }

    .login-form-panel .form-control-lg {
        border-radius: 10px;
        border: 1.5px solid #e0e0e0;
        font-size: 0.95rem;
        transition: border-color 0.2s;
    }

    .login-form-panel .form-control-lg:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(255,87,34,0.12);
    }

    .login-divider {
        border: none;
        border-top: 1px solid #f0f0f0;
        margin: 1.1rem 0;
    }

    @media (max-width: 768px) {
        .login-img-panel { display: none; }
        .login-form-panel { flex: 0 0 100%; padding: 2rem 1.5rem; }
        .login-wrapper { min-height: calc(100vh - 56px); }
    }
</style>
@endpush

@section('content')
<div class="login-wrapper">

    {{-- Left: Image --}}
    <div class="login-img-panel">
        <div class="login-img-caption">
            <h2>Badan Kebajikan Perkhidmatan<br>Perakaunan Negara Malaysia</h2>
            <p>Sistem Pengurusan Permohonan Bantuan BERKAT</p>
        </div>
    </div>

    {{-- Right: Form --}}
    <div class="login-form-panel">

        {{-- Logo & Title --}}
        <div class="text-center mb-4">
            <img src="{{ asset('images/berkat-logo.jpeg') }}" alt="Logo BERKAT" class="login-logo mb-3">
            <h3 class="fw-bold mb-1" style="color: var(--text-dark); font-size: 1.4rem; line-height: 1.3;">
                Pendaftaran Ahli Baharu
            </h3>
            <p class="text-muted mb-0" style="font-size: 0.87rem;">
                Jabatan Akauntan Negara Malaysia
            </p>
        </div>

        {{-- Info banner --}}
        <div class="login-info-banner mb-4">
            <div class="d-flex align-items-start gap-2">
                <i class="fas fa-info-circle mt-1" style="color: var(--primary-color); font-size: 1rem;"></i>
                <div>
                    <div class="banner-title">Pendaftaran Pengguna Baru</div>
                    <div class="banner-sub">Sila lengkapkan maklumat di bawah untuk pendaftaran.</div>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('register') }}" method="POST" novalidate>
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold" style="font-size: 0.9rem;">
                    <i class="fas fa-user"></i> Nama Penuh <span style="color: var(--danger-color);">*</span>
                </label>
                <input type="text"
                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                    id="name" name="name"
                    value="{{ old('name') }}"
                    required
                    placeholder="Masukkan nama penuh anda">
                @error('name')
                    <span class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold" style="font-size: 0.9rem;">
                    <i class="fas fa-envelope"></i> Emel <span style="color: var(--danger-color);">*</span>
                </label>
                <input type="email"
                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                    id="email" name="email"
                    value="{{ old('email') }}"
                    required
                    placeholder="contoh@emel.com">
                @error('email')
                    <span class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold" style="font-size: 0.9rem;">
                    <i class="fas fa-lock"></i> Kata Laluan <span style="color: var(--danger-color);">*</span>
                </label>
                <input type="password"
                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                    id="password" name="password"
                    required
                    placeholder="Minimum 8 aksara">
                @error('password')
                    <span class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-semibold" style="font-size: 0.9rem;">
                    <i class="fas fa-lock"></i> Sahkan Kata Laluan <span style="color: var(--danger-color);">*</span>
                </label>
                <input type="password"
                    class="form-control form-control-lg"
                    id="password_confirmation" name="password_confirmation"
                    required
                    placeholder="Ulang kata laluan">
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100" style="border-radius: 10px; font-weight: 600; letter-spacing: 0.02em;">
                <i class="fas fa-user-plus"></i> Daftar Sebagai Ahli
            </button>
        </form>

        <hr class="login-divider">

        <div class="text-center">
            <span class="text-muted" style="font-size: 0.87rem;">Sudah ada akaun?</span>
            <a href="{{ route('login') }}" style="color: var(--primary-color); font-size: 0.87rem; font-weight: 600;"> Log masuk di sini</a>
        </div>

    </div>
</div>
@endsection
