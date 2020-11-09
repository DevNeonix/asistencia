


    @php

        $a = \Illuminate\Support\Carbon::createFromDate(request('f1'));
        $b = \Illuminate\Support\Carbon::createFromDate(request('f2'));
        $dates = [];
        for ($a;$a<=$b;){
            array_push($dates,$a->format('Y-m-d'));
            $a->addDay();
        }
    @endphp

    <table class="table my-2 table-responsive">
        <thead>
        <tr>
            <th>Personal</th>
            <th colspan="{{count($dates)*2}}">Días</th>
            <th>Remuneración</th>
            <th>Horas Extras</th>
        </tr>
        <tr>
            <td></td>
            @foreach($dates as $d)
                <td colspan="2">{{$d}}</td>
            @endforeach
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            @foreach($dates as $d)
                <td >Marcaciones</td>
                <td >Horas Extras</td>
            @endforeach
            <td></td>
            <td></td>
        </tr>
        </thead>

        <tbody>
        @foreach($data as $i)
            @php
                $sueldo = 0;
                $extras = 0;


            @endphp
            <tr>
                <td>{{$i->apellidos}}, {{$i->nombres}}</td>

                @foreach($dates as $d)
                    @php($x = \App\Models\Marcacion::where('personal',$i->id)->where('fechaymd',$d)->get())
                    <td>
                        @php($sueldodia = ($x->count() == 0)?0:$i->costo_hora * 8)
                        @php($sueldodia = ($x->count() == 0)?0:$i->costo_hora * 8)
                        @php($sueldo = $sueldo + $sueldodia)
                        {{$x->count() }}
                    </td>
                    <td>
                        @php($extra = 0)
                        @foreach($x as $j)
                            @php($extra = $extra + ($j->minutos_extra / 60))
                        @endforeach
                        @php($extras = $extras + $extra)
                        {{$extra}}
                    </td>
                @endforeach
                <td>{{round($sueldo,2)}}</td>
                <td>{{$extras}}</td>
            </tr>
        @endforeach

        </tbody>

    </table>
