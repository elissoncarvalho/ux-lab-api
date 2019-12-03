<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;
    
    protected $appends = [
        'sexo',
    ];

    function getSexoAttribute() {
        return $this->sexo = 1 ? 'Feminio' : 'Masculino';
    }

    function endereco()
    {
        return $this->hasOne(
            'App\Models\Endereco',
            'id',
            'endereco_id'
        );
    }

    public function delete()
    {
        $this->endereco()->delete();

        return parent::delete();
    }

    public function restore()
    {
        $this->endereco()->restore();
        
        return parent::restore();
    }
}
