<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class situs extends Model
{
    protected $table = 'situs';

    protected $fillable = [
        'name',
        'status_desktop',
        'status_mobile',
        'url_desktop_dev',
        'url_desktop_prod',
        'url_mobile_dev',
        'url_mobile_prod'
    ];

}
