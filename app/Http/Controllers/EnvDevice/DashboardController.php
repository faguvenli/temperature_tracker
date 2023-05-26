<?php

namespace App\Http\Controllers\EnvDevice;

use App\Http\Actions\EnvDeviceAction;
use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $regions = Region::query()
            ->where('device_type', "Çevre Cihazları")
            ->where('tenant_id', auth()->user()->tenant_id)
            ->orderBy('name')->get();
        return view('admin.env-devices.summary', compact('regions'));
    }

    public function refreshFeed() {
        $envDeviceAction = new EnvDeviceAction();
        $temp_values = $envDeviceAction->refreshFeed();
        $alarm = $envDeviceAction->getAlarm();

        if(auth()->user()->isPanelUser) {
            $html = view('admin.env-devices.feed', compact('temp_values'))->render();
        } else {
            $html = view('tablet.feed', compact('temp_values', 'alarm'))->render();
        }

        return response()->json($html);
    }

    public function set_region(Request $request) {
        session(['env_device_region' => $request->input('region')]);
    }
}
