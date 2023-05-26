<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataCard extends Model
{
    protected $connection = 'tenant';
    protected $fillable = ["GSMID", "SIMID", "PIN1", "PUK1", "PIN2", "PUK2", "IMEI"];
}
