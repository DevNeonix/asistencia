<?php

$a = \Illuminate\Support\Carbon::createFromDate(request('f1'));
$b = \Illuminate\Support\Carbon::createFromDate(request('f2'));
$dates = [];
for ($a; $a <= $b;) {
    array_push($dates, $a->format('Y-m-d'));
    $a->addDay();
}

?>

<table class="table table-sm my-2 table-responsive">
    <thead>
    <tr>
        <th>TAREADO</th>
        <th>APELLIDOS Y NOMBRES</th>
        <th>DNI</th>
        <th>TIPO DE EMPLEADO</th>
        <th>CC</th>
        <th>CENTRO DE COSTO</th>
        <th>UBICACION</th>
        <th>OT</th>
        <th>DESCRIPCION</th>
        <th>CLIENTE</th>
        <th>FECHA</th>
        <th>HORAS NORMALES</th>
        <th>HORAS EXTRAS</th>
        <th>HORAS EXTRAS 25%</th>
        <th>HORAS EXTRAS 35%</th>
        <th>HORAS EXTRAS 100%</th>
        <th>Viaticos</th>
    </tr>
    </thead>
    <tbody>

    @foreach($personal as $persona)

        @foreach($dates as $day)


            <?php
            $marcaciones = \App\Models\Marcacion::where('personal', $persona->id)->where('fechaymd', $day)->get();
            ?>
            @php($diaes = \App\Util\CommonUtils::getNombreDia(\Carbon\Carbon::make($day)->format('l')))
            @if($marcaciones->count() == 0)

                <tr>
                    <td colspan="30">{{$persona->apellidos}} {{$persona->nombres}} No Asistió el día {{$day}}
                        ({{$diaes}})
			&nbsp;
			<?php
				$faltasregistradas = App\Models\Falta::where('personal',$persona->id)->where('fecha',$day)->get()
			?>
			<span class="text-danger">
			@foreach($faltasregistradas as $ff)
			<?php
				switch($ff->falta){
					case 1:
						echo "Vacaciones.";
					break;
					case 2:
						echo "Permiso.";
					break;
					case 3:
						echo "Falta injustificada.";
					break;
					case 4:
						echo "Licencia médic.";
					break;
				}
			?>
			@endforeach
			</span>
                    </td>
                </tr>

            @else
                @foreach($marcaciones as $marcacion)
                    <?php
                    $ot = $marcacion->ot;
                    $cc = $ot->centro_costo;
                    $extra = ($marcacion->minutos_extra) / 60;
                    $extras25 = 0;
                    $extras35 = 0;
                    $extras100 = 0;
                    $horas = round(8 / $marcaciones->count(), 2);
                    if ($diaes == "domingo") {
                        if ($extra == 0) {
                            $extras100 = 16;
                        } else {
                            $extras100 = $extra * 2;
                        }

                        $horas = 0;
                    } else {

                        if ($extra <= 2) {
                            $extras25 = $extra;
                        } else {
                            $extras25 = 2;
                            $extras35 = $extra - $extras25;
                        }
                    }

                    ?>
                    <tr class="{{$diaes == "domingo"?'text-danger':''}}">
                        <td>{{App\Models\User::find($marcacion->usuario_registra)->name}}</td>
                        <td>{{$persona->apellidos." ".$persona->nombres}}</td>
                        <td>{{$persona->doc_ide}}</td>
                        <td>{{\App\Models\RolEmpleado::find($persona->tipo)->detalle}}</td>
                        <td>{{($cc!=null)?$cc->codigo:''}}</td>
                        <td>{{($cc!=null)?$cc->detalle:''}}</td>
                        <td>{{$ot->ubicacion}}</td>
                        <td>{{$ot->nro_orden}}</td>
                        <td>{{$ot->producto_fabricar}}</td>
                        <td>{{$ot->cliente}}</td>
                        <td>{{$day}} ({{$diaes}})</td>
                        <td>{{$horas}}</td>
                        <td>{{$extra}}</td>
                        <td>{{$extras25}}</td>
                        <td>{{$extras35}}</td>
                        <td>{{$extras100}}</td>
                        <td>{{$marcacion->viatico}}</td>
                    </tr>
                @endforeach
            @endif


        @endforeach

    @endforeach

    </tbody>
</table>
