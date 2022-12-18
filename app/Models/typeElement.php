<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeElement extends Model
{
    protected $table = 'type_element';

    protected $fillable = [
        'name',
        'keterangan',
    ];
}
