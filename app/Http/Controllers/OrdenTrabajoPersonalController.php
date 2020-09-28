<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\VOrdenTrabajoPersonal;
use App\Util\myResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenTrabajoPersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function listPersonal(Request $request)
    {
        $ot = $request->input("ot");
        return response()->json(myResponse::apiResponse(VOrdenTrabajoPersonal::where('id_ot', $ot)->get(), "Listado de personal por OT"), 200, [], 256);
    }

    public function listOts(Request $request)
    {
        $data = DB::table('orden_trabajo');
        if (!empty($request->input('buscar'))) {
            $data = $data->where('producto_fabricar', 'like', '%' . $request->input('buscar') . '%');
            $data = $data->orWhere('cliente', 'like', '%' . $request->input('buscar') . '%');
        }
        $data = $data->paginate()->appends(request()->query());
        return view('pages.ots_personal')->with('data', $data);
    }

    public function listotsporpersonal(Request $request)
    {
        $dni = $request->input("dni");

        if (0 == (Personal::where('doc_ide', '=', $dni)->count())) {
            return response()->json(myResponse::apiResponse([], "Upss no tenemos a este personal registrado"), 200, [], 256);
        }
        $exec = VOrdenTrabajoPersonal::where('doc_ide', '=', $dni)->get();
        return response()->json(myResponse::apiResponse($exec), 200, [], 256);
    }

    public function listotsporpersonal2(Request $request)
    {
        $id = $request->input("id");


        $exec = VOrdenTrabajoPersonal::where('id_personal', $id)->get();
        return response()->json(myResponse::apiResponse($exec), 200, [], 256);
    }

    public function personal_disponible_por_ot(Request $request)
    {
        $data = array();
        $ot = $request->input("ot");

        $personal = DB::table('view_orden_trabajo_personal')->where('id_ot', $ot)->get();

        foreach ($personal as $i) {
            $validacion = DB::select(DB::raw("select mod(count(*),2) as valida  from marcacion where personal=" . $i->id_personal . " and year(fecha)=year(now()) and month(fecha)=month(now()) and day(fecha)=day(now()) and orden_trabajo <> '" . $ot . "' "));


            if ($validacion[0]->valida == 0) {
                $ingresos = DB::select(DB::raw("select * from marcacion where orden_trabajo='" . $ot . "' and personal = " . $i->id_personal . " and year(fecha)=year(now()) and month(fecha)=month(now()) and day(fecha)=day(now()) "));
                $arrIngresos = array();

                $i->ingresos = $ingresos;

                array_push($data, $i);
            }


        }


        return response()->json(myResponse::apiResponse($data, "Listado de personal por OT"), 200, [], 256);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
