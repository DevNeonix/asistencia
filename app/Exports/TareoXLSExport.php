<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class TareoXLSExport implements FromView
{

    public function view(): View
    {
        return view('pages.exports.tareo');
    }
}
