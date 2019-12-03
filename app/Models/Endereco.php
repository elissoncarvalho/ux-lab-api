<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Endereco extends Model
{
    use SoftDeletes;

    function cliente()
    {
        return $this->hasOne(
            'App\Models\Cliente',
            'cliente_id',
            'id'
        );
    }
}
