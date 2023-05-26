<?php

namespace App\Http\Controllers\BagDevice;

use App\DataTables\BagDeviceDataTable;
use App\Http\Actions\BagDeviceAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\BagDevice\BagDeviceStoreRequest;
use App\Http\Requests\BagDevice\BagDeviceUpdateRequest;
use App\Http\Services\AuthorizationService;
use App\Models\BagDevice;
use App\Models\BagDeviceType;
use App\Models\Region;

class BagDeviceController extends Controller
{
    public $authorizationService;

    public function __construct() {
        $this->authorizationService = new AuthorizationService();
        $this->authorizationService->setName("Çanta Cihazı");
    }

    public function index(BagDeviceDataTable $dataTable) {
        $this->authorizationService->canDisplayAndModify();
        return $dataTable->render('admin.bag-devices.index');
    }

    public function create() {
        $this->authorizationService->canCreate();

        $regions = Region::query()
            ->select('name', 'id')
            ->orderBy('name')
            ->where('device_type', 'Çanta Cihazları')
            ->where('tenant_id', auth()->user()->tenant_id)
            ->get();

        $bagDeviceTypes = BagDeviceType::query()
            ->select('name', 'id')
            ->orderBy('name')
            ->get();

        return view('admin.bag-devices.create', compact('regions', 'bagDeviceTypes'));
    }

    public function store(BagDeviceStoreRequest $request) {
        $this->authorizationService->canCreate();

        $bagDeviceAction = new BagDeviceAction();
        return $bagDeviceAction->store($request->validated());
    }

    public function edit(BagDevice $bagDevice) {
        $this->authorizationService->canUpdate();
        $regions = Region::query()
            ->select('name', 'id')
            ->orderBy('name')
            ->where('device_type', 'Çanta Cihazları')
            ->where('tenant_id', auth()->user()->tenant_id)
            ->get();

        $bagDeviceTypes = BagDeviceType::query()
            ->select('name', 'id')
            ->orderBy('name')
            ->get();

        return view('admin.bag-devices.update', compact('bagDevice', 'regions', 'bagDeviceTypes'));
    }

    public function update(BagDevice $bagDevice, BagDeviceUpdateRequest $request) {
        $this->authorizationService->canUpdate();

        $bagDeviceAction = new BagDeviceAction();
        return $bagDeviceAction->update($bagDevice, $request->validated());
    }

    public function destroy(BagDevice $bagDevice) {
        $this->authorizationService->canDelete();
        $bagDevice->delete();
        return response()->json(['url' => route('bag-devices.index')]);
    }
}
