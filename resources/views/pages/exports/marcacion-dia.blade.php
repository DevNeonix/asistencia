<h1 class="h4">Listado de Asistencias</h1>
<table class="table table-sm table-hover" style="font-size: 10px">
    <tr>
        <th>Nombre</th>
        <th>DNI</th>
        <th>OT</th>
        <th>Descripcion</th>
        <th>Fecha</th>
        <th># Asistencias</th>
        <th colspan="11">Asistencias</th>
        <th>Resumen en Minutos</th>
        <th>Resumen en Horas</th>
    </tr>
    @foreach($data as $item)
        <tr>
            <td width="50">{{$item->nombre}}</td>
            <td width="20">&nbsp;{{$item->doc_ide}}</td>
            <td width="20">&nbsp;{{$item->nro_orden}}</td>
            <td width="50">{{$item->producto_fabricar}}</td>
            <td width="20">{{substr(\Illuminate\Support\Carbon::make($item->ano.'-'.$item->mes.'-'.$item->dia),0,10)}}</td>
            <td class="text-right">{{$item->cantidad_marcaciones}}</td>

            <?php
            $asistencias = \App\Models\Marcacion::where('personal', $item->id_personal)
                ->where('orden_trabajo', $item->id_ot)
                ->whereYear('fecha', $item->ano)
                ->whereMonth('fecha', $item->mes)
                ->whereDay('fecha', $item->dia)
                ->get();
            $cnt = 1;
            ?>

            @foreach($asistencias as $asistencia)
                <td width="40">
                    <p style="font-size: 10px" class="p-0 m-0">{{$asistencia->fecha}}</p>
                    <?php
                    $responsable = \App\Models\User::where('id', $asistencia->usuario_registra)->first();
                    ?>
                    @if($responsable != null)
                        <p style="font-size: 10px" class="p-0 m-0 text-muted">&nbsp;{{$responsable->name}}</p>
                    @endif
                </td>
                <?php
                $cnt = $cnt + 1;
                ?>
            @endforeach

            @if($item->cantidad_marcaciones%2 ==1)
                <td width="40" style="background-color: #ff6347">NO REGISTRADA</td>
                <td></td>
            @endif

            @for($cnt=$cnt;$cnt<=11;$cnt++)
                <td></td>
            @endfor
            @if($item->cantidad_marcaciones % 2 == 0)
                @for($x=0;$x<$item->cantidad_marcaciones/2;$x++)
                    <?php
                    $min = \Illuminate\Support\Carbon::parse($asistencias[$x]->fecha)->diffInMinutes($asistencias[$x + 1]->fecha);
                    ?>
                    <td>{{$min}}</td>
                    <td>{{round($min/60,2)}}</td>

                    <?php
                    $x++
                    ?>
                @endfor
            @endif
        </tr>
    @endforeach
</table>
