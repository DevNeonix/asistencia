@extends('layouts.admin')
@section('content')
    <h1 class="h4">Listado de Asistencias</h1>
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
    <table class="table table-sm table-hover" style="font-size: 10px">
        <tr>
            <th>Nombre</th>
            <th>DNI</th>
            <th>OT</th>
            <th>Descripcion</th>
            <th>Fecha</th>
            <th>Asistencias Ingresadas por día</th>
            <th colspan="11">Asistencias</th>
            <th>Resumen en Minutos</th>
            <th>Resumen en Horas</th>
        </tr>
        @foreach($data as $item)
            <tr>
                <td>{{$item->nombre}}</td>
                <td>{{$item->doc_ide}}</td>
                <td>{{$item->nro_orden}}</td>
                <td>{{$item->producto_fabricar}}</td>
                <td>{{substr(\Illuminate\Support\Carbon::make($item->ano.'-'.$item->mes.'-'.$item->dia),0,10)}}</td>
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
                    <td>
                        <p style="font-size: 10px" class="p-0 m-0">{{$asistencia->fecha}}</p>
                        <?php
                        $responsable = \App\Models\User::where('id', $asistencia->usuario_registra)->first();
                        ?>
                        @if($responsable != null)
                            <p style="font-size: 10px" class="p-0 m-0 text-muted">{{$responsable->name}}</p>
                        @endif
                    </td>
                    <?php
                    $cnt = $cnt + 1;
                    ?>
                @endforeach

                @if($item->cantidad_marcaciones%2 ==1)
                    <td><input type="datetime-local" min="{{substr(\Illuminate\Support\Carbon::make($item->ano.'-'.$item->mes.'-'.$item->dia),0,10)}}T00:00" value="{{$item->ano}}-{{substr("00".$item->mes,-2)}}-{{$item->dia}}T00:00"></td>
                    <td></td>
                @endif

                @for($cnt=$cnt;$cnt<=11;$cnt++)
                    <td></td>
                @endfor
                @if($item->cantidad_marcaciones % 2 == 0)
                    @for($x=0;$x<$item->cantidad_marcaciones/2;$x++)
                        <td>{{\Illuminate\Support\Carbon::parse($asistencias[$x]->fecha)->diffInMinutes($asistencias[$x+1]->fecha)}}</td>
{{--                        <td>{{round(\Illuminate\Support\Carbon::parse($asistencias[$x]->fecha)->floatDiffInHours($asistencias[$x+1]->fecha),2)}}</td>--}}
                        <?php
                        $x++
                        ?>
                    @endfor
                @endif
            </tr>
        @endforeach
    </table>
@endsection
