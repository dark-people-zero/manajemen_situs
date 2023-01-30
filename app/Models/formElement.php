<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formElement extends Model
{
    protected $table = 'form_element';

    protected $fillable = [
        'name',
        'id_type_element',
        'placeholder',
        'switch_on',
        'switch_off',
        'is_multiple',
    ];

    public function typeElemen()
    {
        return $this->hasOne(typeElement::class, 'id', 'id_type_element');
    }


    public function optionElemen()
    {
        return $this->hasMany(optionElement::class, 'id_form_element', 'id');
    }
}
