<?php

namespace App\Http\Controllers;

use App\DataTables\RoleDataTable;
use App\Http\Actions\RoleAction;
use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Http\Services\AuthorizationService;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{
    public $authorizationService;

    public function __construct() {
        $this->authorizationService = new AuthorizationService();
        $this->authorizationService->setName("Yetki");
    }

    public function index(RoleDataTable $dataTable) {
        $this->authorizationService->canDisplayAndModify();
        return $dataTable->render('admin.roles.index');
    }

    public function create() {
        $this->authorizationService->canCreate();
        $permission_groups = $this->getPermissions();
        return view('admin.roles.create', compact('permission_groups'));
    }

    public function store(RoleStoreRequest $request) {
        $this->authorizationService->canCreate();

        $roleAction = new RoleAction();
        return $roleAction->store($request->validated());
    }

    public function edit(Role $role) {
        $this->authorizationService->canUpdate();
        $permission_groups = $this->getPermissions();
        return view('admin.roles.update', compact('role', 'permission_groups'));
    }

    public function update(Role $role, RoleUpdateRequest $request) {
        $this->authorizationService->canUpdate();

        $roleAction = new RoleAction();
        return $roleAction->update($role, $request->validated());
    }

    public function destroy(Role $role) {
        $this->authorizationService->canDelete();
        $role->delete();
        return response()->json(['url' => route('roles.index')]);
    }

    public function getPermissions() {
        $roleAction = new RoleAction();
        return $roleAction->getPermissions();
    }
}
