<?php

namespace App\Exports;

use App\Models\Marcacion;
use App\Models\Personal;
use App\Models\VMarcacion;
use DateTime;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VMarcacionExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    private $fini;
    private $ffin;
    private $order;

    /**
     * VMarcacionExport constructor.
     * @param $fini
     * @param $ffin
     */
    public function __construct($fini, $ffin, $order)
    {
        $this->fini = $fini;
        $this->ffin = $ffin;
        $this->order = $order;
    }




    public function view(): View
    {
        $f1 = "";
        $f2 = "";
        $order = "";
        if (empty($this->fini) || empty($this->ffin) || empty($this->order)) {
            $f1 = date("Y-m-d");
            $f2 = new DateTime('+1 day');
            $order = "fecha";
        } else {
            $f1 = $this->fini;
            $f2 = new DateTime($this->ffin);
            $f2->modify('+1 day');
            $order = $this->order;
        }




        $asistencias = Marcacion::whereBetween("fecha", [$f1, $f2->format('Y-m-d')])->distinct()->get()->pluck('personal');
        $asistencias = Personal::whereIn('id',$asistencias)->orderBy("apellidos")->get();
        return view('pages.reportes.asistencia-personal-excel')->with('data', $asistencias);

    }
}
