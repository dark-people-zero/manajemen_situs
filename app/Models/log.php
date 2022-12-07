<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class log extends Model
{
    protected $table = 'log';

    protected $fillable = [
        'model',
        'before',
        'after',
        'updated_id',
        'updated_name',
        'updated_ip',
    ];
}
