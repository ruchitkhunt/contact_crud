<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'gender', 'profile_image', 'additional_file'];
    public function customValues()
    {
        return $this->hasMany(ContactCustomValue::class);
    }
}
