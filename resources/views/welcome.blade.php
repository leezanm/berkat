@extends('layouts.app')

@section('content')
<div class="container py-4 py-lg-5">
    <div class="surface-panel p-4 p-lg-5">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-lg-8">
                <span class="page-kicker"><i class="fas fa-sparkles"></i> Sistem Bantuan BERKAT</span>
                <h1 class="mb-4">Permohonan bantuan yang lebih tersusun, cepat dan meyakinkan.</h1>
                <p class="page-subtitle mb-4">
                    Platform ini direka supaya proses menghantar, menyemak dan menjejak permohonan bantuan terasa lebih profesional, lebih jelas dan lebih mudah untuk semua peranan dalam organisasi.
                </p>

                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-xl-4">
                        <div class="detail-item h-100">
                            <span class="detail-label"><i class="fas fa-pen-fancy"></i> Mudah</span>
                            <p class="detail-value mb-2">Aliran borang lebih jelas</p>
                            <p class="mb-0 text-muted">Pengguna boleh fokus pada maklumat penting tanpa rasa serabut.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="detail-item h-100">
                            <span class="detail-label"><i class="fas fa-shield-alt"></i> Selamat</span>
                            <p class="detail-value mb-2">Maklumat lebih terjaga</p>
                            <p class="mb-0 text-muted">Reka letak yang bersih memudahkan semakan dan mengurangkan kesilapan input.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="detail-item h-100">
                            <span class="detail-label"><i class="fas fa-bolt"></i> Pantas</span>
                            <p class="detail-value mb-2">Tindakan utama lebih menonjol</p>
                            <p class="mb-0 text-muted">Setiap skrin memberi penekanan jelas pada tindakan seterusnya.</p>
                        </div>
                    </div>
                </div>

                @auth
                    <div class="soft-panel d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                        <div>
                            <span class="page-kicker mb-3"><i class="fas fa-user-check"></i> Log masuk aktif</span>
                            <h4 class="mb-2">{{ Auth::user()->name }}</h4>
                            <p class="mb-0 text-muted">
                                Peranan semasa:
                                <strong>{{ Auth::user()->role === 'member' ? 'Ahli' : (Auth::user()->role === 'agent' ? 'Agen' : (Auth::user()->role === 'jk' ? 'Jawatankuasa' : 'Admin')) }}</strong>
                            </p>
                        </div>
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                                    <i class="fas fa-chart-line"></i> Dashboard Admin
                                </a>
                            @endif
                            <a href="{{ route('assistance-requests.index') }}" class="btn btn-secondary">
                                <i class="fas fa-list"></i> Lihat Permohonan
                            </a>
                            <a href="{{ route('assistance-requests.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Buat Permohonan
                            </a>
                        </div>
                    </div>
                @else
                    <div class="soft-panel d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                        <div>
                            <span class="page-kicker mb-3"><i class="fas fa-door-open"></i> Akses sistem</span>
                            <h4 class="mb-2">Mulakan dengan log masuk</h4>
                            <p class="mb-0 text-muted">Masuk ke sistem untuk menghantar permohonan baru atau menyemak status permohonan sedia ada.</p>
                        </div>
                        <div>
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> Log Masuk Sistem
                            </a>
                        </div>
                    </div>
                @endauth
            </div>

            <div class="col-lg-4">
                <div class="stat-card stat-card-dark mb-3">
                    <div style="font-size: 2.6rem;"><i class="fas fa-hand-holding-heart"></i></div>
                    <div class="text-white-50" style="font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.08em;">Pengalaman sistem</div>
                    <div style="font-size: 1.8rem; font-weight: 700;">Lebih moden, lebih tersusun</div>
                    <p class="mb-0" style="color: rgba(255,255,255,0.72);">Gabungan tona oren, arang dan permukaan cerah memberi rasa profesional tanpa nampak terlalu berat.</p>
                </div>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="stat-card stat-card-light">
                            <div style="font-size: 2rem; color: var(--primary-color);"><i class="fas fa-layer-group"></i></div>
                            <div class="detail-label">Struktur</div>
                            <div class="detail-value">Kad & panel lebih kemas</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="stat-card stat-card-orange">
                            <div style="font-size: 2rem;"><i class="fas fa-arrow-trend-up"></i></div>
                            <div class="text-white-50" style="font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.08em;">Fokus</div>
                            <div style="font-size: 1.2rem; font-weight: 700;">CTA lebih jelas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
