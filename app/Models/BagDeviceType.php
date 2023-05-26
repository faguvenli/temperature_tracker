<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BagDeviceType extends Model
{
    protected $connection = 'tenant';
    protected $fillable = ["name", "description"];
}
