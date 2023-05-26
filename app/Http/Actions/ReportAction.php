<?php

namespace App\Http\Actions;

use App\Http\Services\ReportService;
use App\Models\Report;

class ReportAction
{
    public function create($data) {

        $reportService = new ReportService($data);
        $result = $reportService->getResults();

        $reports = $this->getReports();

        $view = view('admin.report.display', compact('reports'))->render();
        return response()->json(['status' => $result, 'html' =>$view]);
    }

    public function getReports() {
        $reports = Report::query()
            ->orderBy('created_at', 'desc')->get();

        foreach($reports as &$report) {
            if(!file_exists(public_path('reports/'.auth()->user()->tenant_id.'/'.$report->name))) {
                $report->status = 'waiting';
            }
        }
        return $reports;
    }
}
