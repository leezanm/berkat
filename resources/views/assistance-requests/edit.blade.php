@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Edit Permohonan #{{ $assistanceRequest->id }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('assistance-requests.update', $assistanceRequest) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Request Information Section -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">A. MAKLUMAT PERMOHONAN</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="request_type_id" class="form-label">Jenis Permohonan *</label>
                            <select class="form-select @error('request_type_id') is-invalid @enderror" id="request_type_id" name="request_type_id" required onchange="loadCategories()">
                                <option value="">Pilih Jenis Permohonan</option>
                                @foreach($requestTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('request_type_id', $assistanceRequest->request_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('request_type_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="request_category_id" class="form-label">Kategori Permohonan *</label>
                            <select class="form-select @error('request_category_id') is-invalid @enderror" id="request_category_id" name="request_category_id" required onchange="loadSubcategories()">
                                <option value="">Pilih Kategori Permohonan</option>
                                @if($categories)
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('request_category_id', $assistanceRequest->request_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('request_category_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="request_subcategory_id" class="form-label">Sub Kategori Permohonan *</label>
                            <select class="form-select @error('request_subcategory_id') is-invalid @enderror" id="request_subcategory_id" name="request_subcategory_id" required>
                                <option value="">Pilih Sub Kategori Permohonan</option>
                                @if($assistanceRequest->subcategory)
                                    <option value="{{ old('request_subcategory_id', $assistanceRequest->request_subcategory_id) }}" selected>{{ $assistanceRequest->subcategory->name }}</option>
                                @endif
                            </select>
                            @error('request_subcategory_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="purpose" class="form-label">Tujuan Permohonan *</label>
                            <textarea class="form-control @error('purpose') is-invalid @enderror" id="purpose" name="purpose" rows="3" required>{{ old('purpose', $assistanceRequest->purpose) }}</textarea>
                            @error('purpose') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="agent_id" class="form-label"><i class="fas fa-user-tie"></i> Pilih Agen untuk Semakan <span class="text-danger">*</span></label>
                            <select class="form-select @error('agent_id') is-invalid @enderror" id="agent_id" name="agent_id" required onchange="displayAgentInfo()">
                                <option value="">Pilih Agen</option>
                                @forelse($agents as $agent)
                                    <option value="{{ $agent->id }}" {{ old('agent_id', $assistanceRequest->agent_id) == $agent->id ? 'selected' : '' }}
                                        data-staff-name="{{ $agent->staff_name }}"
                                        data-staff-ic="{{ $agent->staff_ic }}"
                                        data-position="{{ $agent->position }}"
                                        data-grade="{{ $agent->grade }}"
                                        data-accounting-office="{{ $agent->accounting_office }}"
                                        data-staff-email="{{ $agent->staff_email }}"
                                        data-staff-mobile="{{ $agent->staff_mobile }}"
                                        data-office-phone="{{ $agent->office_phone }}">
                                        {{ $agent->user->name }} - {{ $agent->office_name }}
                                    </option>
                                @empty
                                    <option value="" disabled>Tiada agen aktif tersedia</option>
                                @endforelse
                            </select>
                            <div class="form-hint">Pilih agen yang akan menyemak dokumen dan kelengkapan permohonan anda.</div>
                            @error('agent_id') <span class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                        </div>

                        <!-- Agent Information Display -->
                        <div id="agent-info-display" class="alert alert-info" role="alert" style="display: none;">
                            <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Maklumat Agen Terpilih</h6>
                            <div class="row g-2 mt-2">
                                <div class="col-md-6">
                                    <div><strong>Nama:</strong> <span id="agent-staff-name">-</span></div>
                                    <div><strong>No. KP:</strong> <span id="agent-staff-ic">-</span></div>
                                    <div><strong>Jawatan:</strong> <span id="agent-position">-</span></div>
                                    <div><strong>Gred:</strong> <span id="agent-grade">-</span></div>
                                </div>
                                <div class="col-md-6">
                                    <div><strong>Pejabat Perakaunan:</strong> <span id="agent-accounting-office">-</span></div>
                                    <div><strong>Email:</strong> <span id="agent-staff-email">-</span></div>
                                    <div><strong>No. HP:</strong> <span id="agent-staff-mobile">-</span></div>
                                    <div><strong>No. Pejabat:</strong> <span id="agent-office-phone">-</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Applicant Information Section -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">B. MAKLUMAT PEMOHON</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-3">Maklumat Diri Pemohon</h6>

                        <div class="mb-3">
                            <label for="applicant_name" class="form-label">Nama Pemohon *</label>
                            <input type="text" class="form-control @error('applicant_name') is-invalid @enderror" id="applicant_name" name="applicant_name" value="{{ old('applicant_name', $assistanceRequest->applicant_name) }}" required>
                            @error('applicant_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="applicant_ic" class="form-label">No. KP *</label>
                                <input type="text" class="form-control @error('applicant_ic') is-invalid @enderror" id="applicant_ic" name="applicant_ic" value="{{ old('applicant_ic', $assistanceRequest->applicant_ic) }}" required>
                                @error('applicant_ic') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="applicant_salary" class="form-label">Gaji Kasar (RM)</label>
                                <input type="number" class="form-control @error('applicant_salary') is-invalid @enderror" id="applicant_salary" name="applicant_salary" value="{{ old('applicant_salary', $assistanceRequest->applicant_salary) }}" step="0.01">
                                @error('applicant_salary') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="applicant_position" class="form-label">Jawatan & Gred</label>
                            <input type="text" class="form-control @error('applicant_position') is-invalid @enderror" id="applicant_position" name="applicant_position" value="{{ old('applicant_position', $assistanceRequest->applicant_position) }}">
                            @error('applicant_position') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="applicant_office_address" class="form-label">Alamat Pejabat</label>
                            <textarea class="form-control @error('applicant_office_address') is-invalid @enderror" id="applicant_office_address" name="applicant_office_address" rows="2">{{ old('applicant_office_address', $assistanceRequest->applicant_office_address) }}</textarea>
                            @error('applicant_office_address') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="applicant_accounting_office" class="form-label">Pejabat Perakaunan</label>
                            <input type="text" class="form-control @error('applicant_accounting_office') is-invalid @enderror" id="applicant_accounting_office" name="applicant_accounting_office" value="{{ old('applicant_accounting_office', $assistanceRequest->applicant_accounting_office) }}">
                            @error('applicant_accounting_office') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="applicant_phone" class="form-label">No. Telefon Bimbit *</label>
                                <input type="text" class="form-control @error('applicant_phone') is-invalid @enderror" id="applicant_phone" name="applicant_phone" value="{{ old('applicant_phone', $assistanceRequest->applicant_phone) }}" required>
                                @error('applicant_phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="applicant_email" class="form-label">Emel *</label>
                                <input type="email" class="form-control @error('applicant_email') is-invalid @enderror" id="applicant_email" name="applicant_email" value="{{ old('applicant_email', $assistanceRequest->applicant_email) }}" required>
                                @error('applicant_email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="applicant_bank_account" class="form-label">Nama dan No Akaun Bank</label>
                            <input type="text" class="form-control @error('applicant_bank_account') is-invalid @enderror" id="applicant_bank_account" name="applicant_bank_account" value="{{ old('applicant_bank_account', $assistanceRequest->applicant_bank_account) }}">
                            @error('applicant_bank_account') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="household_income" class="form-label">Pendapatan Seisi Rumah (Kasar) RM</label>
                                <input type="number" class="form-control @error('household_income') is-invalid @enderror" id="household_income" name="household_income" value="{{ old('household_income', $assistanceRequest->household_income) }}" step="0.01">
                                @error('household_income') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="dependents_count" class="form-label">Bilangan Tanggungan</label>
                                <input type="number" class="form-control @error('dependents_count') is-invalid @enderror" id="dependents_count" name="dependents_count" value="{{ old('dependents_count', $assistanceRequest->dependents_count) }}">
                                @error('dependents_count') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="disabled_dependents_count" class="form-label">Tanggungan OKU</label>
                                <input type="number" class="form-control @error('disabled_dependents_count') is-invalid @enderror" id="disabled_dependents_count" name="disabled_dependents_count" value="{{ old('disabled_dependents_count', $assistanceRequest->disabled_dependents_count) }}">
                                @error('disabled_dependents_count') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <hr>
                        <h6 class="mb-3">Maklumat Pasangan (Jika Ada)</h6>

                        <div class="mb-3">
                            <label for="spouse_name" class="form-label">Nama Pasangan</label>
                            <input type="text" class="form-control @error('spouse_name') is-invalid @enderror" id="spouse_name" name="spouse_name" value="{{ old('spouse_name', $assistanceRequest->spouse_name) }}">
                            @error('spouse_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="spouse_ic" class="form-label">No. KP Pasangan</label>
                                <input type="text" class="form-control @error('spouse_ic') is-invalid @enderror" id="spouse_ic" name="spouse_ic" value="{{ old('spouse_ic', $assistanceRequest->spouse_ic) }}">
                                @error('spouse_ic') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="spouse_salary" class="form-label">Gaji Kasar Pasangan (RM)</label>
                                <input type="number" class="form-control @error('spouse_salary') is-invalid @enderror" id="spouse_salary" name="spouse_salary" value="{{ old('spouse_salary', $assistanceRequest->spouse_salary) }}" step="0.01">
                                @error('spouse_salary') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="spouse_position" class="form-label">Jawatan & Gred Pasangan</label>
                            <input type="text" class="form-control @error('spouse_position') is-invalid @enderror" id="spouse_position" name="spouse_position" value="{{ old('spouse_position', $assistanceRequest->spouse_position) }}">
                            @error('spouse_position') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">C. DOKUMEN SOKONGAN</h5>
                    </div>
                    <div class="card-body">
                        <div id="documentRequirementsContainer" class="section-stack"></div>
                        @if($errors->has('documents.*'))
                            <div class="alert alert-warning mt-3 mb-0">
                                Muat naik fail tidak kekal selepas semakan gagal. Sila muat naik semula dokumen yang diperlukan.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('assistance-requests.show', $assistanceRequest) }}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-4">
            <div class="alert alert-info" role="alert">
                <h5>Status: {{ ucfirst($assistanceRequest->status) }}</h5>
                <p class="mb-0">Anda hanya boleh mengedit permohonan yang masih dalam status draf.</p>
            </div>
        </div>
    </div>
</div>

@php
$existingDocumentsMap = [];
foreach ($assistanceRequest->documents as $document) {
    $existingDocumentsMap[$document->document_key] = [
        'name' => $document->original_name,
        'size' => $document->file_size,
        'url' => route('assistance-requests.documents.download', [$assistanceRequest, $document]),
    ];
}
@endphp

<script>
const documentRequirements = @json($documentRequirements);
const documentErrors = @json($errors->getMessages());
const oldTypeId = @json(old('request_type_id', $assistanceRequest->request_type_id));
const oldCategoryId = @json(old('request_category_id', $assistanceRequest->request_category_id));
const oldSubcategoryId = @json(old('request_subcategory_id', $assistanceRequest->request_subcategory_id));
const existingDocuments = @json($existingDocumentsMap);

function escapeHtml(value) {
    return (value || '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/\"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function formatSize(size) {
    if (!size) {
        return '';
    }

    return `${(size / 1024 / 1024).toFixed(2)} MB`;
}

function renderDocumentRequirements() {
    const categorySelect = document.getElementById('request_category_id');
    const selectedOption = categorySelect.options[categorySelect.selectedIndex];
    const categoryName = selectedOption ? selectedOption.text : '';
    const container = document.getElementById('documentRequirementsContainer');
    const requirements = documentRequirements[categoryName];

    if (!requirements) {
        container.innerHTML = '<div class="alert alert-light mb-0">Pilih kategori permohonan untuk melihat dokumen sokongan yang diperlukan.</div>';
        return;
    }

    const notesHtml = (requirements.notes || []).map((note) => `<li>${escapeHtml(note)}</li>`).join('');
    const documentsHtml = (requirements.documents || []).map((document, index) => {
        const errors = documentErrors[`documents.${document.key}`] || [];
        const existing = existingDocuments[document.key];
        const existingHtml = existing
            ? `<div class="mb-2 small text-muted">Dokumen semasa: <a href="${existing.url}">${escapeHtml(existing.name)}</a>${existing.size ? ` (${formatSize(existing.size)})` : ''}</div>`
            : '<div class="mb-2 small text-muted">Belum dimuat naik.</div>';
        const errorHtml = errors.map((message) => `<div class="invalid-feedback d-block">${escapeHtml(message)}</div>`).join('');

        return `
            <div class="mb-3">
                <label for="document_${document.key}" class="form-label">${index + 1}. ${escapeHtml(document.label)} <span class="text-danger">*</span></label>
                ${existingHtml}
                <input type="file" class="form-control${errors.length ? ' is-invalid' : ''}" id="document_${document.key}" name="documents[${document.key}]" accept=".pdf,.jpg,.jpeg,.png" ${existing ? '' : 'required'}>
                <div class="form-text">Format dibenarkan: PDF, JPG, JPEG, PNG. Saiz maksimum 5MB.</div>
                ${errorHtml}
            </div>
        `;
    }).join('');

    container.innerHTML = `
        <div class="alert alert-light">
            <strong>Dokumen wajib untuk ${escapeHtml(categoryName)}</strong>
            ${notesHtml ? `<ul class="mb-0 mt-2">${notesHtml}</ul>` : ''}
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

    // Display agent info if agent was previously selected
    const agentSelect = document.getElementById('agent_id');
    if (agentSelect.value) {
        displayAgentInfo();
    }
});

function displayAgentInfo() {
    const agentSelect = document.getElementById('agent_id');
    const selectedOption = agentSelect.options[agentSelect.selectedIndex];
    const display = document.getElementById('agent-info-display');

    if (!selectedOption.value) {
        display.style.display = 'none';
        return;
    }

    // Populate agent information
    document.getElementById('agent-staff-name').textContent = selectedOption.dataset.staffName || '-';
    document.getElementById('agent-staff-ic').textContent = selectedOption.dataset.staffIc || '-';
    document.getElementById('agent-position').textContent = selectedOption.dataset.position || '-';
    document.getElementById('agent-grade').textContent = selectedOption.dataset.grade || '-';
    document.getElementById('agent-accounting-office').textContent = selectedOption.dataset.accountingOffice || '-';
    document.getElementById('agent-staff-email').textContent = selectedOption.dataset.staffEmail || '-';
    document.getElementById('agent-staff-mobile').textContent = selectedOption.dataset.staffMobile || '-';
    document.getElementById('agent-office-phone').textContent = selectedOption.dataset.officePhone || '-';

    display.style.display = 'block';
}
</script>
@endsection
