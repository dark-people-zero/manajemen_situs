<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class aksesMenu extends Model
{
    protected $table = 'akses_menu';

    protected $fillable = [
        'id_user',
        'name',
        'C',
        'R',
        'U',
        'D',
    ];
}
