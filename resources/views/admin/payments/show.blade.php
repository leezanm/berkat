@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">Pembayaran</a></li>
            <li class="breadcrumb-item active">Rekod #{{ $payment->id }}</li>
        </ol>
    </nav>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <span class="page-kicker"><i class="fas fa-money-bill-wave"></i> Rekod Pembayaran</span>
            <h1 class="page-title mt-1 mb-0">Rekod #{{ $payment->id }}</h1>
        </div>
        <form method="POST" action="{{ route('admin.payments.destroy', $payment) }}"
              onsubmit="return confirm('Padam rekod pembayaran ini?')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger btn-sm">
                <i class="fas fa-trash"></i> Padam
            </button>
        </form>
    </div>

    <div class="row g-4">
        {{-- Butiran pembayaran --}}
        <div class="col-lg-6">
            <div class="surface-panel p-4">
                <div class="detail-label mb-3">Maklumat Pembayaran</div>
                <div class="section-stack">
                    <div class="detail-item">
                        <span class="detail-label">Jumlah Bayaran</span>
                        <p class="detail-value mb-0" style="font-size:1.6rem;color:#2E7D32;font-weight:800;">
                            RM {{ number_format($payment->amount, 2) }}
                        </p>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Kaedah Pembayaran</span>
                        <p class="detail-value mb-0">{{ $payment->getPaymentMethodLabel() }}</p>
                    </div>
                    @if($payment->payment_reference)
                    <div class="detail-item">
                        <span class="detail-label">No. Rujukan / No. Cek</span>
                        <p class="detail-value mb-0">{{ $payment->payment_reference }}</p>
                    </div>
                    @endif
                    <div class="detail-item">
                        <span class="detail-label">Tarikh Pembayaran</span>
                        <p class="detail-value mb-0">{{ $payment->payment_date->format('d F Y') }}</p>
                    </div>
                    @if($payment->notes)
                    <div class="detail-item">
                        <span class="detail-label">Nota</span>
                        <p class="detail-value mb-0">{{ $payment->notes }}</p>
                    </div>
                    @endif
                    <div class="detail-item">
                        <span class="detail-label">Direkodkan Oleh</span>
                        <p class="detail-value mb-0">{{ $payment->paidByUser->name ?? '—' }}</p>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Tarikh Rekod Dibuat</span>
                        <p class="detail-value mb-0">{{ $payment->created_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Maklumat permohonan --}}
        <div class="col-lg-6">
            <div class="surface-panel p-4">
                <div class="detail-label mb-3">Maklumat Permohonan</div>
                <div class="section-stack">
                    <div class="detail-item">
                        <span class="detail-label">No. Permohonan</span>
                        <p class="detail-value mb-0">
                            <a href="{{ route('assistance-requests.show', $payment->assistance_request_id) }}"
                               class="text-decoration-none">
                                #{{ $payment->assistance_request_id }}
                                <i class="fas fa-external-link-alt" style="font-size:0.75rem;"></i>
                            </a>
                        </p>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Nama Pemohon</span>
                        <p class="detail-value mb-0">{{ $payment->assistanceRequest->applicant_name ?? '—' }}</p>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Jenis Bantuan</span>
                        <p class="detail-value mb-0">{{ $payment->assistanceRequest->requestType->name ?? '—' }}</p>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Jumlah Diluluskan</span>
                        <p class="detail-value mb-0">
                            RM {{ number_format($payment->assistanceRequest->approved_amount, 2) }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('assistance-requests.show', $payment->assistance_request_id) }}"
                   class="btn btn-outline-secondary btn-sm mt-3">
                    <i class="fas fa-eye"></i> Lihat Permohonan
                </a>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
