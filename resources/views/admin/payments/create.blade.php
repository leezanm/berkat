@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <span class="page-kicker"><i class="fas fa-money-bill-wave"></i> Modul Pembayaran</span>
        <h1 class="page-title mt-1 mb-0">Rekod Pembayaran Baru</h1>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="surface-panel p-4">
                <form method="POST" action="{{ route('admin.payments.store') }}">
                    @csrf

                    {{-- Pilih Permohonan --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Permohonan <span class="text-danger">*</span>
                        </label>
                        <select name="assistance_request_id" id="assistance_request_id"
                                class="form-select @error('assistance_request_id') is-invalid @enderror"
                                required onchange="fillAmount(this)">
                            <option value="">— Pilih permohonan yang diluluskan —</option>
                            @foreach($approvedRequests as $ar)
                                <option value="{{ $ar->id }}"
                                        data-amount="{{ $ar->approved_amount }}"
                                        data-applicant="{{ $ar->applicant_name }}"
                                        {{ (old('assistance_request_id', $assistanceRequest?->id) == $ar->id) ? 'selected' : '' }}>
                                    #{{ $ar->id }} — {{ $ar->applicant_name }}
                                    ({{ $ar->requestType->name ?? '' }})
                                    — RM {{ number_format($ar->approved_amount, 2) }} diluluskan
                                </option>
                            @endforeach
                        </select>
                        @error('assistance_request_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($approvedRequests->isEmpty())
                            <div class="form-text text-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                Tiada permohonan yang diluluskan pada masa ini.
                            </div>
                        @endif
                    </div>

                    {{-- Maklumat pemohon (auto-fill) --}}
                    @if($assistanceRequest)
                    <div class="soft-panel mb-4 p-3">
                        <div class="detail-label mb-1">Maklumat Pemohon</div>
                        <div class="fw-semibold">{{ $assistanceRequest->applicant_name }}</div>
                        <div class="text-muted" style="font-size:0.85rem;">
                            {{ $assistanceRequest->requestType->name ?? '' }} —
                            Diluluskan: <strong>RM {{ number_format($assistanceRequest->approved_amount, 2) }}</strong>
                        </div>
                    </div>
                    @endif

                    {{-- Jumlah --}}
                    <div class="mb-3">
                        <label for="amount" class="form-label fw-semibold">
                            Jumlah Bayaran (RM) <span class="text-danger">*</span>
                        </label>
                        <input type="number" name="amount" id="amount"
                               class="form-control @error('amount') is-invalid @enderror"
                               value="{{ old('amount', $assistanceRequest?->approved_amount) }}"
                               step="0.01" min="0.01" required>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kaedah --}}
                    <div class="mb-3">
                        <label for="payment_method" class="form-label fw-semibold">
                            Kaedah Pembayaran <span class="text-danger">*</span>
                        </label>
                        <select name="payment_method" id="payment_method"
                                class="form-select @error('payment_method') is-invalid @enderror" required>
                            <option value="pindahan_bank" {{ old('payment_method') == 'pindahan_bank' ? 'selected' : '' }}>Pindahan Bank</option>
                            <option value="cek"           {{ old('payment_method') == 'cek'           ? 'selected' : '' }}>Cek</option>
                            <option value="tunai"         {{ old('payment_method') == 'tunai'         ? 'selected' : '' }}>Tunai</option>
                            <option value="lain"          {{ old('payment_method') == 'lain'          ? 'selected' : '' }}>Lain-lain</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- No. Rujukan --}}
                    <div class="mb-3">
                        <label for="payment_reference" class="form-label fw-semibold">
                            No. Rujukan / No. Cek
                        </label>
                        <input type="text" name="payment_reference" id="payment_reference"
                               class="form-control @error('payment_reference') is-invalid @enderror"
                               value="{{ old('payment_reference') }}"
                               placeholder="cth: TRX20260512-001">
                        @error('payment_reference')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tarikh Bayar --}}
                    <div class="mb-3">
                        <label for="payment_date" class="form-label fw-semibold">
                            Tarikh Pembayaran <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="payment_date" id="payment_date"
                               class="form-control @error('payment_date') is-invalid @enderror"
                               value="{{ old('payment_date', date('Y-m-d')) }}" required>
                        @error('payment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nota --}}
                    <div class="mb-4">
                        <label for="notes" class="form-label fw-semibold">Nota</label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="form-control @error('notes') is-invalid @enderror"
                                  placeholder="Nota tambahan (jika ada)…">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Rekod
                        </button>
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Sidebar info --}}
        <div class="col-lg-5">
            <div class="soft-panel p-4">
                <div class="detail-label mb-3">
                    <i class="fas fa-info-circle"></i> Panduan
                </div>
                <ul class="list-unstyled mb-0" style="font-size:0.88rem;color:#555;display:flex;flex-direction:column;gap:0.6rem;">
                    <li><i class="fas fa-check-circle text-success me-2"></i>Hanya permohonan berstatus <strong>Diluluskan</strong> boleh direkodkan pembayaran.</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i>Jumlah bayaran akan dipraisi dengan jumlah yang diluluskan.</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i>Simpan no. rujukan pindahan / no. cek untuk tujuan audit.</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i>Satu permohonan boleh mempunyai lebih dari satu rekod pembayaran (bayaran ansuran).</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function fillAmount(sel) {
    const opt = sel.options[sel.selectedIndex];
    const amt = opt.getAttribute('data-amount');
    if (amt) {
        document.getElementById('amount').value = parseFloat(amt).toFixed(2);
    }
}
// Auto-fill on page load if pre-selected
document.addEventListener('DOMContentLoaded', function() {
    const sel = document.getElementById('assistance_request_id');
    if (sel && sel.value) fillAmount(sel);
});
</script>
@endsection
