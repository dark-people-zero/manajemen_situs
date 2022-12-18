<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class optionElement extends Model
{
    protected $table = 'option_element';

    protected $fillable = [
        'code',
        'name',
    ];
}
