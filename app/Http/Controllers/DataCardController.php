<?php

namespace App\Http\Controllers;

use App\DataTables\DataCardDataTable;
use App\Http\Actions\DataCardAction;
use App\Http\Requests\DataCard\DataCardStoreRequest;
use App\Http\Requests\DataCard\DataCardUpdateRequest;
use App\Http\Services\AuthorizationService;
use App\Models\DataCard;

class DataCardController extends Controller
{
    public $authorizationService;

    public function __construct() {
        $this->authorizationService = new AuthorizationService();
        $this->authorizationService->setName("Data Kartı");
    }

    public function index(DataCardDataTable $dataTable) {
        $this->authorizationService->canDisplayAndModify();
        return $dataTable->render('admin.data-cards.index');
    }

    public function create() {
        $this->authorizationService->canCreate();
        return view('admin.data-cards.create');
    }

    public function store(DataCardStoreRequest $request) {
        $this->authorizationService->canCreate();

        $dataCardAction = new DataCardAction();
        return $dataCardAction->store($request->validated());
    }

    public function edit(DataCard $dataCard) {
        $this->authorizationService->canUpdate();
        return view('admin.data-cards.update', compact('dataCard'));
    }

    public function update(DataCard $dataCard, DataCardUpdateRequest $request) {
        $this->authorizationService->canUpdate();

        $dataCardAction = new DataCardAction();
        return $dataCardAction->update($dataCard, $request->validated());
    }

    public function destroy(DataCard $dataCard) {
        $this->authorizationService->canDelete();
        $dataCard->delete();
        return response()->json(['url' => route('data-cards.index')]);
    }
}
