<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the assistance requests for this user.
     *
     * @return HasMany
     */
    public function assistanceRequests(): HasMany
    {
        return $this->hasMany(AssistanceRequest::class);
    }

    /**
     * Get the agent profile for this user (jika user adalah agen).
     *
     * @return HasOne
     */
    public function agent(): HasOne
    {
        return $this->hasOne(Agent::class);
    }

    /**
     * Semak sama ada user adalah agen.
     *
     * @return bool
     */
    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    /**
     * Semak sama ada user adalah Pentadbir.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Semak sama ada user adalah JK.
     *
     * @return bool
     */
    public function isJK(): bool
    {
        return $this->role === 'jk';
    }

    /**
     * Semak sama ada user adalah Ahli.
     *
     * @return bool
     */
    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    /**
     * Dapatkan label peranan pengguna
     */
    public function getRoleLabel(): string
    {
        return match ($this->role) {
            'member' => 'Ahli',
            'agent' => 'Agen',
            'jk' => 'Jawatankuasa',
            'admin' => 'Pentadbir',
            default => ucfirst($this->role),
        };
    }
}
