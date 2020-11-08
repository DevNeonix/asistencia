@extends('layouts.admin')
@section('content')
    <div class="col-12 ">
        <h5>Reporte de asistencia</b>
        </h5>
    </div>
    <form>

        <div class="form-inline row">
            <div class="form-group mx-1 col-md-3">
                <label for="f1">Fecha inicial</label>
                <input type="date" id="f1" name="f1" class="form-control txtdate" value="{{request("f1")}}">
            </div>
            <div class="form-group mx-1 col-md-3">
                <label for="f2">Fecha final</label>
                <input type="date" id="f2" name="f2" class="form-control txtdate" value="{{request("f2")}}">
            </div>
            <div class="form-group mx-1 col-md-3">
                <label for="orden">Ordenar por:</label>
                <select name="orden" id="orden" class="form-control">
                    <option value="fecha" @if(request('orden') == 'fecha') selected @endif>Fecha</option>
                    <option value="nro_orden" @if(request('orden') == 'nro_orden') selected @endif>OT</option>
                    <option value="nombre" @if(request('orden') == 'nombre') selected @endif>Nombre Personal</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm m-1">Buscar</button>
            <button class="btn btn-success btn-sm m-1" onclick="toExcel()">Excel</button>

        </div>
    </form>

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
@endsection
@section('scripts')
    <script>
        if ($(".txtdate").val() == "") {
            $(".txtdate").val(getYYYYMMDD())
        }

        function getYYYYMMDD() {
            const d = new Date()
            return new Date(d.getTime() - d.getTimezoneOffset() * 60 * 1000).toISOString().split('T')[0]
        }

        function toExcel() {
            var f1 = document.getElementById("f1").value;
            var f2 = document.getElementById("f2").value;
            var orden = document.getElementById("orden").value;

            var route = "{{route('admin.reporte.asistencia.export')}}"
            window.open(route + '?f1=' + f1 + '&f2=' + f2 + '&orden=' + orden)

        }
    </script>
@endsection
