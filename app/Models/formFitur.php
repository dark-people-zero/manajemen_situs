<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formFitur extends Model
{
    protected $table = 'form_fitur';

    protected $fillable = [
        'id_fitur',
        'id_form_element',
    ];

    public function formElemen()
    {
        return $this->hasOne(formElement::class, 'id', 'id_form_element');
    }

    public function typeFitur()
    {
        return $this->hasOne(fitur::class, 'id', 'id_fitur');
    }

}
