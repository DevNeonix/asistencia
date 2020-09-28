<?php

namespace App\Http\Controllers;

use App\Exports\TareoXLSExport;
use App\Exports\VMarcacionExportView;
use App\Models\VMarcacionDia;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TareoController extends Controller
{
    function index()
    {
//        $data = VMarcacionDia::get();
//        return view('pages.reportes.tareo', ["data" => $data]);
        return view('pages.reportes.tareo');
    }

    function export()
    {
//        $data = VMarcacionDia::get();
//        return view('pages.reportes.tareo', ["data" => $data]);
        return Excel::download(new TareoXLSExport(), 'tareo.xlsx');
    }
}
