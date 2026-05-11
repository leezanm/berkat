@extends('layouts.app_login')

@push('styles')
<style>
/* ──────────────────────────────────────────────────────────
   HERO — full-width photo background (FWD-inspired)
   ────────────────────────────────────────────────────────── */
.hero-bg {
    position: relative;
    min-height: calc(100vh - 72px);
    background-image: url("{{ asset('images/login_img.jpeg') }}");
    background-size: cover;
    background-position: center top;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        105deg,
        rgba(8,8,20,0.90) 0%,
        rgba(8,8,20,0.72) 55%,
        rgba(8,8,20,0.28) 100%
    );
}
.hero-content {
    position: relative;
    z-index: 2;
    padding-top: 4rem;
}
.hero-title {
    font-size: clamp(2rem, 4.8vw, 3.6rem);
    font-weight: 900;
    line-height: 1.12;
    color: #fff;
    letter-spacing: -0.015em;
}
.hero-sub {
    font-size: 1rem;
    color: rgba(255,255,255,0.70);
    max-width: 540px;
    line-height: 1.75;
}
.hero-org-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255,255,255,0.09);
    border: 1px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.80);
    padding: 0.35rem 0.9rem;
    border-radius: 99px;
    font-size: 0.77rem;
    font-weight: 600;
    letter-spacing: 0.04em;
    margin-bottom: 1.4rem;
}
.hero-user-panel {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.14);
    border-radius: 14px;
    padding: 1.4rem;
    color: #fff;
}

/* ──────────────────────────────────────────────────────────
   BANTUAN CARD STRIP — horizontal row at hero bottom
   ────────────────────────────────────────────────────────── */
.bantuan-strip {
    position: relative;
    z-index: 2;
    padding-top: 3rem;
}
.bantuan-strip-inner {
    display: flex;
    gap: 0.9rem;
    overflow-x: auto;
    padding-bottom: 2.5rem;
    scrollbar-width: none;
    -ms-overflow-style: none;
}
.bantuan-strip-inner::-webkit-scrollbar { display: none; }

/* Small white card */
.bcard {
    background: #fff;
    border-radius: 14px;
    padding: 1.15rem 1.1rem;
    min-width: 155px;
    max-width: 172px;
    flex-shrink: 0;
    box-shadow: 0 6px 24px rgba(0,0,0,0.28);
    transition: transform 0.18s, box-shadow 0.18s;
    text-decoration: none;
    color: inherit;
    display: block;
}
.bcard:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 40px rgba(0,0,0,0.38);
    text-decoration: none;
    color: inherit;
}
.bcard-label {
    font-size: 0.67rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 0.6rem;
}
.bcard-icon {
    font-size: 1.5rem;
    color: var(--primary-color);
    margin-bottom: 0.45rem;
    display: block;
}
.bcard-title {
    font-size: 0.92rem;
    font-weight: 700;
    color: #1a1a2e;
    line-height: 1.3;
}
.bcard-sub {
    font-size: 0.71rem;
    color: #aaa;
    margin-top: 0.2rem;
    line-height: 1.4;
}

/* Orange CTA card */
.bcard-cta {
    background: var(--primary-color);
    border-radius: 14px;
    padding: 1.15rem 1.1rem;
    min-width: 145px;
    max-width: 162px;
    flex-shrink: 0;
    box-shadow: 0 6px 24px rgba(255,87,34,0.45);
    transition: transform 0.18s, box-shadow 0.18s, background 0.18s;
    text-decoration: none;
    color: #fff;
    display: flex;
    flex-direction: column;
    justify-content: center;
    font-weight: 700;
    font-size: 0.88rem;
    line-height: 1.4;
}
.bcard-cta:hover {
    background: var(--primary-dark);
    color: #fff;
    text-decoration: none;
    transform: translateY(-5px);
    box-shadow: 0 14px 40px rgba(255,87,34,0.55);
}

/* ──────────────────────────────────────────────────────────
   STATS BAR
   ────────────────────────────────────────────────────────── */
.stats-bar {
    background: #fff;
    border-bottom: 1px solid #efefef;
    padding: 1.5rem 0;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}
.stat-item {
    text-align: center;
    padding: 0.5rem 1rem;
    border-right: 1px solid #eee;
}
.stat-item:last-child { border-right: none; }
.stat-num {
    font-size: 1.9rem;
    font-weight: 800;
    color: var(--primary-color);
    line-height: 1;
}
.stat-label { font-size: 0.77rem; color: #999; margin-top: 0.2rem; }

/* ──────────────────────────────────────────────────────────
   BANTUAN DETAIL SECTION
   ────────────────────────────────────────────────────────── */
.section-kicker {
    display: inline-block;
    background: rgba(255,87,34,0.1);
    color: var(--primary-color);
    padding: 0.3rem 0.9rem;
    border-radius: 99px;
    font-size: 0.77rem;
    font-weight: 600;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    margin-bottom: 0.75rem;
}
.section-title { font-size: 1.75rem; font-weight: 800; color: var(--text-dark); }
.bantuan-card {
    background: #fff;
    border: 1.5px solid #f0f0f0;
    border-radius: 16px;
    padding: 1.75rem;
    height: 100%;
    transition: box-shadow 0.2s, border-color 0.2s, transform 0.2s;
}
.bantuan-card:hover {
    box-shadow: 0 8px 32px rgba(255,87,34,0.12);
    border-color: rgba(255,87,34,0.28);
    transform: translateY(-3px);
}
.bantuan-card .bc-icon {
    width: 52px; height: 52px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; margin-bottom: 1rem; color: #fff;
}
.bantuan-card .bc-title { font-size: 1.05rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.4rem; }
.bantuan-card .bc-desc  { font-size: 0.83rem; color: #999; margin-bottom: 0.9rem; }
.bantuan-card .bc-list  { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.4rem; }
.bantuan-card .bc-list li { font-size: 0.82rem; color: #555; display: flex; align-items: flex-start; gap: 0.45rem; }
.bantuan-card .bc-list li::before { content: '›'; color: var(--primary-color); font-weight: 700; flex-shrink: 0; }

/* ──────────────────────────────────────────────────────────
   PROCESS STEPS
   ────────────────────────────────────────────────────────── */
.step-wrap { background: #f8f8f8; border-top: 1px solid #efefef; border-bottom: 1px solid #efefef; padding: 4rem 0; }
.step-num {
    width: 52px; height: 52px; border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: #fff; font-size: 1.2rem; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1rem;
    box-shadow: 0 4px 16px rgba(255,87,34,0.3);
}

/* ──────────────────────────────────────────────────────────
   CTA BOTTOM
   ────────────────────────────────────────────────────────── */
.cta-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, #c62828 100%);
    padding: 4rem 0;
    position: relative;
    overflow: hidden;
}
.cta-section::before {
    content: ''; position: absolute;
    top: -60px; right: -60px;
    width: 300px; height: 300px;
    border-radius: 50%;
    background: rgba(255,255,255,0.07);
}

/* ── Mobile ─────────────────────────────────────────────── */
@media (max-width: 767px) {
    .hero-bg { min-height: auto; }
    .hero-content { padding-top: 2.5rem; }
}
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════════════
     HERO — full-width photo, heading + floating bantuan cards
     ═══════════════════════════════════════════════════════════ --}}
<div class="hero-bg">
    <div class="hero-overlay"></div>

    {{-- ── Top content: heading + CTA ── --}}
    <div class="hero-content container">
        <div class="row gy-4 align-items-start">

            {{-- Left: title + subtitle + buttons --}}
            <div class="col-lg-7">
                <div class="hero-org-tag">
                    <img src="{{ asset('images/berkat-logo.jpeg') }}" alt="BERKAT" style="width:28px;height:28px;object-fit:contain;border-radius:6px;">
                    <span style="font-size:0.95rem;">Sistem Pengurusan Permohonan Bantuan</span>
                </div>

                <div class="d-flex align-items-center gap-3 mb-4">
                    <h6 class="hero-title mb-0">
                        Badan Kebajikan Perkhidmatan Perakaunan Negara Malaysia<br>
                        <span style="color:var(--primary-color);">BERKAT.</span>
                    </h6>
                </div>

                <p class="hero-sub mb-4">
                    Mohon bantuan pendidikan, kesihatan, kebajikan dan lebih lagi melalui satu platform yang mudah, pantas dan telus.
                </p>

                @auth
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('assistance-requests.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus-circle"></i> Buat Permohonan
                        </a>
                        <a href="{{ route('assistance-requests.index') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-list"></i> Semak Status
                        </a>
                    </div>
                @else
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt"></i> Log Masuk
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-user-plus"></i> Daftar Percuma
                        </a>
                    </div>
                @endauth
            </div>

            {{-- Right: logged-in user panel (desktop only) --}}
            @auth
            <div class="col-lg-4 col-xl-3 d-none d-lg-block">
                <div class="hero-user-panel">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width:42px;height:42px;border-radius:50%;background:rgba(255,87,34,0.22);display:flex;align-items:center;justify-content:center;color:var(--primary-color);flex-shrink:0;">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <div style="font-size:0.69rem;color:rgba(255,255,255,0.48);text-transform:uppercase;letter-spacing:0.05em;">Selamat kembali</div>
                            <div style="font-weight:700;font-size:0.95rem;">{{ Auth::user()->name }}</div>
                        </div>
                    </div>
                    <div style="font-size:0.8rem;color:rgba(255,255,255,0.6);background:rgba(255,255,255,0.06);padding:0.6rem 0.9rem;border-radius:8px;">
                        Peranan:
                        <strong style="color:#fff;">
                            {{ match(Auth::user()->role) {
                                'member' => 'Ahli',
                                'agent'  => 'Agen',
                                'jk'     => 'Jawatankuasa',
                                default  => 'Admin'
                            } }}
                        </strong>
                    </div>
                    @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary w-100 mt-3 btn-sm">
                        <i class="fas fa-chart-line"></i> Dashboard Admin
                    </a>
                    @endif
                </div>
            </div>
            @endauth

        </div>
    </div>

    {{-- ── Bottom: bantuan cards strip (like FWD product cards) ── --}}
    <div class="bantuan-strip">
        <div class="container">
            <div class="bantuan-strip-inner">

                {{-- Pendidikan --}}
                <div class="bcard">
                    <div class="bcard-label" style="color:#1565C0;">Bantuan Pendidikan</div>
                    <i class="fas fa-graduation-cap bcard-icon"></i>
                    <div class="bcard-title">Pendidikan</div>
                    <div class="bcard-sub">Persekolahan · IPT · Kecemerlangan</div>
                </div>

                {{-- Kesihatan --}}
                <div class="bcard">
                    <div class="bcard-label" style="color:#2E7D32;">Bantuan Kesihatan</div>
                    <i class="fas fa-heartbeat bcard-icon"></i>
                    <div class="bcard-title">Kesihatan</div>
                    <div class="bcard-sub">Rawatan · Ubatan · Peralatan OKU</div>
                </div>

                {{-- Kebajikan --}}
                <div class="bcard">
                    <div class="bcard-label" style="color:#BF360C;">Bantuan Kebajikan</div>
                    <i class="fas fa-hands-helping bcard-icon"></i>
                    <div class="bcard-title">Kebajikan</div>
                    <div class="bcard-sub">Bencana · Kematian · Kesusahan</div>
                </div>

                {{-- Sosial --}}
                <div class="bcard">
                    <div class="bcard-label" style="color:#6A1B9A;">Bantuan Sosial</div>
                    <i class="fas fa-star bcard-icon"></i>
                    <div class="bcard-title">Sosial</div>
                    <div class="bcard-sub">Perayaan · Kecemerlangan</div>
                </div>

                {{-- Keahlian --}}
                <div class="bcard">
                    <div class="bcard-label" style="color:#AD1457;">Bantuan Keahlian</div>
                    <i class="fas fa-id-badge bcard-icon"></i>
                    <div class="bcard-title">Keahlian</div>
                    <div class="bcard-sub">Persaraan · Pertukaran</div>
                </div>

                {{-- Orange CTA card --}}
                @auth
                    <a href="{{ route('assistance-requests.create') }}" class="bcard-cta">
                        <i class="fas fa-plus-circle" style="font-size:1.4rem;margin-bottom:0.5rem;"></i>
                        Buat Permohonan Sekarang
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bcard-cta">
                        <i class="fas fa-user-plus" style="font-size:1.4rem;margin-bottom:0.5rem;"></i>
                        Daftar &amp; Mula Mohon
                    </a>
                @endauth

            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     STATS BAR
     ═══════════════════════════════════════════════════════════ --}}
<div class="stats-bar">
    <div class="container">
        <div class="row g-0 justify-content-center">
            <div class="col-6 col-md-3 col-lg-2">
                <div class="stat-item">
                    <div class="stat-num">5</div>
                    <div class="stat-label">Jenis Bantuan</div>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <div class="stat-item">
                    <div class="stat-num">20+</div>
                    <div class="stat-label">Kategori Bantuan</div>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <div class="stat-item">
                    <div class="stat-num">JAN</div>
                    <div class="stat-label">Jabatan Akauntan Negara</div>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <div class="stat-item">
                    <div class="stat-num"><i class="fas fa-shield-alt" style="font-size:1.4rem;"></i></div>
                    <div class="stat-label">Telus &amp; Selamat</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     BANTUAN DETAIL CARDS
     ═══════════════════════════════════════════════════════════ --}}
<div class="container py-5">
    <div class="text-center mb-5">
        <div class="section-kicker"><i class="fas fa-hand-holding-heart"></i> Bantuan Tersedia</div>
        <h2 class="section-title">Jenis Bantuan BERKAT</h2>
        <p class="text-muted mx-auto" style="max-width:520px;font-size:0.93rem;">
            BERKAT menawarkan pelbagai bentuk bantuan kebajikan untuk warga JAN dan keluarga mereka merentasi lima kategori utama.
        </p>
    </div>

    <div class="row g-4">

        {{-- 1: Pendidikan --}}
        <div class="col-md-6 col-lg-4">
            <div class="bantuan-card">
                <div class="bc-icon" style="background:linear-gradient(135deg,#1565C0,#1976D2);">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="bc-title">Pendidikan</div>
                <div class="bc-desc">Bantuan kewangan berkaitan keperluan pendidikan anak-anak warga JAN.</div>
                <ul class="bc-list">
                    <li>Bantuan kemasukan persekolahan &amp; alatan tulis</li>
                    <li>Bantuan yuran &amp; akomodasi kemasukan IPT</li>
                    <li>Ganjaran kecemerlangan peperiksaan</li>
                </ul>
            </div>
        </div>

        {{-- 2: Kesihatan --}}
        <div class="col-md-6 col-lg-4">
            <div class="bantuan-card">
                <div class="bc-icon" style="background:linear-gradient(135deg,#2E7D32,#388E3C);">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <div class="bc-title">Kesihatan</div>
                <div class="bc-desc">Bantuan perubatan dan perawatan untuk ahli dan tanggungan yang memerlukan.</div>
                <ul class="bc-list">
                    <li>Bantuan rawatan masuk wad</li>
                    <li>Bantuan ubatan penyakit kronik</li>
                    <li>Peralatan sokongan (kerusi roda, alat pendengaran)</li>
                    <li>Bantuan pemulihan kecederaan parah</li>
                </ul>
            </div>
        </div>

        {{-- 3: Kebajikan --}}
        <div class="col-md-6 col-lg-4">
            <div class="bantuan-card">
                <div class="bc-icon" style="background:linear-gradient(135deg,#BF360C,#E64A19);">
                    <i class="fas fa-hands-helping"></i>
                </div>
                <div class="bc-title">Kebajikan</div>
                <div class="bc-desc">Bantuan kecemasan dan sokongan untuk ahli yang menghadapi situasi sukar.</div>
                <ul class="bc-list">
                    <li>Bantuan mangsa bencana alam</li>
                    <li>Bantuan pengebumian &amp; sokongan kematian</li>
                    <li>Bantuan kesusahan &amp; bantuan tunai segera</li>
                    <li>Bantuan pengurusan &amp; peralatan anak OKU</li>
                </ul>
            </div>
        </div>

        {{-- 4: Sosial --}}
        <div class="col-md-6 col-lg-4">
            <div class="bantuan-card">
                <div class="bc-icon" style="background:linear-gradient(135deg,#6A1B9A,#8E24AA);">
                    <i class="fas fa-star"></i>
                </div>
                <div class="bc-title">Sosial</div>
                <div class="bc-desc">Bantuan berkaitan perayaan dan pencapaian cemerlang peringkat antarabangsa.</div>
                <ul class="bc-list">
                    <li>Bantuan perayaan utama (Hari Raya, Tahun Baru Cina)</li>
                    <li>Ganjaran kecemerlangan peringkat antarabangsa</li>
                </ul>
            </div>
        </div>

        {{-- 5: Keahlian --}}
        <div class="col-md-6 col-lg-4">
            <div class="bantuan-card">
                <div class="bc-icon" style="background:linear-gradient(135deg,#AD1457,#C2185B);">
                    <i class="fas fa-id-badge"></i>
                </div>
                <div class="bc-title">Keahlian</div>
                <div class="bc-desc">Penghargaan dan bantuan sempena perubahan status perkhidmatan warga JAN.</div>
                <ul class="bc-list">
                    <li>Hadiah penghargaan persaraan</li>
                    <li>Bantuan kos pertukaran</li>
                </ul>
            </div>
        </div>

        {{-- 6: Apply CTA --}}
        <div class="col-md-6 col-lg-4">
            <div class="bantuan-card d-flex flex-column justify-content-between"
                 style="background:linear-gradient(135deg,#1a1a2e,#2d2d44);border-color:transparent;">
                <div>
                    <div class="bc-icon" style="background:rgba(255,87,34,0.22);">
                        <i class="fas fa-file-alt" style="color:var(--primary-color);"></i>
                    </div>
                    <div class="bc-title" style="color:#fff;">Mohon Sekarang</div>
                    <div class="bc-desc" style="color:rgba(255,255,255,0.55);">Daftar akaun dan mula mohon mana-mana bantuan di atas dengan mudah dan pantas.</div>
                </div>
                <div class="d-flex flex-column gap-2 mt-2">
                    @auth
                        <a href="{{ route('assistance-requests.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Buat Permohonan
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Daftar Akaun
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                            Sudah ada akaun? Log masuk
                        </a>
                    @endauth
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     PROCESS STEPS
     ═══════════════════════════════════════════════════════════ --}}
<div class="step-wrap">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-kicker"><i class="fas fa-route"></i> Aliran Kerja</div>
            <h2 class="section-title">Proses Permohonan</h2>
            <p class="text-muted" style="font-size:0.93rem;">Setiap permohonan melalui semakan berlapis untuk memastikan setiap kes diurus dengan telus dan adil.</p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach([
                ['fas fa-user-edit',       '1', 'Pemohon',          'Isi borang permohonan lengkap dan muat naik dokumen sokongan yang diperlukan.'],
                ['fas fa-user-tie',        '2', 'Semakan Agen',     'Agen JAN menyemak kelengkapan dokumen dan mengesahkan maklumat pemohon.'],
                ['fas fa-users',           '3', 'Syor JK',          'Jawatankuasa membuat penilaian dan mengesyorkan keputusan berdasarkan merit.'],
                ['fas fa-stamp',           '4', 'Keputusan Admin',  'Admin meluluskan atau menolak permohonan dan menetapkan jumlah bantuan.'],
                ['fas fa-money-bill-wave', '5', 'Pembayaran',       'Admin merekodkan pembayaran kepada pemohon yang berjaya diluluskan.'],
            ] as [$icon, $num, $title, $desc])
            <div class="col-sm-6 col-lg-2">
                <div class="text-center p-3">
                    <div class="step-num">{{ $num }}</div>
                    <div style="font-size:1.7rem;color:var(--primary-color);margin-bottom:0.6rem;"><i class="{{ $icon }}"></i></div>
                    <div style="font-weight:700;font-size:1rem;margin-bottom:0.4rem;">{{ $title }}</div>
                    <p class="text-muted mb-0" style="font-size:0.84rem;">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     CTA BOTTOM (guests only)
     ═══════════════════════════════════════════════════════════ --}}
@guest
<div class="cta-section">
    <div class="container text-center" style="position:relative;z-index:1;">
        <h2 style="color:#fff;font-size:2rem;font-weight:800;margin-bottom:1rem;">Sertai BERKAT Hari Ini</h2>
        <p style="color:rgba(255,255,255,0.78);font-size:1rem;max-width:460px;margin:0 auto 2rem;">
            Daftar sebagai ahli dan nikmati kemudahan memohon pelbagai bantuan kebajikan secara dalam talian.
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('register') }}" class="btn btn-light btn-lg" style="font-weight:700;color:var(--primary-color);">
                <i class="fas fa-user-plus"></i> Daftar Sekarang — Percuma
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                <i class="fas fa-sign-in-alt"></i> Log Masuk
            </a>
        </div>
    </div>
</div>
@endguest

@endsection
