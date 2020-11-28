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
                    <option value="nombre" @if(request('orden') == 'apellidos') selected @endif>Nombre Personal</option>
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

    <table class="table my-2 table-responsive" style="max-height: 50vh">
        <thead>
        <tr>
            <th colspan="2">Personal</th>
            <th colspan="{{count($dates)}}">Días</th>
            <th>Horas Trabajadas</th>
            <th colspan="3">Horas Extras</th>
        </tr>
        <tr>
            <td colspan="2"></td>
            @foreach($dates as $d)
                <td>{{$d}}</td>
            @endforeach
            <td></td>
            <td>Tot extras</td>
            <td>25%</td>
            <td>35%</td>
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

                    <td>

                        @if(count($f)> 0)

                            <p>Se ha reportado la falta: </p>
                            <ul>
                                @foreach($f as $ff)
                                    <li class="text-danger">{{$ff->orden_trabajo->nro_orden."-".$ff->orden_trabajo->cliente."-".$ff->orden_trabajo->producto_fabricar}}</li>
                                @endforeach
                            </ul>

                        @else

                        @php($trabajadas = ($x->count() == 0)?$trabajadas:$trabajadas+8)
                        @php($sueldodia = ($x->count() == 0)?0:$i->costo_hora * 8)
                        @php($sueldodia = ($x->count() == 0)?0:$i->costo_hora * 8)
                        <strong>{{($x->count() == 0)?0:8 }}</strong> horas trabajadas
                        <br>
                        @php($extra = 0)
                        @foreach($x as $j)
                            @php($extra = $extra + ($j->minutos_extra / 60))
                        @endforeach
                        @php($extras = $extras + $extra)
                        <strong>{{$extra}}</strong> horas extra
                        <br>
                        <strong>{{$x->count()}}</strong> Ot(s) asistida(s)
			<br>
			@foreach($x as $o)
				{{$o->ot->nro_orden}} {{$o->ot->producto_fabricar}}<br>
			@endforeach

                        <?php
                        if ($extra <= 2) {
                            $extras25 = $extras25 + $extra;
                        } else {
                            $extras25 = $extras25 + 2;
                            $extras35 = $extras35 + ($extra - 2);
                        }

                        ?>
                        @endif

                    </td>
                @endforeach
                <td>{{$trabajadas}}</td>
                <td>{{$extras}}</td>
                <td>{{$extras25}}</td>
                <td>{{$extras35}}</td>


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
