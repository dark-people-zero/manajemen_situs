<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ipModel extends Model
{
    protected $table = 'ip';

    protected $fillable = [
        'username',
        'ip',
    ];
}
