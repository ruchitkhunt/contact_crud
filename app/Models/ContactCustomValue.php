<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactCustomValue extends Model
{
    protected $fillable = ['contact_id', 'custom_field_id', 'value'];
    public function field()
    {
        return $this->belongsTo(CustomField::class);
    }
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
