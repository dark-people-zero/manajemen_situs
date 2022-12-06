<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fiturSitus extends Model
{
    protected $table = 'fitur_situs';

    protected $fillable = [
        'id_situs',
        'id_fitur',
        'type',
        'status',
        'data',
        'data_approve'
    ];

    public function fitur()
    {
        return $this->hasOne(fitur::class, 'id', 'id_fitur');
    }
}
