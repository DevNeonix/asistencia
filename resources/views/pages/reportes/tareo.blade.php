@extends('layouts.admin')
@section('content')
    <h1 class="h4">Tareo</h1>
    <form>

        <div class="form-inline">
            <div class="form-group mx-1">
                <input type="date" id="f1" name="fechaini" class="form-control txtdate" value="{{request("fechaini")}}">
            </div>
            <div class="form-group mx-1">
                <input type="date" id="f2" name="fechafin" class="form-control txtdate" value="{{request("fechafin")}}">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Buscar</button>
        </div>
    </form>
    <a href="{{route('admin.reporte.asistenciadia.export')}}" class="btn btn-primary btn-sm m-0 p-0">Exportar</a>
    <table class="table table-sm table-responsive" style="font-size: 10px;max-height: 500px">
        <tr>
            <th>Tareado Por</th>
            <th>Apellidos y nombres</th>
            <th>DNI</th>
            <th>CC</th>
            <th>Centro de Costo</th>
            <th>Ubicación</th>
            <th>OT</th>
            <th>Descripción</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Horas Normales</th>
            <th>Licencia Goce de Haber</th>
            <th>Licencia sin Goce de Haber</th>
            <th>Horas Extras</th>
            <th>Hrs 25%</th>
            <th>Hrs 35%</th>
            <th>Domingos/Feriados</th>
            <th>Faltas</th>
            <th>Vacaciones</th>
            <th>Dias de Descanzo medico</th>
            <th>Permiso</th>
            <th>Viatico</th>
            <th>Observación</th>
        </tr>
        @php
            $today = today();
            $dates = [];

            for($i=1; $i < $today->daysInMonth + 1; ++$i) {
                $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('y-m-d');
            }
        @endphp
        @foreach($dates as $date)
            @php
                $marcas = \App\Models\VMarcacionDia::where('fechaymd',$date)->orderBy('nombre')->get()

            @endphp
            @if($marcas->count()>0)
                @foreach($marcas as $marca)

                    <tr>
                        <td>{{$marca->tareadopor}}</td>
                        <td>{{$marca->nombre}}</td>
                        <td>{{$marca->doc_ide}}</td>
                        @php
                            $cc = \App\Models\CentroCosto::find($marca->centro_costo_id);
                            $ot = \App\Models\OrdenTrabajo::find($marca->id_ot)
                        @endphp
                        <td>{{$cc->codigo??null}}</td>
                        <td>{{$cc->detalle??null}}</td>
                        <td>{{$marca->ot_ubicacion??null}}</td>

                        <td>{{$marca->nro_orden}}</td>
                        <td>{{$marca->producto_fabricar}}</td>
                        <td>{{$marca->cliente}}</td>
                        <td>{{$date}}</td>
                        {{--CALCULO HORAS NORMALES--}}
                        {{--NRO DE OTS TRABAJADAS POR DIA / 8--}}
                        @php
                            $nroMarcasPordia = \App\Models\Marcacion::where('orden_trabajo',$marca->id_ot)->where('personal',$marca->id_personal)->where('fechaymd',$marca->fechaymd)->distinct()->get('orden_trabajo','fechaymd')->count();
                        @endphp
                        <td>{{8/$nroMarcasPordia}}</td>
                        {{--                    @php--}}

                        {{--                        /*--}}
                        {{--                            LICENCIAS--}}
                        {{--                            <option value="1">Vacaciones</option>--}}
                        {{--                            <option value="2">Permiso</option>--}}
                        {{--                            <option value="3">Falta injustificada</option>--}}
                        {{--                            <option value="4">Licencia médica</option>--}}
                        {{--                        */--}}
                        {{--                        $faltas = \App\Models\Falta::where('ot',$marca->id_ot)->where('personal',$marca->id_personal)->where('fecha',$marca->fechaymd)->get();--}}
                        {{--                        $licencia="";--}}
                        {{--                        $sinlicencia="";--}}
                        {{--                        foreach($faltas as $falta){--}}
                        {{--                            switch ($falta->falta){--}}
                        {{--                                case 1:--}}
                        {{--                                    $licencia = "*";--}}
                        {{--                                    break;--}}
                        {{--                                case 2:--}}
                        {{--                                    $licencia = "*";--}}
                        {{--                                    break;--}}
                        {{--                                case 3:--}}
                        {{--                                    $sinlicencia = "*";--}}
                        {{--                                    break;--}}
                        {{--                                case 4:--}}
                        {{--                                    $licencia = "*";--}}
                        {{--                                    break;--}}
                        {{--                            }--}}
                        {{--                        }--}}

                        {{--                    @endphp--}}

                        <td></td>
                        <td></td>
                        @php
                            $hextra= round($marca->minutos_extras/60,2);
                            if ($hextra < 2){
                                $hextra25= $hextra;
                                $hextra35= 0;
                            }
                            if ($hextra >= 2){
                                $hextra25= 2;
                                $hextra35= $hextra-2;
                            }


                        @endphp
                        <td>{{$hextra}}</td>
                        <td>{{$hextra25}}</td>
                        <td>{{$hextra35}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{$ot->viatico}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        {{--                    <td>{{8/$nroMarcasPordia}}</td>--}}
                    </tr>
                @endforeach
            @else

                <tr style="background-color: #66ff00;">
                    <td colspan="9" style="text-align: center">
                        <h5>{{\Illuminate\Support\Str::upper(\Illuminate\Support\Carbon::make($date)->locale('es_ES')->dayName)}}</h5>
                    </td>
                    <td>{{$date}}</td>
                    <td></td>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
        @endforeach

    </table>
@endsection
