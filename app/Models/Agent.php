<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agent extends Model
{
    protected $fillable = [
        'user_id',
        'office_name',
        'office_address',
        'office_phone',
        'office_email',
        'designation',
        'description',
        'status',
        'remarks',
        'registered_by',
        'registered_at',
        'verified_at',
        'last_activity_at',
        'requests_verified_count',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'verified_at' => 'datetime',
        'last_activity_at' => 'datetime',
    ];

    /**
     * Hubungan ke User (Agen adalah Pengguna)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Hubungan ke User yang mendaftarkan agen (Pentadbir)
     */
    public function registeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    /**
     * Permohonan yang disahkan oleh agen ini
     */
    public function verifiedRequests(): HasMany
    {
        return $this->hasMany(AssistanceRequest::class, 'agent_id');
    }

    /**
     * Semak sama ada agen aktif
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Semak sama ada agen sedang cuti
     */
    public function isOnLeave(): bool
    {
        return $this->status === 'on_leave';
    }

    /**
     * Semak sama ada agen digantung
     */
    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    /**
     * Dapatkan label status
     */
    public function getStatusLabel(): string
    {
        return match ($this->status) {
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'on_leave' => 'Sedang Cuti',
            'suspended' => 'Digantung',
            default => ucfirst($this->status),
        };
    }

    /**
     * Dapatkan ikon status
     */
    public function getStatusIcon(): string
    {
        return match ($this->status) {
            'active' => 'check-circle',
            'inactive' => 'times-circle',
            'on_leave' => 'hourglass-half',
            'suspended' => 'ban',
            default => 'circle',
        };
    }

    /**
     * Dapatkan warna badge status
     */
    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'active' => 'success',
            'inactive' => 'secondary',
            'on_leave' => 'warning',
            'suspended' => 'danger',
            default => 'info',
        };
    }

    /**
     * Update aktiviti terakhir agen
     */
    public function recordActivity(): void
    {
        $this->update(['last_activity_at' => now()]);
    }

    /**
     * Tambah bilangan permohonan yang disahkan
     */
    public function incrementVerifiedCount(): void
    {
        $this->increment('requests_verified_count');
    }

    /**
     * Dapatkan bilangan permohonan yang tertanggung
     */
    public function getPendingRequestsCount(): int
    {
        return AssistanceRequest::where('agent_id', $this->id)
            ->where('agent_verification', 'pending')
            ->count();
    }

    /**
     * Dapatkan bilangan permohonan yang disahkan
     */
    public function getVerifiedRequestsCount(): int
    {
        return AssistanceRequest::where('agent_id', $this->id)
            ->where('agent_verification', 'verified')
            ->count();
    }

    /**
     * Dapatkan bilangan permohonan yang ditolak
     */
    public function getRejectedRequestsCount(): int
    {
        return AssistanceRequest::where('agent_id', $this->id)
            ->where('agent_verification', 'rejected')
            ->count();
    }
}
