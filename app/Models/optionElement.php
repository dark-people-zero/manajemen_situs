<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class optionElement extends Model
{
    protected $table = 'option_element';

    protected $fillable = [
        'id_form_element',
        'code',
        'name',
    ];
}
