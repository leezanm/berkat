<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssistanceRequestChild extends Model
{
    protected $table = 'assistance_request_children';

    protected $fillable = [
        'assistance_request_id',
        'child_name',
        'child_ic',
        'age',
        'school_name',
    ];

    protected $casts = [
        'age' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the assistance request that owns this child record
     */
    public function assistanceRequest(): BelongsTo
    {
        return $this->belongsTo(AssistanceRequest::class, 'assistance_request_id');
    }
}
