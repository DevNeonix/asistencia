<?php

namespace App\Http\Controllers;

use App\Exports\TareoExport;
use App\Exports\VMarcacionExport;
use App\Exports\VMarcacionExportView;
use App\Models\Marcacion;
use App\Models\MarcacionObs;
use App\Models\Personal;
use App\Models\VOrdenTrabajoPersonal;
use DateTime;
use App\Util\myResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MarcacionController extends Controller
{

    public function registro(Request $request)
    {
        $personal = $request->input('personal');
        $orden_trabajo = $request->input('orden_trabajo');
        $usr = $request->input('usr');
        $viatico = $request->input('viatico');
        $obs = $request->input('obs');
        $validacion = DB::select(DB::raw("select mod(count(*),2) as valida  from marcacion where personal=" . $personal . " and year(fecha)=year(now()) and month(fecha)=month(now()) and day(fecha)=day(now()) and orden_trabajo <> '" . $orden_trabajo . "' "));


        if ($validacion[0]->valida == 0) {


            $marcacion = Marcacion::create([
                "personal" => $personal,
                "orden_trabajo" => $orden_trabajo,
                "fecha" => \Carbon\Carbon::now(),
                "usuario_registra" => $usr,
            ]);
            if (strtolower($obs) == "observaciones") {
                $obs = "";
            }
            MarcacionObs::create([
                "marcacion_id" => $marcacion->id,
                "viatico" => $viatico,
                "obs" => $obs,
            ]);

            return response()->json(myResponse::apiResponse([], "Asistencia registrada correctamente"));
        } else {
            return response()->json(myResponse::apiResponse([], "No puede generarse la asistencia si esta en otra OT."));
        }
    }

    public function asistencia()
    {
        $order = \request()->input('orden') ?? 'nombre';


        if (empty(\request("f1")) || empty(\request("f2"))) {
            $f1 = date("Y-m-d");
            $f2 = new DateTime('+1 day');
        } else {
            $f1 = \request("f1");
            $f2 = new DateTime(\request("f2"));
            $f2->modify('+1 day');

        }


        $asistencias = VOrdenTrabajoPersonal::join("marcacion", function ($join) {
            $join->on("marcacion.personal", "=", "id_personal");
            $join->on("marcacion.orden_trabajo", "=", "id_ot");
        })->whereBetween("fecha", [$f1, $f2->format('Y-m-d')])->orderBy($order)->get();

        return view('pages.reportes.asistencia')->with('data', $asistencias);
    }

    public function extras()
    {
        $personal = Personal::where('tipo', '>', '-1')->orderBy("apellidos")->get();
        return view('pages.extras.index', compact('personal'));
    }

    public function saveextras(Request $request)
    {
        $p = $request->input("personal");
        $ot = $request->input("ot");
        $fecha = $request->input("fecha");
        $totmin = $request->input("totmin");

        $marca = Marcacion::where('personal', $p)->where('orden_trabajo', $ot)->where('fechaymd', $fecha)->first();

        $marca->minutos_extra = $totmin;
        $marca->save();


        return redirect()->route('admin.marcacion.extras')
            ->with('success', "El registro de las horas extra ha sido almacenado correctamente.");


    }

    public function list(Request $request)
    {
        $personal = $request->input('personal');
        $ot = $request->input('orden_trabajo');

        $data = Marcacion::selectRaw('distinct LEFT(fecha, 10) as fecha')->where('fecha', '>', Carbon::now()->subDays(5))->where('personal', $personal)->where('orden_trabajo', $ot)->get();

        return response()->json($data);

    }

    public function tareo()
    {
//        $marcaciones = VMarcacionDia::limit(100)->get();
//        return view('pages.reportes.tareo')->with(compact('marcaciones'));
        return Excel::download(new TareoExport(), 'tareo.xlsx');

    }

    public function export()
    {
        return Excel::download(new VMarcacionExport(request("f1"), request("f2"), request("orden")), 'marcacion.xlsx');
    }

    public function export2()
    {
        return Excel::download(new VMarcacionExportView(), 'marcacion.xlsx');

    }
}
