<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdemPedido extends Model
{
    use SoftDeletes;

    protected $appends = [
        'preparo_exame',
    ];

    function getPreparoExameAttribute() {
        return $this->sexo = 1 ? true : false;
    }

    function cliente()
    {
        return $this->hasOne(
            'App\Models\Cliente',
            'id',
            'cliente_id'
        );
    }

    function empresa()
    {
        return $this->hasOne(
            'App\Models\Empresa',
            'id',
            'empresa_id'
        );
    }

    function convenio()
    {
        return $this->hasOne(
            'App\Models\Convenio',
            'id',
            'convenio_id'
        );
    }

    function status()
    {
        return $this->hasOne(
            'App\Models\Status',
            'id',
            'status_id'
        );
    }
    function exames()
    {
        return $this->hasOne(
            'App\Models\Exame',
            'id',
            'status_id'
        );
    }
}
