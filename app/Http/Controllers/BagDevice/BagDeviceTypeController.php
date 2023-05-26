<?php

namespace App\Http\Controllers\BagDevice;

use App\DataTables\BagDeviceTypeDataTable;
use App\Http\Actions\BagDeviceTypeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\BagDevice\BagDeviceTypeStoreRequest;
use App\Http\Requests\BagDevice\BagDeviceTypeUpdateRequest;
use App\Http\Services\AuthorizationService;
use App\Models\BagDeviceType;

class BagDeviceTypeController extends Controller
{
    public $authorizationService;

    public function __construct() {
        $this->authorizationService = new AuthorizationService();
        $this->authorizationService->setName("Çanta Cihaz Tipi");
    }

    public function index(BagDeviceTypeDataTable $dataTable) {
        $this->authorizationService->canDisplayAndModify();
        return $dataTable->render('admin.bag-device-types.index');
    }

    public function create() {
        $this->authorizationService->canCreate();
        return view('admin.bag-device-types.create');
    }

    public function store(BagDeviceTypeStoreRequest $request) {
        $this->authorizationService->canCreate();

        $bagDeviceTypeAction = new BagDeviceTypeAction();
        return $bagDeviceTypeAction->store($request->validated());
    }

    public function edit(BagDeviceType $bagDeviceType) {
        $this->authorizationService->canUpdate();
        return view('admin.bag-device-types.update', compact('bagDeviceType'));
    }

    public function update(BagDeviceType $bagDeviceType, BagDeviceTypeUpdateRequest $request) {
        $this->authorizationService->canUpdate();

        $bagDeviceTypeAction = new BagDeviceTypeAction();
        return $bagDeviceTypeAction->update($bagDeviceType, $request->validated());
    }

    public function destroy(BagDeviceType $bagDeviceType) {
        $this->authorizationService->canDelete();
        $bagDeviceType->delete();
        return response()->json(['url' => route('bag-device-types.index')]);
    }
}
