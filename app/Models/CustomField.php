<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    protected $fillable = ['field_name', 'field_type'];
    public function values()
    {
        return $this->hasMany(ContactCustomValue::class);
    }
}
