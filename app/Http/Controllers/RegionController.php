<?php

namespace App\Http\Controllers;

use App\DataTables\RegionDataTable;
use App\Http\Actions\RegionAction;
use App\Http\Requests\Region\RegionStoreRequest;
use App\Http\Requests\Region\RegionUpdateRequest;
use App\Http\Services\AuthorizationService;
use App\Models\Region;

class RegionController extends Controller
{
    public $authorizationService;

    public function __construct() {
        $this->authorizationService = new AuthorizationService();
        $this->authorizationService->setName("Bölge");
    }

    public function index(RegionDataTable $dataTable) {
        $this->authorizationService->canDisplayAndModify();
        return $dataTable->render('admin.regions.index');
    }

    public function create() {
        $this->authorizationService->canCreate();
        $deviceTypes = getTypes(["Çanta Cihazları", "Çevre Cihazları"]);
        return view('admin.regions.create', compact('deviceTypes'));
    }

    public function store(RegionStoreRequest $request) {
        $this->authorizationService->canCreate();

        $regionAction = new RegionAction();
        return $regionAction->store($request->validated());
    }

    public function edit(Region $region) {
        $this->authorizationService->canUpdate();
        $deviceTypes = getTypes(["Çanta Cihazları", "Çevre Cihazları"]);
        return view('admin.regions.update', compact('region', 'deviceTypes'));
    }

    public function update(Region $region, RegionUpdateRequest $request) {
        $this->authorizationService->canUpdate();

        $regionAction = new RegionAction();
        return $regionAction->update($region, $request->validated());
    }

    public function destroy(Region $region) {
        $this->authorizationService->canDelete();
        $region->delete();
        return response()->json(['url' => route('admin.regions.index')]);
    }
}
