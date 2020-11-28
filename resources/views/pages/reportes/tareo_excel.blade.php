<?php

$a = \Illuminate\Support\Carbon::createFromDate(request('f1'));
$b = \Illuminate\Support\Carbon::createFromDate(request('f2'));
$dates = [];
for ($a; $a <= $b;) {
    array_push($dates, $a->format('Y-m-d'));
    $a->addDay();
}

?>

<table class="table table-sm my-2 table-responsive" style="max-height: 50vh">
    <thead>
    <tr>
        <th>TAREADO</th>
        <th>APELLIDOS Y NOMBRES</th>
        <th>DNI</th>
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
    </tr>
    </thead>
    <tbody>

    @foreach($personal as $persona)

        @foreach($dates as $day)


            <?php
            $marcaciones = \App\Models\Marcacion::where('personal', $persona->id)->where('fechaymd', $day)->get();
            ?>
            @if($marcaciones->count() == 0)

                <tr>
                    <td colspan="30">No Asistió el día {{$day}}</td>
                </tr>

            @else
                @foreach($marcaciones as $marcacion)
                    <?php
                    $ot = $marcacion->ot;
                    $cc = $ot->centro_costo;
                    $extra = ($marcacion->minutos_extra)/60;
                    $extras25 = 0;
                    $extras35 = 0;
                    $extras100 = 0;
                    if ($extra <= 2) {
                        $extras25 = $extra;
                    } else {
                        $extras25 = 2;
                        $extras35 = $extra - $extras25;
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td>{{$persona->apellidos." ".$persona->nombre}}</td>
                        <td>{{$persona->doc_ide}}</td>
                        <td>{{$cc->codigo}}</td>
                        <td>{{$cc->detalle}}</td>
                        <td>{{$ot->ubicacion}}</td>
                        <td>{{$ot->nro_orden}}</td>
                        <td>{{$ot->producto_fabricar}}</td>
                        <td>{{$ot->cliente}}</td>
                        <td>{{$day}}</td>
                        <td>{{8/$marcaciones->count()}}</td>
                        <td>{{$extra}}</td>
                        <td>{{$extras25}}</td>
                        <td>{{$extras35}}</td>
                    </tr>
                @endforeach
            @endif


        @endforeach

    @endforeach

    </tbody>
</table>
