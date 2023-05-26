<?php

namespace App\Http\Controllers;

use App\Http\Api\Turkcell;

class TestController
{
    public function index()
    {
        $sms = new Turkcell();
        $sms->setReceivers(["905324528844"]);
        print_r($sms->sendSMS('Merhaba'));
    }
}
