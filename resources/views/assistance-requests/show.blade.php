@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4 align-items-end">
        <div class="col-lg-8">
            <span class="page-kicker"><i class="fas fa-folder-open"></i> Butiran Permohonan</span>
            <h1><i class="fas fa-file-invoice"></i> Butiran Permohonan #{{ str_pad($assistanceRequest->id, 5, '0', STR_PAD_LEFT) }}</h1>
            <p class="page-subtitle">Paparan ini menghimpunkan status, maklumat pemohon dan butiran penghantaran dalam susunan yang lebih jelas untuk semakan pantas.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            @if($assistanceRequest->status === 'draft' && auth()->id() === $assistanceRequest->user_id)
                <a href="{{ route('assistance-requests.edit', $assistanceRequest) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('assistance-requests.submit', $assistanceRequest) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane"></i> Hantar
                    </button>
                </form>
            @endif
            <a href="{{ route('assistance-requests.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-triangle-exclamation"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-line"></i> Status Permohonan</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-info-circle"></i> Status Permohonan</span>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $assistanceRequest->getStatusBadgeClass() }}" style="font-size: 0.95rem;">
                                        <i class="fas fa-{{ $assistanceRequest->getStatusIcon() }}"></i>
                                        {{ $assistanceRequest->getStatusLabel() }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-user-tie"></i> Pengesahan Agen</span>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $assistanceRequest->getAgentVerificationBadgeClass() }}" style="font-size: 0.95rem;">
                                        <i class="fas fa-{{ $assistanceRequest->getAgentVerificationIcon() }}"></i>
                                        {{ $assistanceRequest->getAgentVerificationLabel() }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-user-check"></i> Agen Bertugas</span>
                                <p class="detail-value">
                                    @if($assistanceRequest->agent)
                                        {{ $assistanceRequest->agent->user->name }}
                                        <br><small class="text-muted">{{ $assistanceRequest->agent->office_name }}</small>
                                    @else
                                        Belum ditetapkan
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-clipboard-list"></i> Status Semakan JK</span>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $assistanceRequest->getJkRecommendationStatusBadgeClass() }}" style="font-size: 0.95rem;">
                                        <i class="fas fa-clipboard-check"></i>
                                        {{ $assistanceRequest->getJkRecommendationStatusLabel() }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($assistanceRequest->agent)
                        <div class="alert alert-info mb-3" role="alert">
                            <h6 class="alert-heading"><i class="fas fa-id-card"></i> Maklumat Agen Pengesahan</h6>
                            <div class="row g-2 mt-2">
                                <div class="col-md-6">
                                    <div><strong>Nama:</strong> {{ $assistanceRequest->agent->staff_name ?? '-' }}</div>
                                    <div><strong>No. KP:</strong> {{ $assistanceRequest->agent->staff_ic ?? '-' }}</div>
                                    <div><strong>Jawatan:</strong> {{ $assistanceRequest->agent->position ?? '-' }}</div>
                                    <div><strong>Gred:</strong> {{ $assistanceRequest->agent->grade ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div><strong>Pejabat Perakaunan:</strong> {{ $assistanceRequest->agent->accounting_office ?? '-' }}</div>
                                    <div><strong>Email:</strong> {{ $assistanceRequest->agent->staff_email ?? '-' }}</div>
                                    <div><strong>No. HP:</strong> {{ $assistanceRequest->agent->staff_mobile ?? '-' }}</div>
                                    <div><strong>No. Pejabat:</strong> {{ $assistanceRequest->agent->office_phone ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($assistanceRequest->approved_amount)
                        <div class="stat-card" style="background: linear-gradient(135deg, var(--success-color) 0%, #1E8449 100%); color: white; min-height: auto; margin-bottom: 1rem;">
                            <div class="detail-label" style="color: rgba(255,255,255,0.7);"><i class="fas fa-money-bill-wave"></i> Jumlah Diluluskan</div>
                            <p style="font-size: 1.5rem; font-weight: 700; margin: 0;">RM {{ number_format($assistanceRequest->approved_amount, 2) }}</p>
                        </div>
                    @endif

                    @if($assistanceRequest->rejection_reason)
                        <div class="muted-block" style="background: #fff0ef; color: #7c211d; border-left: 4px solid var(--danger-color);">
                            <p class="mb-2"><strong><i class="fas fa-times-circle"></i> Alasan Penolakan:</strong></p>
                            <p class="mb-0">{{ $assistanceRequest->rejection_reason }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Maklumat Permohonan</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-list"></i> Jenis Permohonan</span>
                                <p class="detail-value" style="color: var(--primary-color);">{{ $assistanceRequest->requestType->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-folder"></i> Kategori</span>
                                <p class="detail-value" style="color: var(--primary-color);">{{ $assistanceRequest->category->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-tag"></i> Sub Kategori</span>
                                <p class="detail-value">{{ $assistanceRequest->subcategory->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="muted-block">
                        <span class="detail-label">Tujuan Permohonan</span>
                        <p class="mb-0">{{ $assistanceRequest->purpose }}</p>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Maklumat Pemohon</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Nama</span>
                                <p class="detail-value">{{ $assistanceRequest->applicant_name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">No. KP</span>
                                <p class="detail-value">{{ $assistanceRequest->applicant_ic }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Gaji Kasar</span>
                                <p class="detail-value">{{ $assistanceRequest->applicant_salary ? 'RM ' . number_format($assistanceRequest->applicant_salary, 2) : '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Jawatan & Gred</span>
                                <p class="detail-value">{{ $assistanceRequest->applicant_position ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="muted-block mb-3">
                        <span class="detail-label">Alamat Pejabat</span>
                        <p class="mb-0">{{ $assistanceRequest->applicant_office_address ?? '-' }}</p>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">No. Telefon Bimbit</span>
                                <p class="detail-value">{{ $assistanceRequest->applicant_phone }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Emel</span>
                                <p class="detail-value">{{ $assistanceRequest->applicant_email }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Pendapatan Seisi Rumah</span>
                                <p class="detail-value">{{ $assistanceRequest->household_income ? 'RM ' . number_format($assistanceRequest->household_income, 2) : '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-item">
                                <span class="detail-label">Tanggungan</span>
                                <p class="detail-value">{{ $assistanceRequest->dependents_count }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-item">
                                <span class="detail-label">Tanggungan OKU</span>
                                <p class="detail-value">{{ $assistanceRequest->disabled_dependents_count }}</p>
                            </div>
                        </div>
                    </div>

                    @if($assistanceRequest->spouse_name)
                        <hr>
                        <h6 class="mb-3">Maklumat Pasangan</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">Nama</span>
                                    <p class="detail-value">{{ $assistanceRequest->spouse_name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">No. KP</span>
                                    <p class="detail-value">{{ $assistanceRequest->spouse_ic }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">Gaji Kasar</span>
                                    <p class="detail-value">{{ $assistanceRequest->spouse_salary ? 'RM ' . number_format($assistanceRequest->spouse_salary, 2) : '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">Jawatan & Gred</span>
                                    <p class="detail-value">{{ $assistanceRequest->spouse_position ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @php
                $requiredDocuments = config('assistance_documents.categories.' . $assistanceRequest->category->name . '.documents', []);
                $documentNotes = config('assistance_documents.categories.' . $assistanceRequest->category->name . '.notes', []);
                $uploadedDocuments = $assistanceRequest->documents->keyBy('document_key');
            @endphp

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-paperclip"></i> Dokumen Sokongan</h5>
                </div>
                <div class="card-body">
                    @if($documentNotes)
                        <div class="muted-block mb-3">
                            <span class="detail-label">Nota kategori</span>
                            <ul class="list-unstyled mb-0 section-stack">
                                @foreach($documentNotes as $note)
                                    <li><i class="fas fa-circle-check" style="color: var(--success-color);"></i> {{ $note }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($requiredDocuments)
                        <div class="section-stack">
                            @foreach($requiredDocuments as $documentRequirement)
                                @php $uploadedDocument = $uploadedDocuments->get($documentRequirement['key']); @endphp
                                <div class="detail-item d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3">
                                    <div>
                                        <span class="detail-label">{{ $documentRequirement['label'] }}</span>
                                        @if($uploadedDocument)
                                            <p class="mb-0 text-muted">{{ $uploadedDocument->original_name }}
                                                @if($uploadedDocument->file_size)
                                                    <span>({{ number_format($uploadedDocument->file_size / 1024 / 1024, 2) }} MB)</span>
                                                @endif
                                            </p>
                                        @else
                                            <p class="mb-0 text-danger">Dokumen belum dimuat naik.</p>
                                        @endif
                                    </div>
                                    <div>
                                        @if($uploadedDocument)
                                            <a href="{{ route('assistance-requests.documents.download', [$assistanceRequest, $uploadedDocument]) }}" class="btn btn-outline-soft">
                                                <i class="fas fa-download"></i> Muat Turun
                                            </a>
                                        @else
                                            <span class="badge bg-danger">Tiada fail</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="muted-block mb-0">
                            <p class="mb-0">Tiada dokumen sokongan ditetapkan untuk kategori ini.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-paper-plane"></i> Maklumat Penghantaran</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Tarikh Dihantar</span>
                                <p class="detail-value">{{ $assistanceRequest->submitted_at ? $assistanceRequest->submitted_at->format('d/m/Y H:i') : 'Belum dihantar' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Tarikh Diluluskan</span>
                                <p class="detail-value">{{ $assistanceRequest->approved_at ? $assistanceRequest->approved_at->format('d/m/Y H:i') : '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="sticky-panel section-stack">
                <div class="card mb-0">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-bolt"></i> Tindakan Cepat</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if($assistanceRequest->status === 'draft')
                                <a href="{{ route('assistance-requests.edit', $assistanceRequest) }}" class="btn btn-warning">Edit Permohonan</a>
                                <form action="{{ route('assistance-requests.submit', $assistanceRequest) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100">Hantar Permohonan</button>
                                </form>
                                <form action="{{ route('assistance-requests.destroy', $assistanceRequest) }}" method="POST" onsubmit="return confirm('Padam permohonan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">Padam Permohonan</button>
                                </form>
                            @elseif($assistanceRequest->status === 'submitted' && auth()->user()->role === 'member')
                                <div class="muted-block">
                                    <p class="text-muted mb-0">Permohonan sedang dalam proses semakan oleh agen dan JK.</p>
                                </div>
                            @elseif($assistanceRequest->status === 'in_process' && auth()->user()->role === 'member')
                                <div class="muted-block">
                                    <p class="text-muted mb-0">Permohonan anda sedang diproses selepas semakan agen dan menunggu tindakan seterusnya.</p>
                                </div>
                            @elseif($assistanceRequest->status === 'approved')
                                <div class="muted-block">
                                    <p class="text-success mb-2"><strong>Permohonan telah diluluskan.</strong></p>
                                    <p class="mb-0">Jumlah yang diluluskan: RM {{ number_format($assistanceRequest->approved_amount, 2) }}</p>
                                </div>
                            @elseif($assistanceRequest->status === 'rejected')
                                <div class="muted-block">
                                    <p class="text-danger mb-2"><strong>Permohonan telah ditolak.</strong></p>
                                    <p class="mb-0">Alasan: {{ $assistanceRequest->rejection_reason }}</p>
                                </div>
                            @endif

                            @if(in_array(auth()->user()->role, ['agent', 'admin'], true) && $assistanceRequest->status === 'submitted')
                                <div class="muted-block mt-2">
                                    <p class="mb-2"><strong>Semakan Agen</strong></p>
                                    <form action="{{ route('assistance-requests.agent-review', $assistanceRequest) }}" method="POST" class="section-stack">
                                        @csrf
                                        <div>
                                            <label for="agent_verification" class="form-label">Keputusan Semakan</label>
                                            <select id="agent_verification" name="agent_verification" class="form-select">
                                                <option value="verified">Sahkan permohonan</option>
                                                <option value="rejected">Tolak permohonan</option>
                                            </select>
                                            @error('agent_verification') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label for="agent_rejection_reason" class="form-label">Sebab penolakan jika berkaitan</label>
                                            <textarea id="agent_rejection_reason" name="rejection_reason" class="form-control" rows="3" placeholder="Nyatakan sebab jika permohonan perlu ditolak"></textarea>
                                            @error('rejection_reason') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Simpan Semakan Agen</button>
                                    </form>
                                </div>
                            @endif

                            @if(in_array(auth()->user()->role, ['jk', 'admin'], true) && $assistanceRequest->status === 'in_process' && $assistanceRequest->agent_verification === 'verified')
                                <div class="muted-block mt-2">
                                    <p class="mb-2"><strong>Pengesyoran JK</strong></p>
                                    <form action="{{ route('assistance-requests.jk-recommendation', $assistanceRequest) }}" method="POST" class="section-stack">
                                        @csrf
                                        <div>
                                            <label for="jk_recommendation_status" class="form-label">Pengesyoran</label>
                                            <select id="jk_recommendation_status" name="jk_recommendation_status" class="form-select">
                                                <option value="recommended" {{ old('jk_recommendation_status', $assistanceRequest->jk_recommendation_status) === 'recommended' ? 'selected' : '' }}>Sokong</option>
                                                <option value="recommended_with_conditions" {{ old('jk_recommendation_status', $assistanceRequest->jk_recommendation_status) === 'recommended_with_conditions' ? 'selected' : '' }}>Sokong Bersyarat</option>
                                                <option value="not_recommended" {{ old('jk_recommendation_status', $assistanceRequest->jk_recommendation_status) === 'not_recommended' ? 'selected' : '' }}>Tidak Sokong</option>
                                            </select>
                                            @error('jk_recommendation_status') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label for="jk_recommendation" class="form-label">Catatan pengesyoran</label>
                                            <textarea id="jk_recommendation" name="jk_recommendation" class="form-control" rows="4" placeholder="Nyatakan justifikasi, syarat tambahan atau ulasan JK">{{ old('jk_recommendation', $assistanceRequest->jk_recommendation) }}</textarea>
                                            @error('jk_recommendation') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        </div>
                                        <button type="submit" class="btn btn-secondary w-100">Simpan Pengesyoran JK</button>
                                    </form>
                                </div>
                            @endif

                            @if(auth()->user()->role === 'admin' && $assistanceRequest->agent_verification === 'verified' && $assistanceRequest->status === 'in_process' && $assistanceRequest->jk_recommendation_status)
                                <div class="muted-block mt-2">
                                    <p class="mb-2"><strong>Keputusan Admin</strong></p>
                                    <form action="{{ route('assistance-requests.admin-decision', $assistanceRequest) }}" method="POST" class="section-stack">
                                        @csrf
                                        <div>
                                            <label for="admin_status" class="form-label">Keputusan</label>
                                            <select id="admin_status" name="status" class="form-select">
                                                <option value="approved">Luluskan permohonan</option>
                                                <option value="rejected">Tolak permohonan</option>
                                            </select>
                                            @error('status') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label for="approved_amount" class="form-label">Jumlah diluluskan</label>
                                            <input id="approved_amount" type="number" step="0.01" name="approved_amount" class="form-control" placeholder="Contoh: 500.00">
                                            @error('approved_amount') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label for="admin_rejection_reason" class="form-label">Sebab penolakan jika berkaitan</label>
                                            <textarea id="admin_rejection_reason" name="rejection_reason" class="form-control" rows="3" placeholder="Nyatakan sebab jika permohonan ditolak"></textarea>
                                            @error('rejection_reason') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Simpan Keputusan Admin</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if($assistanceRequest->jk_recommendation || $assistanceRequest->jk_recommendation_status)
                    <div class="card mt-0 mb-0">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-users"></i> Pengesyoran JK</h5>
                        </div>
                        <div class="card-body">
                            <div class="muted-block">
                                <p class="mb-2">
                                    <span class="badge bg-{{ $assistanceRequest->getJkRecommendationStatusBadgeClass() }}">
                                        {{ $assistanceRequest->getJkRecommendationStatusLabel() }}
                                    </span>
                                </p>
                                <p class="mb-0">{{ $assistanceRequest->jk_recommendation ?? 'Tiada catatan.' }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
