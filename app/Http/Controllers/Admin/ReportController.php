<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reports\Report;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.reports.index');
    }

    public function run(Request $request, $reportName, Report $report)
    {
        $data = $report->run($request, $reportName);
        $data['reportName'] = $reportName;
        $data['uri'] = $reportName;
        return view('admin.reports.report', compact('data'));
    }

    public function download(Request $request, $reportName, Report $report)
    {
        $data = $report->run($request, $reportName);
        $data['reportName'] = $reportName;
        $data['uri'] = $reportName;
        $pdf = PDF::loadView('admin.reports.report', $data);
        return $pdf->download($reportName.'.pdf');
    }
}
