<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestDetail extends Model
{
    protected $fillable = [
        'assistance_request_id', 'child_name', 'child_ic', 'child_age',
        'child_school_or_institution'
    ];

    public function assistanceRequest()
    {
        return $this->belongsTo(AssistanceRequest::class);
    }
}
