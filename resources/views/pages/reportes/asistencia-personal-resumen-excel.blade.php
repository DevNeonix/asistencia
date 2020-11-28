@php

    $a = \Illuminate\Support\Carbon::createFromDate(request('f1'));
    $b = \Illuminate\Support\Carbon::createFromDate(request('f2'));
    $dates = [];
    for ($a;$a<=$b;){
        array_push($dates,$a->format('Y-m-d'));
        $a->addDay();
    }
@endphp

<table class="table my-2 table-responsive" style="max-height: 50vh">
    <thead>
    <tr>
        <th colspan="2">Personal</th>
        <th>Horas Trabajadas</th>
        <td></td>
        <th colspan="3">Horas Extras</th>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>Días trabajados</td>
        <td>Tot horas trabajadas</td>
        <td>Tot extras</td>
        <td>25%</td>
        <td>35%</td>
        <td colspan="30" class="text-center">Ots</td>
    </tr>
    </thead>

    <tbody>
    @foreach($data as $i)
        @php
            $extras = 0;
            $extras25 = 0;
            $extras35 = 0;
            $extras100 = 0;
            $trabajadas = 0;

        @endphp
        <tr>
            <td>{{$i->doc_ide}}</td>
            <td>{{$i->id}} <a href="{{route('admin.personal.edit',$i->id)}}">{{$i->apellidos}}, {{$i->nombres}}</a>
            </td>

            @foreach($dates as $d)
                @php($x = \App\Models\Marcacion::where('personal',$i->id)->where('fechaymd',$d)->get())
                @php($f = \App\Models\Falta::where('personal',$i->id)->where('fecha',$d)->get())
                @php($trabajadas = ($x->count() == 0)?$trabajadas:$trabajadas+8)
                @php($sueldodia = ($x->count() == 0)?0:$i->costo_hora * 8)
                @php($sueldodia = ($x->count() == 0)?0:$i->costo_hora * 8)
                @php($extra = 0)
                @foreach($x as $j)
                    @php($extra = $extra + ($j->minutos_extra / 60))
                @endforeach
                @php($extras = $extras + $extra)
                <?php
                if ($extra <= 2) {
                    $extras25 = $extras25 + $extra;
                } else {
                    $extras25 = $extras25 + 2;
                    $extras35 = $extras35 + ($extra - 2);
                }
                ?>
            @endforeach

            <td>{{$trabajadas/8}}</td>
            <td>{{$trabajadas}}</td>
            <td>{{$extras}}</td>
            <td>{{$extras25}}</td>
            <td>{{$extras35}}</td>
            @php($ots=\Illuminate\Support\Facades\DB::select(\Illuminate\Support\Facades\DB::raw("SELECT personal,orden_trabajo,count(*) FROM marcacion where personal=".$i->id." and fecha between '".\Illuminate\Support\Carbon::createFromDate(request('f1'))."' and '".\Illuminate\Support\Carbon::createFromDate(request('f2'))."' group by personal,orden_trabajo")))
            @foreach($ots as $ot)
                <td>
                    @php($o=\App\Models\OrdenTrabajo::find($ot->orden_trabajo))
                    {{$o->nro_orden}}-{{$o->producto_fabricar}}-{{$o->cliente}}
                </td>

            @endforeach


        </tr>
    @endforeach

    </tbody>

</table>
