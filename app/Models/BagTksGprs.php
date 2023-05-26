<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class BagTksGprs extends Model
{
    use HasEagerLimit;

    protected $connection = 'tenant';
}
