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
        'option',
        'switch_on',
        'switch_off',
        'is_multiple',
    ];
}
