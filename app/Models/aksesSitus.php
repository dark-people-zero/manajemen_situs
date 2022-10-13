<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class aksesSitus extends Model
{
    protected $table = 'akses_situs';

    protected $fillable = [
        'id_user',
        'id_situs',
    ];

    public function situs()
    {
        return $this->hasOne(situs::class, 'id', 'id_situs');
    }

    public function aksesFitur()
    {
        return $this->hasMany(aksesFitur::class, 'id_akses_situs', 'id');
    }
}
