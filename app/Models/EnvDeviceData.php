<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class EnvDeviceData extends Model
{
    use HasEagerLimit;

    protected $connection = 'tenant';
}
