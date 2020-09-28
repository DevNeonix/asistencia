<?php

namespace App\Http\Controllers;

use App\Models\CentroCosto;
use Illuminate\Http\Request;

class CentroCostoController extends Controller
{
    function index()
    {
        if (!empty(request()->input('buscar'))) {
            $data = CentroCosto::where('detalle','LIKE','%'.\request()->input('buscar').'%')
                ->where('codigo','LIKE','%'.\request()->input('buscar').'%')->paginate();
        }else{
            $data = CentroCosto::paginate();
        }

        return view('pages.centrocosto.index')->with(compact('data'));
    }

    function create(Request $request)
    {
        return view('pages.centrocosto.create');
    }

    function edit($id)
    {
        $centroCosto = CentroCosto::find($id);
        return view('pages.centrocosto.edit')->with(compact('centroCosto'));
    }

    function store(Request $request)
    {
        CentroCosto::create($request->all());
        return redirect()->route('admin.cc');
    }

    function update(Request $request, $id)
    {
        $centroCosto = CentroCosto::find($id);
        $centroCosto->update($request->all());
        return back();
    }
}
