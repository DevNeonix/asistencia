<?php

namespace App\Exports;

use App\Models\Marcacion;
use App\Models\Personal;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TareoXLSExport implements FromView,ShouldAutoSize
{

    public function view(): View
    {
        ini_set('max_execution_time', 300);
        $order = \request()->input('orden') ?? 'fecha';


        if (empty(\request("f1")) || empty(\request("f2"))) {
            $f1 = Carbon::now()->format("Y-m-d") . " 00:00:01";
            $f2 = Carbon::now()->format("Y-m-d") . " 23:59:59";
        } else {
            $f1 = \request("f1")." 00:00:01";
            $f2 = Carbon::make(\request("f2"))->format("Y-m-d")." 23:59:59";
        }



        $personalID = Marcacion::whereBetween("fecha", [$f1, $f2])
            ->get()->pluck('personal');
        $personal = Personal::whereIn('id',$personalID)->get();
        return view('pages.reportes.tareo_excel')->with(['personal'=> $personal]);
    }
}
