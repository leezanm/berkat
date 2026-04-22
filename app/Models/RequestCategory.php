<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestCategory extends Model
{
    protected $fillable = ['request_type_id', 'name', 'description'];

    public function requestType()
    {
        return $this->belongsTo(RequestType::class, 'request_type_id');
    }

    public function subcategories()
    {
        return $this->hasMany(RequestSubcategory::class, 'request_category_id');
    }
}
