@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <span class="page-kicker"><i class="fas fa-money-bill-wave"></i> Modul Pembayaran</span>
            <h1 class="page-title mt-1 mb-0">Rekod Pembayaran</h1>
        </div>
        <a href="{{ route('admin.payments.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Rekod Pembayaran Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="surface-panel p-3 text-center">
                <div style="font-size:1.7rem;font-weight:800;color:var(--primary-color);">
                    {{ $payments->total() }}
                </div>
                <div class="text-muted" style="font-size:0.82rem;">Jumlah Rekod</div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="surface-panel p-3 text-center">
                <div style="font-size:1.7rem;font-weight:800;color:#2E7D32;">
                    RM {{ number_format($totalPaid, 2) }}
                </div>
                <div class="text-muted" style="font-size:0.82rem;">Jumlah Keseluruhan Dibayar</div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="surface-panel p-3 mb-4">
        <form method="GET" action="{{ route('admin.payments.index') }}" class="row g-2 align-items-end">
            <div class="col-sm-6 col-lg-2">
                <label class="form-label form-label-sm">Tahun</label>
                <select name="filter_year" class="form-select form-select-sm"
                        onchange="this.form.submit()">
                    <option value="">Semua Tahun</option>
                    @foreach($availableYears as $y)
                        <option value="{{ $y }}" {{ request('filter_year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 col-lg-2">
                <label class="form-label form-label-sm">Kaedah Bayaran</label>
                <select name="filter_method" class="form-select form-select-sm"
                        onchange="this.form.submit()">
                    <option value="">Semua Kaedah</option>
                    <option value="pindahan_bank" {{ request('filter_method') == 'pindahan_bank' ? 'selected' : '' }}>Pindahan Bank</option>
                    <option value="cek" {{ request('filter_method') == 'cek' ? 'selected' : '' }}>Cek</option>
                    <option value="tunai" {{ request('filter_method') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                    <option value="lain" {{ request('filter_method') == 'lain' ? 'selected' : '' }}>Lain-lain</option>
                </select>
            </div>
            <div class="col-sm-6 col-lg-3">
                <label class="form-label form-label-sm">Nama Pemohon</label>
                <input type="text" name="filter_applicant" class="form-control form-control-sm"
                       value="{{ request('filter_applicant') }}" placeholder="Cari nama pemohon…">
            </div>
            <div class="col-auto d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-filter"></i> Tapis
                </button>
                @if(request('filter_year') || request('filter_method') || request('filter_applicant'))
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary btn-sm" title="Padam penapis">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Table --}}
    @if($payments->count() > 0)
    <div class="surface-panel p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Permohonan</th>
                        <th>Nama Pemohon</th>
                        <th>Jenis Bantuan</th>
                        <th>Kaedah</th>
                        <th>No. Rujukan</th>
                        <th>Tarikh Bayar</th>
                        <th class="text-end">Jumlah (RM)</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td class="text-muted" style="font-size:0.82rem;">{{ $payment->id }}</td>
                        <td>
                            <a href="{{ route('assistance-requests.show', $payment->assistance_request_id) }}"
                               class="text-decoration-none fw-semibold">
                                #{{ $payment->assistance_request_id }}
                            </a>
                        </td>
                        <td>{{ $payment->assistanceRequest->applicant_name ?? '—' }}</td>
                        <td>
                            <span style="font-size:0.82rem;">
                                {{ $payment->assistanceRequest->requestType->name ?? '—' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-secondary" style="font-size:0.75rem;">
                                {{ $payment->getPaymentMethodLabel() }}
                            </span>
                        </td>
                        <td style="font-size:0.85rem;">{{ $payment->payment_reference ?? '—' }}</td>
                        <td style="font-size:0.85rem;">{{ $payment->payment_date->format('d/m/Y') }}</td>
                        <td class="text-end fw-bold" style="color:#2E7D32;">
                            {{ number_format($payment->amount, 2) }}
                        </td>
                        <td>
                            <div class="d-flex gap-1 justify-content-end">
                                <a href="{{ route('admin.payments.show', $payment) }}"
                                   class="btn btn-outline-secondary btn-sm" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.payments.destroy', $payment) }}"
                                      onsubmit="return confirm('Padam rekod pembayaran ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm" title="Padam">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $payments->links() }}</div>

    @else
    <div class="surface-panel p-5 text-center text-muted">
        <i class="fas fa-money-bill-wave" style="font-size:2.5rem;opacity:0.3;"></i>
        <p class="mt-3 mb-0">Tiada rekod pembayaran ditemui.</p>
        <a href="{{ route('admin.payments.create') }}" class="btn btn-primary mt-3">
            <i class="fas fa-plus-circle"></i> Rekod Pembayaran Pertama
        </a>
    </div>
    @endif

</div>
@endsection
