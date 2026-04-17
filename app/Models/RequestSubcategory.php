<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestSubcategory extends Model
{
    protected $fillable = ['request_category_id', 'name', 'description'];

    public function category()
    {
        return $this->belongsTo(RequestCategory::class);
    }
}
