<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class aksesFitur extends Model
{
    protected $table = 'akses_fitur';

    protected $fillable = [
        'id_akses_situs',
        'id_fitur',
        'desktop',
        'mobile',
    ];

    public function fitur()
    {
        return $this->hasOne(fitur::class, 'id', 'id_fitur');
    }

    public function fiturSitus(Type $var = null)
    {
        # code...
        return $this->hasOne(fiturSitus::class, 'id', 'id_fitur');
    }
}
