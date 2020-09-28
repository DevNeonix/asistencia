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


        <table class="table my-2">
            <thead>
            <tr>
                <th>Personal</th>
                <th>OT</th>
                <th>Fecha</th>
            </tr>
            </thead>

            <tbody>
            @foreach($data as $i)
                <tr>
                    <td>{{$i->nombre}}</td>
                    <td>{!! $i->cliente." <br> ".$i->producto_fabricar!!}</td>
                    <td>{{$i->fecha}}</td>
                </tr>
            @endforeach

            </tbody>

        </table>
@endsection
@section('scripts')
    <script>
        if ($(".txtdate").val() == "") {
            $(".txtdate").val(new Date().toISOString().substr(0, 10))
        }

        function toExcel() {
            var f1 = document.getElementById("f1").value;
            var f2 = document.getElementById("f2").value;
            var orden = document.getElementById("orden").value;

            var route = "{{route('admin.reporte.asistencia.export')}}"
            window.open(route + '?f1=' + f1 + '&f2=' + f2+'&orden='+orden)

        }
    </script>
@endsection