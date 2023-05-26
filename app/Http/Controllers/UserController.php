<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Http\Actions\UserAction;
use App\Http\Api\Turkcell;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Services\AuthorizationService;
use App\Models\Region;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public $authorizationService;

    public function __construct() {
        $this->authorizationService = new AuthorizationService();
        $this->authorizationService->setName("Kullanıcı");
    }

    public function index(UserDataTable $dataTable) {
        $this->authorizationService->canDisplayAndModify();
        return $dataTable->render('admin.users.index');
    }

    public function create() {
        $this->authorizationService->canCreate();
        $roles = Role::query()->select('name', 'id')->get();
        $regions = Region::query()->select('device_type', 'name', 'id')
            ->where('tenant_id', auth()->user()->tenant_id)
            ->orderBy('name')->get();
        $tenants = Tenant::query()->select('name', 'id')->orderBy('name')->get();
        return view('admin.users.create', compact('roles', 'regions', 'tenants'));
    }

    public function store(UserStoreRequest $request) {
        $this->authorizationService->canCreate();

        $userAction = new UserAction();
        return $userAction->store($request->validated());
    }

    public function edit(User $user) {
        $this->authorizationService->canUpdate();
        $roles = Role::query()->select('name', 'id')->get();
        $regions = Region::query()->select('device_type', 'name', 'id')
            ->where('tenant_id', auth()->user()->tenant_id)
            ->orderBy('name')->get();
        $tenants = Tenant::query()->select('name', 'id')->orderBy('name')->get();
        return view('admin.users.update', compact('user', 'roles', 'regions', 'tenants'));
    }

    public function update(User $user, UserUpdateRequest $request) {
        $this->authorizationService->canUpdate();

        $userAction = new UserAction();
        return $userAction->update($user, $request->validated());
    }

    public function destroy(User $user) {
        $this->authorizationService->canDelete();
        $user->delete();
        return response()->json(['url' => route('users.index')]);
    }

    public function change_tenant(Request $request) {
        $tenantID = $request->input('tenantID');
        if(auth()->check() && auth()->user()->isSuperAdmin) {
            auth()->user()->update([
               'tenant_id' => $tenantID
            ]);
            return response()->json('success');
        }
    }

    public function send_test_sms(Request $request) {
        $user = User::find(auth()->id());
        $phoneNumber = $user->phone;
        if(!$phoneNumber) {
            return response()->json(['status' => 'error', 'message' => 'Telefon numarası bulunamadı. Lütfen test yapmadan önce numara ekleyip kaydedin.']);
        }

        $confirmationCode = rand(1000,9999);
        $user->smsConfirmationCode = $confirmationCode;
        $user->save();
        $sms = new Turkcell();
            $sms->setReceivers([$phoneNumber]);
            $smsStatus = $sms->sendSMS(encodingFixer("SMS Onay Kodunuz:\n".$confirmationCode));

            if($smsStatus['ErrorCode'] == 0) {
                return response()->json(['status' => 'success', 'message' => 'Mesaj gönderildi.']);
            } else {
                return response()->json(['status' => 'error', 'message' => $sms->getErrorMessage()]);
            }
    }

    public function check_sms_confirmation(Request $request) {
        $user = User::find(auth()->id());
        if($request->input('code') == $user->smsConfirmationCode) {
            $user->phoneNumberVerified = true;
            $user->save();
            return response()->json(['status' => 'success', 'message' => 'Telefon numaranız başarıyla onaylandı!']);
        }
        return response()->json(['status' => 'error', 'message' => 'Onay kodu doğrulanamadı!']);
    }
}
