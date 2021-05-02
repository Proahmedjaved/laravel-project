<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = ucfirst($value);
    }
}
