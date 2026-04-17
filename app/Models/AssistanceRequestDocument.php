<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssistanceRequestDocument extends Model
{
    protected $fillable = [
        'assistance_request_id',
        'document_key',
        'document_label',
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
    ];

    public function assistanceRequest()
    {
        return $this->belongsTo(AssistanceRequest::class);
    }
}
