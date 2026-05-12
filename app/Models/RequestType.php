<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestType extends Model
{
    protected $fillable = ['name', 'description'];

    public function categories()
    {
        return $this->hasMany(RequestCategory::class);
    }

    public function assistanceRequests()
    {
        return $this->hasMany(AssistanceRequest::class);
    }
}
