<?php

namespace App\Http\Controllers;

use App\Http\Requests\OtsStoreRequest;
use App\Http\Requests\OtsUpdateRequest;
use App\Models\OrdenTrabajo;
use App\Util\myResponse;
use Illuminate\Http\Request;

class OrdenTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (!empty($request->input('buscar'))) {
            $data = OrdenTrabajo::where('producto_fabricar', 'like', '%' . $request->input('buscar') . '%');
            $data = $data->orWhere('cliente', 'like', '%' . $request->input('buscar') . '%');
            $data = $data->paginate()->appends(request()->query());
        } else {
            $data = OrdenTrabajo::paginate()->appends(request()->query());
        }


        return view('pages.ots')->with('data', $data);
    }

    public function list()
    {
        return response()->json(myResponse::apiResponse(OrdenTrabajo::all(), "Listado de OT's"), 200, [], 256);
    }

    function listOts(Request $request)
    {

        if (!empty($request->input('buscar'))) {
            $data = OrdenTrabajo::where('producto_fabricar', 'like', '%' . $request->input('buscar') . '%');
            $data = $data->orWhere('cliente', 'like', '%' . $request->input('buscar') . '%');
            $data = $data->paginate()->appends(request()->query());
        } else {

            $data = OrdenTrabajo::paginate()->appends(request()->query());
        }


        return view('pages.ots_personal')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('pages.ots_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(OtsStoreRequest $request)
    {
        $nro_orden = $request->input('nro_orden');
        $producto_fabricar = $request->input('producto_fabricar');
        $cliente = $request->input('cliente');
        $centro_costo_id = $request->input('centro_costo_id')==""?null:$request->input('centro_costo_id');
        $ot = OrdenTrabajo::create([
            'nro_orden' => $nro_orden,
            'producto_fabricar' => $producto_fabricar,
            'cliente' => $cliente,
            'estado' => '1',
            "centro_costo_id" => $centro_costo_id
        ]);
        return redirect()->route('admin.ots')->with('success', "La OT #" . $ot->id . " ha sido registrado correctamente.");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        $ot = OrdenTrabajo::where('id', $id)->first();
        return view('pages.ots_edit')->with(compact('ot'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(OtsUpdateRequest $request, $id)
    {
        $nro_orden = $request->input('nro_orden');
        $producto_fabricar = $request->input('producto_fabricar');
        $cliente = $request->input('cliente');
        $estado = $request->input('estado');
        $ubicacion = $request->input('ubicacion');
        $viatico = $request->input('viatico');
        $centro_costo_id = $request->input('centro_costo_id')==""?null:$request->input('centro_costo_id');

        $ot = OrdenTrabajo::where('id', $id)->update([
            'nro_orden' => $nro_orden,
            'producto_fabricar' => $producto_fabricar,
            'cliente' => $cliente,
            'estado' => $estado,
            "centro_costo_id" => $centro_costo_id,
            "ubicacion" => $ubicacion,
            "viatico" => $viatico
        ]);
        return redirect()->route('admin.ots')->with('success', "La OT ha sido modificado correctamente.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
