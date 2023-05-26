<?php

namespace App\Http\Controllers;

use App\Http\Actions\ReportAction;
use App\Http\Requests\Report\ReportCreateRequest;

class ReportController extends Controller
{
    public function index()
    {
        $reportAction = new ReportAction();
        $reports = $reportAction->getReports();

        return view('admin.report.index', compact('reports'));
    }

    public function create(ReportCreateRequest $request)
    {
        $reportAction = new ReportAction();
        return $reportAction->create($request->validated());
    }
}
