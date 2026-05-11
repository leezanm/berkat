<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'assistance_request_id',
        'user_id',
        'paid_by',
        'amount',
        'payment_method',
        'payment_reference',
        'payment_date',
        'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount'       => 'decimal:2',
    ];

    public function assistanceRequest()
    {
        return $this->belongsTo(AssistanceRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function paidByUser()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    public function getPaymentMethodLabel(): string
    {
        return match ($this->payment_method) {
            'pindahan_bank' => 'Pindahan Bank',
            'cek'           => 'Cek',
            'tunai'         => 'Tunai',
            default         => 'Lain-lain',
        };
    }
}
