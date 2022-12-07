<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class log extends Model
{
    protected $table = 'log';

    protected $fillable = [
        'class',
        'name_activity',
        'data_ip',
        'data_location',
        'data_user',
        'data_before',
        'data_after',
        'keterangan',
    ];
}
