<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class situs extends Model
{
    protected $table = 'situs';

    protected $fillable = [
        'situs_code',
        'name',
        'status_desktop',
        'status_mobile',
        'url_desktop_dev',
        'url_desktop_prod',
        'url_mobile_dev',
        'url_mobile_prod'
    ];

    public function fiturSitus()
    {
        return $this->hasMany(fiturSitus::class, 'id_situs', 'id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'fiturSitus',
    ];

}
