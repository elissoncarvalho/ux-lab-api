<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exame extends Model
{
    use SoftDeletes;

    function status()
    {
        return $this->hasOne(
            'App\Models\Status',
            'status_id',
            'id'
        );
    }
}
