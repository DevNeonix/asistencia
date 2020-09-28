<?php

namespace App\Exports;

use App\Models\VMarcacionDia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TareoExport implements FromView
{

    public function view(): View
    {
        set_time_limit(300);

        $marcaciones = VMarcacionDia::get();
        return view('pages.reportes.tareo',["marcaciones"=>$marcaciones]);
    }
}
