<?php

namespace App\Exports;

use App\Models\VMarcacionDia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class VMarcacionExportView implements FromView, WithColumnWidths,ShouldAutoSize
{

    public function view(): View
    {
//        ddd( VMarcacionDia::orderBy('id', 'desc')->take(100)->get());
        return view('pages.exports.marcacion-dia', [
            'data' => VMarcacionDia::orderBy('id', 'desc')->take(100)->get()
        ]);
    }

    public function columnWidths(): array
    {
        return ['A' => 350,];

    }
}
