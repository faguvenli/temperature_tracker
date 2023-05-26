<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsTracker extends Model
{
    protected $fillable = ["phone_number", "sent_at", "message"];
}
