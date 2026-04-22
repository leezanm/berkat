<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestSubcategory extends Model
{
    protected $fillable = ['request_category_id', 'name', 'description', 'amount'];

    public function category()
    {
        return $this->belongsTo(RequestCategory::class, 'request_category_id');
    }
}
