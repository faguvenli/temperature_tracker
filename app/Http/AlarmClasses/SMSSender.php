<?php

namespace App\Http\AlarmClasses;

use App\Http\Api\Turkcell;
use App\Models\AlarmTracker;
use App\Models\SmsTracker;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SMSSender
{
    public function __invoke()
    {

        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            $users = User::query()
                ->select('phone')
                ->where('tenant_id', $tenant->id)
                ->where('send_sms_notification', true)
                ->where('active', true)
                ->whereNotNull('phone')
                ->get()->pluck('phone')->toArray();

            //Config::set('database.connections.tenant.database', $tenant->database);
            config(['database.connections.tenant.database' => $tenant->database]);

            $alarms = AlarmTracker::query()
                ->where('message_sent', 0)
                ->whereRaw('timestampdiff(MINUTE, created_at, updated_at) < 35')
                ->get();

            foreach ($alarms as $alarm) {
                $firstDate = new \Carbon\Carbon($alarm->created_at);
                $lastDate = new \Carbon\Carbon($alarm->updated_at);
                $difference = $firstDate->diffInMinutes($lastDate);
                if ($difference >= 30) {
                    $alarm->message_sent = 1;
                    $alarm->save();

                    $smsText = "!!ALARM!!\n" . $tenant->name . "\nCihaz Adı: " . $alarm->envDevice->name . "\nIsı değeri: " . $alarm->temperature . " derece.\nLütfen Kontrol Edin.";

                    if ($users) {
                        $sms = new Turkcell();
                        $sms->setReceivers($users);
                        $sms->sendSMS(encodingFixer($smsText));
                        foreach ($users as $phoneNumber) {
                            SmsTracker::create([
                                'phone_number' => $phoneNumber,
                                'message' => $smsText,
                                'sent_at' => new \Carbon\Carbon(now())
                            ]);
                        }
                    }

                }
            }
            DB::disconnect('tenant');
        }
    }
}
