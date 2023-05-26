<?php

namespace App\Http\Controllers\BagDevice;

use App\Http\Actions\BagDeviceAction;
use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $regions = Region::query()
            ->where("device_type", "Çanta Cihazları")
            ->where('tenant_id', auth()->user()->tenant_id)
            ->orderBy("name")->get();
        return view("admin.bag-devices.summary", compact('regions'));
    }

    public function refreshFeed() {
        $bagDeviceAction = new BagDeviceAction();
        $temp_values = $bagDeviceAction->refreshFeed();

        $html = view('admin.bag-devices.feed', compact('temp_values'))->render();
        return response()->json($html);
    }

    public function set_region(Request $request) {
        session(['bag_device_region' => $request->input('region')]);
    }
}
