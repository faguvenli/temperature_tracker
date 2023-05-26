<?php

namespace App\Http\Controllers;

use App\Http\Actions\EnvDeviceAction;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isPanelUser) {
            return view('admin._dashboard');
        } else {
            return view('tablet.index');
        }
    }

    public function refreshFeed() {
        $envDeviceAction = new EnvDeviceAction();
        $temp_values = $envDeviceAction->refreshFeed();

        $html = view('tablet.feed', compact('temp_values'))->render();

        return response()->json($html);
    }
}
