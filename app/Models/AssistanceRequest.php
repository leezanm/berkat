<?php

namespace App\Models;

use App\Models\AssistanceRequestDocument;
use Illuminate\Database\Eloquent\Model;

class AssistanceRequest extends Model
{
    protected $fillable = [
        'user_id', 'request_type_id', 'request_category_id', 'request_subcategory_id',
        'purpose', 'applicant_name', 'applicant_ic', 'applicant_salary',
        'applicant_position', 'applicant_office_address', 'applicant_accounting_office',
        'applicant_phone', 'applicant_email', 'applicant_bank_account', 'household_income',
        'dependents_count', 'disabled_dependents_count', 'spouse_name', 'spouse_ic',
        'spouse_salary', 'spouse_position', 'status', 'agent_verification',
        'approved_amount', 'rejection_reason', 'approved_at', 'jk_recommendation', 'jk_recommendation_status',
        'submitted_at', 'agent_id', 'agent_filled'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'agent_filled' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requestType()
    {
        return $this->belongsTo(RequestType::class);
    }

    public function category()
    {
        return $this->belongsTo(RequestCategory::class, 'request_category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(RequestSubcategory::class, 'request_subcategory_id');
    }

    public function details()
    {
        return $this->hasMany(RequestDetail::class);
    }

    public function documents()
    {
        return $this->hasMany(AssistanceRequestDocument::class);
    }

    /**
     * Hubungan ke Agent yang mengesahkan permohonan
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    /**
     * Hubungan ke User melalui Agent (untuk mendapatkan maklumat pengguna agen)
     */
    public function agentUser()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            'draft' => 'Draf',
            'submitted' => 'Dihantar',
            'in_process' => 'Dalam Proses',
            'approved' => 'Diluluskan',
            'rejected' => 'Ditolak',
            default => ucfirst((string) $this->status),
        };
    }

    public function getStatusIcon(): string
    {
        return match ($this->status) {
            'draft' => 'file',
            'submitted' => 'paper-plane',
            'in_process' => 'spinner',
            'approved' => 'check-circle',
            'rejected' => 'times-circle',
            default => 'circle',
        };
    }

    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'approved' => 'success',
            'rejected' => 'danger',
            'submitted', 'in_process' => 'info',
            default => 'secondary',
        };
    }

    public function getAgentVerificationLabel(): string
    {
        return match ($this->agent_verification) {
            'verified' => 'Disahkan',
            'rejected' => 'Ditolak',
            default => 'Menunggu',
        };
    }

    public function getAgentVerificationIcon(): string
    {
        return match ($this->agent_verification) {
            'verified' => 'check-circle',
            'rejected' => 'times-circle',
            default => 'hourglass-half',
        };
    }

    public function getAgentVerificationBadgeClass(): string
    {
        return match ($this->agent_verification) {
            'verified' => 'success',
            'rejected' => 'danger',
            default => 'warning',
        };
    }

    public function getJkRecommendationStatusLabel(): string
    {
        return match ($this->jk_recommendation_status) {
            'recommended' => 'Sokong',
            'recommended_with_conditions' => 'Sokong Bersyarat',
            'not_recommended' => 'Tidak Sokong',
            default => 'Belum Ada Pengesyoran',
        };
    }

    public function getJkRecommendationStatusBadgeClass(): string
    {
        return match ($this->jk_recommendation_status) {
            'recommended' => 'success',
            'recommended_with_conditions' => 'warning',
            'not_recommended' => 'danger',
            default => 'secondary',
        };
    }
}
