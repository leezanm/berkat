@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4 align-items-end">
        <div class="col-lg-8">
            <span class="page-kicker"><i class="fas fa-file-circle-plus"></i> Borang Permohonan</span>
            <h1><i class="fas fa-file-alt"></i> Borang Permohonan Bantuan BERKAT</h1>
            <p class="page-subtitle">Lengkapkan maklumat permohonan dan profil pemohon dengan teratur. Medan utama disusun mengikut keutamaan untuk memudahkan semakan.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <form action="{{ route('assistance-requests.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <!-- Request Information Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> A. MAKLUMAT PERMOHONAN</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="request_type_id" class="form-label"><i class="fas fa-list"></i> Jenis Permohonan <span class="text-danger">*</span></label>
                            <select class="form-select @error('request_type_id') is-invalid @enderror" id="request_type_id" name="request_type_id" required onchange="loadCategories()">
                                <option value="">Pilih Jenis Permohonan</option>
                                @foreach($requestTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('request_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('request_type_id') <span class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="request_category_id" class="form-label"><i class="fas fa-folder"></i> Kategori Permohonan <span class="text-danger">*</span></label>
                            <select class="form-select @error('request_category_id') is-invalid @enderror" id="request_category_id" name="request_category_id" required onchange="loadSubcategories()">
                                <option value="">Pilih Kategori Permohonan</option>
                            </select>
                            @error('request_category_id') <span class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="request_subcategory_id" class="form-label"><i class="fas fa-tag"></i> Sub Kategori Permohonan <span class="text-danger">*</span></label>
                            <select class="form-select @error('request_subcategory_id') is-invalid @enderror" id="request_subcategory_id" name="request_subcategory_id" required>
                                <option value="">Pilih Sub Kategori Permohonan</option>
                            </select>
                            @error('request_subcategory_id') <span class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="purpose" class="form-label"><i class="fas fa-pencil-alt"></i> Tujuan Permohonan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('purpose') is-invalid @enderror" id="purpose" name="purpose" rows="3" required>{{ old('purpose') }}</textarea>
                            <div class="form-hint">Nyatakan tujuan dengan ringkas tetapi jelas supaya pihak semakan memahami konteks permohonan.</div>
                            @error('purpose') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Applicant Information Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-user"></i> B. MAKLUMAT PEMOHON</h5>
                    </div>
                    <div class="card-body">
                        <div class="soft-panel mb-4">
                            <h6 class="mb-0"><i class="fas fa-user-check"></i> Maklumat Diri Pemohon</h6>
                        </div>

                        <div class="mb-3">
                            <label for="applicant_name" class="form-label"><i class="fas fa-signature"></i> Nama Pemohon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('applicant_name') is-invalid @enderror" id="applicant_name" name="applicant_name" value="{{ old('applicant_name') }}" required>
                            @error('applicant_name') <span class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="applicant_ic" class="form-label"><i class="fas fa-id-card"></i> No. KP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('applicant_ic') is-invalid @enderror" id="applicant_ic" name="applicant_ic" value="{{ old('applicant_ic') }}" required>
                                @error('applicant_ic') <span class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="applicant_salary" class="form-label"><i class="fas fa-money-bill"></i> Gaji Kasar (RM)</label>
                                <input type="number" class="form-control @error('applicant_salary') is-invalid @enderror" id="applicant_salary" name="applicant_salary" value="{{ old('applicant_salary') }}" step="0.01">
                                @error('applicant_salary') <span class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="applicant_position" class="form-label">Jawatan & Gred</label>
                            <input type="text" class="form-control @error('applicant_position') is-invalid @enderror" id="applicant_position" name="applicant_position" value="{{ old('applicant_position') }}">
                            @error('applicant_position') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="applicant_office_address" class="form-label">Alamat Pejabat</label>
                            <textarea class="form-control @error('applicant_office_address') is-invalid @enderror" id="applicant_office_address" name="applicant_office_address" rows="2">{{ old('applicant_office_address') }}</textarea>
                            @error('applicant_office_address') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="applicant_accounting_office" class="form-label">Pejabat Perakaunan</label>
                            <input type="text" class="form-control @error('applicant_accounting_office') is-invalid @enderror" id="applicant_accounting_office" name="applicant_accounting_office" value="{{ old('applicant_accounting_office') }}">
                            @error('applicant_accounting_office') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="applicant_phone" class="form-label">No. Telefon Bimbit *</label>
                                <input type="text" class="form-control @error('applicant_phone') is-invalid @enderror" id="applicant_phone" name="applicant_phone" value="{{ old('applicant_phone') }}" required>
                                @error('applicant_phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="applicant_email" class="form-label">Emel *</label>
                                <input type="email" class="form-control @error('applicant_email') is-invalid @enderror" id="applicant_email" name="applicant_email" value="{{ old('applicant_email') }}" required>
                                @error('applicant_email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="applicant_bank_account" class="form-label">Nama dan No Akaun Bank</label>
                            <input type="text" class="form-control @error('applicant_bank_account') is-invalid @enderror" id="applicant_bank_account" name="applicant_bank_account" value="{{ old('applicant_bank_account') }}">
                            @error('applicant_bank_account') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="household_income" class="form-label">Pendapatan Seisi Rumah (Kasar) RM</label>
                                <input type="number" class="form-control @error('household_income') is-invalid @enderror" id="household_income" name="household_income" value="{{ old('household_income') }}" step="0.01">
                                @error('household_income') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="dependents_count" class="form-label">Bilangan Tanggungan</label>
                                <input type="number" class="form-control @error('dependents_count') is-invalid @enderror" id="dependents_count" name="dependents_count" value="{{ old('dependents_count') }}">
                                @error('dependents_count') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="disabled_dependents_count" class="form-label">Tanggungan OKU</label>
                                <input type="number" class="form-control @error('disabled_dependents_count') is-invalid @enderror" id="disabled_dependents_count" name="disabled_dependents_count" value="{{ old('disabled_dependents_count') }}">
                                @error('disabled_dependents_count') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <hr style="border-color: var(--border-light); margin: 2rem 0;">
                        <div class="soft-panel mb-4">
                            <h6 class="mb-0"><i class="fas fa-ring"></i> Maklumat Pasangan (Jika Ada)</h6>
                        </div>

                        <div class="mb-3">
                            <label for="spouse_name" class="form-label"><i class="fas fa-signature"></i> Nama Pasangan</label>
                            <input type="text" class="form-control @error('spouse_name') is-invalid @enderror" id="spouse_name" name="spouse_name" value="{{ old('spouse_name') }}">
                            @error('spouse_name') <span class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="spouse_ic" class="form-label"><i class="fas fa-id-card"></i> No. KP Pasangan</label>
                                <input type="text" class="form-control @error('spouse_ic') is-invalid @enderror" id="spouse_ic" name="spouse_ic" value="{{ old('spouse_ic') }}">
                                @error('spouse_ic') <span class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="spouse_salary" class="form-label"><i class="fas fa-money-bill"></i> Gaji Kasar Pasangan (RM)</label>
                                <input type="number" class="form-control @error('spouse_salary') is-invalid @enderror" id="spouse_salary" name="spouse_salary" value="{{ old('spouse_salary') }}" step="0.01">
                                @error('spouse_salary') <span class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="spouse_position" class="form-label"><i class="fas fa-briefcase"></i> Jawatan & Gred Pasangan</label>
                            <input type="text" class="form-control @error('spouse_position') is-invalid @enderror" id="spouse_position" name="spouse_position" value="{{ old('spouse_position') }}">
                            @error('spouse_position') <span class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-paperclip"></i> C. DOKUMEN SOKONGAN</h5>
                    </div>
                    <div class="card-body">
                        <div id="documentRequirementsContainer" class="section-stack"></div>
                        @if($errors->has('documents.*'))
                            <div class="alert alert-warning mt-3 mb-0">
                                <i class="fas fa-triangle-exclamation"></i> Muat naik fail tidak disimpan selepas semakan gagal. Sila muat naik semula dokumen yang diperlukan.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card border-0">
                    <div class="card-body d-flex flex-column flex-md-row gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Simpan sebagai Draf
                        </button>
                        <a href="{{ route('assistance-requests.index') }}" class="btn btn-outline-soft btn-lg">
                            <i class="fas fa-times-circle"></i> Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="sticky-panel section-stack">
                <div class="stat-card stat-card-dark mb-0">
                    <div style="font-size: 2.2rem;"><i class="fas fa-circle-info"></i></div>
                    <div class="text-white-50" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em;">Sebelum hantar</div>
                    <div style="font-size: 1.45rem; font-weight: 700;">Semak semua maklumat penting</div>
                    <p class="mb-0" style="color: rgba(255,255,255,0.72);">Maklumat yang lengkap dan tepat akan mempercepatkan proses semakan oleh agen dan jawatankuasa.</p>
                </div>

                <div class="card border-0 bg-light mb-0">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-lightbulb" style="color: var(--warning-color);"></i> Panduan Pengisian Borang</h5>
                        <div class="section-stack">
                            <div class="detail-item">
                                <span class="detail-label">Medan Wajib</span>
                                <p class="mb-0">Sila isi semua medan yang ditandai dengan <span class="text-danger">*</span>.</p>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Selepas Simpan</span>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><i class="fas fa-check-circle" style="color: var(--success-color);"></i> Menyemak permohonan anda</li>
                                    <li class="mb-2"><i class="fas fa-check-circle" style="color: var(--success-color);"></i> Mengedit sebelum dihantar</li>
                                    <li><i class="fas fa-check-circle" style="color: var(--success-color);"></i> Menghantar untuk semakan rasmi</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 mb-0" style="background: linear-gradient(180deg, rgba(255, 247, 243, 0.95) 0%, rgba(255, 255, 255, 0.98) 100%);">
                    <div class="card-body">
                        <h6 class="card-title mb-2"><i class="fas fa-info-circle" style="color: var(--primary-color);"></i> Tip Berguna</h6>
                        <p class="mb-0 small">Gunakan butiran terkini untuk nombor telefon, emel, pendapatan dan maklumat bank bagi mengelakkan semakan semula yang tidak perlu.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-danger {
        color: var(--danger-color);
    }
</style>

<script>
const documentRequirements = @json($documentRequirements);
const documentErrors = @json($errors->getMessages());
const oldTypeId = @json(old('request_type_id'));
const oldCategoryId = @json(old('request_category_id'));
const oldSubcategoryId = @json(old('request_subcategory_id'));

function escapeHtml(value) {
    return (value || '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/\"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function renderDocumentRequirements() {
    const categorySelect = document.getElementById('request_category_id');
    const selectedOption = categorySelect.options[categorySelect.selectedIndex];
    const categoryName = selectedOption ? selectedOption.text : '';
    const container = document.getElementById('documentRequirementsContainer');
    const requirements = documentRequirements[categoryName];

    if (!requirements) {
        container.innerHTML = `
            <div class="muted-block mb-0">
                <span class="detail-label">Dokumen sokongan</span>
                <p class="mb-0">Pilih kategori permohonan terlebih dahulu untuk melihat senarai dokumen yang wajib dimuat naik.</p>
            </div>
        `;
        return;
    }

    const notesHtml = (requirements.notes || []).map((note) => `
        <li><i class="fas fa-circle-check" style="color: var(--success-color);"></i> ${escapeHtml(note)}</li>
    `).join('');

    const documentsHtml = (requirements.documents || []).map((document, index) => {
        const errors = documentErrors[`documents.${document.key}`] || [];
        const errorHtml = errors.map((message) => `<div class="invalid-feedback d-block">${escapeHtml(message)}</div>`).join('');

        return `
            <div class="detail-item">
                <label for="document_${document.key}" class="form-label fw-semibold mb-2">${index + 1}. ${escapeHtml(document.label)} <span class="text-danger">*</span></label>
                <input type="file" class="form-control${errors.length ? ' is-invalid' : ''}" id="document_${document.key}" name="documents[${document.key}]" accept=".pdf,.jpg,.jpeg,.png" required>
                <div class="form-hint">Format dibenarkan: PDF, JPG, JPEG, PNG. Saiz maksimum 5MB.</div>
                ${errorHtml}
            </div>
        `;
    }).join('');

    container.innerHTML = `
        <div class="muted-block mb-0">
            <span class="detail-label">Senarai dokumen untuk ${escapeHtml(categoryName)}</span>
            <p class="mb-2">Setiap dokumen di bawah adalah wajib untuk kategori ini.</p>
            ${notesHtml ? `<ul class="list-unstyled mb-3 section-stack">${notesHtml}</ul>` : ''}
        </div>
        ${documentsHtml}
    `;
}

function loadCategories(selectedCategoryId = '') {
    const typeId = document.getElementById('request_type_id').value;
    if (!typeId) {
        document.getElementById('request_category_id').innerHTML = '<option value="">Pilih Kategori Permohonan</option>';
        document.getElementById('request_subcategory_id').innerHTML = '<option value="">Pilih Sub Kategori Permohonan</option>';
        renderDocumentRequirements();
        return;
    }

    fetch(`/request-types/${typeId}/categories`)
        .then(response => response.json())
        .then(data => {
            let html = '<option value="">Pilih Kategori Permohonan</option>';
            data.forEach(category => {
                const selected = String(selectedCategoryId) === String(category.id) ? 'selected' : '';
                html += `<option value="${category.id}" ${selected}>${category.name}</option>`;
            });
            document.getElementById('request_category_id').innerHTML = html;
            renderDocumentRequirements();

            if (selectedCategoryId) {
                loadSubcategories(oldSubcategoryId);
            }
        });
}

function loadSubcategories(selectedSubcategoryId = '') {
    const categoryId = document.getElementById('request_category_id').value;
    renderDocumentRequirements();

    if (!categoryId) {
        document.getElementById('request_subcategory_id').innerHTML = '<option value="">Pilih Sub Kategori Permohonan</option>';
        return;
    }

    fetch(`/request-categories/${categoryId}/subcategories`)
        .then(response => response.json())
        .then(data => {
            let html = '<option value="">Pilih Sub Kategori Permohonan</option>';
            data.forEach(subcategory => {
                const selected = String(selectedSubcategoryId) === String(subcategory.id) ? 'selected' : '';
                html += `<option value="${subcategory.id}" ${selected}>${subcategory.name}</option>`;
            });
            document.getElementById('request_subcategory_id').innerHTML = html;
        });
}

document.addEventListener('DOMContentLoaded', () => {
    if (oldTypeId) {
        document.getElementById('request_type_id').value = oldTypeId;
        loadCategories(oldCategoryId);
        return;
    }

    renderDocumentRequirements();
});
</script>
@endsection
