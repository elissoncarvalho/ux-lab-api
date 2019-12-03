<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;

    function endereco()
    {
        return $this->hasOne(
            'App\Models\Endereco',
            'id',
            'endereco_id'
        );
    }
}
