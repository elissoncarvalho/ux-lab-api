<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;

    protected $table = 'status';

    function exames()
    {
        return $this->hasMany(
            'App\Models\Exame',
            'exame_id',
            'id'
        );
    }
}
