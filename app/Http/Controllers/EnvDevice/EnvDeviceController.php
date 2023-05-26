<?php

namespace App\Http\Controllers\EnvDevice;

use App\DataTables\EnvDeviceDataTable;
use App\Http\Actions\EnvDeviceAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\EnvDevice\EnvDeviceStoreRequest;
use App\Http\Requests\EnvDevice\EnvDeviceUpdateRequest;
use App\Http\Services\AuthorizationService;
use App\Models\EnvDevice;

class EnvDeviceController extends Controller
{
    public $authorizationService;

    public function __construct() {
        $this->authorizationService = new AuthorizationService();
        $this->authorizationService->setName("Çevre Cihazı");
    }

    public function index(EnvDeviceDataTable $dataTable) {
        $this->authorizationService->canDisplayAndModify();
        return $dataTable->render('admin.env-devices.index');
    }

    public function create() {
        $this->authorizationService->canCreate();
        $envDeviceAction = new EnvDeviceAction();

        $regions = $envDeviceAction->getRegions();
        $confirmValues = $envDeviceAction->getConfirmValues();
        $alarmValues = $envDeviceAction->getAlarmValues();
        $envDeviceTypes = $envDeviceAction->getDeviceTypes();

        return view('admin.env-devices.create', compact('regions', 'envDeviceTypes', 'confirmValues', 'alarmValues'));
    }

    public function store(EnvDeviceStoreRequest $request) {
        $this->authorizationService->canCreate();

        $envDeviceAction = new EnvDeviceAction();
        return $envDeviceAction->store($request->validated());
    }

    public function edit(EnvDevice $envDevice) {
        $this->authorizationService->canUpdate();
        $envDeviceAction = new EnvDeviceAction();

        $regions = $envDeviceAction->getRegions();
        $envDeviceTypes = $envDeviceAction->getDeviceTypes();
        $alarmValues = $envDeviceAction->getAlarmValues();
        $confirmValues = $envDeviceAction->getConfirmValues();

        return view('admin.env-devices.update', compact('envDevice', 'regions', 'envDeviceTypes', 'confirmValues', 'alarmValues'));
    }

    public function update(EnvDevice $envDevice, EnvDeviceUpdateRequest $request) {
        $this->authorizationService->canUpdate();

        $envDeviceAction = new EnvDeviceAction();
        return $envDeviceAction->update($envDevice, $request->validated());
    }

    public function destroy(EnvDevice $envDevice) {
        $this->authorizationService->canDelete();
        $envDevice->delete();
        return response()->json(['url' => route('env-devices.index')]);
    }
}
