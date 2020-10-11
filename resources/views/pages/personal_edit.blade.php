@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12 col-md-5">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.personal.update',$personal->id)}}" method="post">
                        <div class="form-group">
                            <label>Nombres</label>
                            <input type="text" class="form-control" name="nombres" value="{{$personal->nombres}}">
                        </div>
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" name="apellidos" value="{{$personal->apellidos}}">
                        </div>
                        <div class="form-group">
                            <label>Doc. Identidad</label>
                            <input type="text" class="form-control" name="doc_ide" value="{{$personal->doc_ide}}">
                        </div>
                        <div class="form-group d-none">
                            <label>Remuneración</label>
                            <input type="text" class="form-control" name="remuneracion"
                                   value="{{$personal->remuneracion}}">
                        </div>
                        <div class="form-group">
                            <label>Asignación Familiar</label>
                            <input type="text" class="form-control" name="asignacion_familiar"
                                   value="{{$personal->asignacion_familiar}}">
                        </div>
                        <div class="form-group">
                            <label>Tipo</label>
                            <select class="form-control" id="tipo" name="tipo" onchange="cambiaTipo()">

                                <?php
                                $roles = \Illuminate\Support\Facades\DB::table('rol_empleado')->get();
                                ?>

                                @foreach($roles as $rol)
                                    <option
                                        value="{{$rol->id}}" {{$personal->tipo == $rol->id?'selected':''}}>{{$rol->detalle}}</option>
                                @endforeach

                            </select>
                        </div>
                        {{--                        <div class="form-group">--}}
                        {{--                            <label>Tipo</label>--}}
                        {{--                            <select class="form-control" id="tipo" name="tipo" onchange="cambiaTipo()">--}}
                        {{--                                <option value="-1" {{$personal->tipo == '-1'?'selected':''}}>Cesado</option>--}}
                        {{--                                <option value="0" {{$personal->tipo == '0'?'selected':''}}>Personal</option>--}}
                        {{--                                <option value="1" {{$personal->tipo == '1'?'selected':''}}>Administrativo</option>--}}
                        {{--                                <option value="2" {{$personal->tipo == '2'?'selected':''}}>Supervisor</option>--}}
                        {{--                            </select>--}}
                        {{--                        </div>--}}
                        {{--                        <div id="supervisor-auth">--}}
                        {{--                            <div class="form-group">--}}
                        {{--                                <label>Usuario</label>--}}
                        {{--                                <input type="text" class="form-control" name="usuario" value="{{$personal->usuario}}">--}}
                        {{--                            </div>--}}
                        {{--                            <div class="form-group">--}}
                        {{--                                <label>Clave</label>--}}
                        {{--                                <input type="password" class="form-control" name="clave" value="{{$personal->clave}}">--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-7">
            @php
                $fini =request('fini');
                $ffin =request('ffin');

                if ($fini == null){
                    $fini=date('Y-m-01');
                }
                if ($ffin == null){
                    $ffin=date('Y-m-t');
                }

                $today = \Carbon\Carbon::make($fini);
                $dates = [];


                for($i=0; $i <= Carbon\Carbon::make($ffin)->diffInDays($today); ++$i) {

                    $dates[] = \Carbon\Carbon::make($today)->addDays($i)->format('y-m-d');
                }



            @endphp

            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="row py-2">

                            <div class="col-4">
                                <div class="form-inline">
                                    <label>Fecha Inicial &nbsp;
                                        <input type="date" name="fini" class="form-control" value="{{$fini}}"> </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-inline">
                                    <label>Fecha Final &nbsp;
                                        <input type="date" name="ffin" class="form-control" value="{{$ffin}}"> </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-success" type="submit">Buscar</button>
                            </div>

                        </div>
                    </form>
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Ot</th>
                            <th>H. trabajadas</th>
                            <th>H. extras</th>
                        </tr>
                        </thead>
                        <tbody>

                        @php
                            $horasTrabajadas = 0;
                            $faltaRemunerada = 0;
                            $faltadescontada = 0;
                        @endphp
                        @foreach($dates as $f)

                            @php
                                $marcas = \App\Models\ViewMarcacionPersonal::where('id_personal',$personal->id)->where('fechaymd','=',$f)->get()
                            @endphp
                            @if(count($marcas) >=1)
                                @foreach($marcas as $marca)
                                    <tr>
                                        <td>
                                            {{$marca->fechaymd}}
                                        </td>
                                        <td>
                                            {{$marca->nro_orden}} {{$marca->cliente}} {{$marca->producto_fabricar}}
                                        </td>
                                        @php
                                            $nroMarcasPordia = \App\Models\Marcacion::where('personal',$marca->id_personal)
                                                                        ->where('fechaymd',$marca->fechaymd)
                                                                        ->distinct()
                                                                        ->get('orden_trabajo','fechaymd')
                                                                        ->count();

                                        @endphp
                                        <td>{{round(8/$nroMarcasPordia,2)}}</td>
                                        @php
                                            $horasTrabajadas = $horasTrabajadas + round(8/$nroMarcasPordia,2);
                                        @endphp
                                        <td>
                                            {{ round($marca->minutos_extras/60,2)}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>{{$f}}</td>
                                    @php
                                        $falta = \App\Models\Falta::where('fecha',$f)->where('personal',$personal->id)->first()
                                    @endphp
                                    @if($falta == null)
                                        <td class="text-danger" colspan="3">

                                            Marcación no registrada
                                            @php
                                                $nomdia = \Illuminate\Support\Str::upper(\Illuminate\Support\Carbon::make($f )->locale('es_ES')->dayName);
                                            @endphp
                                            {{$nomdia}}
                                        </td>
                                        <td>
                                            @php
                                                if($nomdia == "DOMINGO"){
                                                    $horasTrabajadas=$horasTrabajadas+8;
                                                    echo "8";
                                                }else{
                                                    $faltadescontada = $faltadescontada +1;
                                                }

                                            @endphp

                                        </td>
                                    @else
                                        <td class="text-danger font-weight-bold text-uppercase">
                                            @php
                                                $dsfalta = "";
                                                switch ($falta->falta){
                                                    case 1:
                                                        $dsfalta='vacaciones';
                                                        $faltaRemunerada = $faltaRemunerada +8;
                                                        break;
                                                    case 2:
                                                        $dsfalta='Permiso';
                                                        $faltadescontada = $faltadescontada +1;
                                                        break;
                                                    case 3:
                                                        $dsfalta='Falta injustificada';
                                                        $faltadescontada = $faltadescontada +1;
                                                        break;
                                                    case 4:
                                                        $dsfalta='Licencia médica';
                                                        $faltadescontada = $faltadescontada +1;
                                                        break;
                                                    default:
                                                        $dsfalta='NA';
                                                        $faltadescontada = $faltadescontada +1;
                                                        break;
                                                }
                                            @endphp
                                            {{$dsfalta}}
                                        </td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach

                        <tr class="bg-dark text-white">
                            <td colspan="2">Horas Trabajadas</td>
                            <td>{{$horasTrabajadas }}</td>
                            <td>{{round(($horasTrabajadas)*$personal->costo_hora,2)}}</td>
                        </tr>
                        <tr class="bg-dark text-white">
                            <td colspan="2">Permisos Remunerados</td>
                            <td>{{$faltaRemunerada }}</td>
                            <td>S/. {{round(($faltaRemunerada)*$personal->costo_hora,2)}}</td>
                        </tr>
                        <tr class="bg-dark text-white">
                            <td colspan="2">Faltas</td>
                            <td>{{$faltadescontada }} días</td>
                            <td>S/. {{round(($faltadescontada*8)*$personal->costo_hora,2)}}</td>
                        </tr>
                        <tr>
                            <td colspan="10">
                                <hr></td>
                        </tr>
                        <tr class="bg-dark text-white">
                            <td colspan="2">Resumen de Pago</td>
                            <td>{{$horasTrabajadas + $faltaRemunerada}}</td>
                            <td>S/. {{round(($horasTrabajadas + $faltaRemunerada)*$personal->costo_hora,2)}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function cambiaTipo() {
            var tipo = $("#tipo").val();
            if (parseInt(tipo) == 0 || parseInt(tipo) == -1) {
                $("#supervisor-auth").css("display", "none")
            } else {
                $("#supervisor-auth").css("display", "block")
            }
        }

        cambiaTipo();
    </script>
@endsection
