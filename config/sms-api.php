<?php

return [
    'turkcell' => [
        'method' => 'POST',
        'url' => 'https://webservice.asistiletisim.com.tr/SmsProxy.asmx',
        'username' => env('TURKCELL_USERNAME'),
        'password' => env('TURKCELL_PASSWORD'),
        'userCode' => env('TURKCELL_USERCODE'),
        'accountID' => env('TURKCELL_ACCOUNTID'),
        'originator' => env('TURKCELL_ORIGINATOR')
    ]
];
