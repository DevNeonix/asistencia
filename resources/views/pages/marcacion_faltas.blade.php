@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12 ">
            <h5>Marcacion para el Producto <b>{{$ot->producto_fabricar}}</b> del cliente <b>{{$ot->cliente}}</b>
            </h5>
        </div>

        <?php

        $empleados = DB::table('view_orden_trabajo_personal')->where('id_ot', $ot->id)->get();

        ?>
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>Nombre</th>
            </tr>
            </thead>
            <tbody>
            @foreach($empleados as $i)

                <tr>

                    <?php
                    $k = 0
                    ?>
                    <td>
                        {{$i->nombre}}
                        <?php
                        $x = DB::select(DB::raw("select * from marcacion where orden_trabajo='" . $ot->id . "' and personal = " . $i->id_personal . " and year(fecha)=year(now()) and month(fecha)=month(now()) and day(fecha)=day(now()) "));
                        ?>
                        @foreach($x as $j)
                            <p class="text-muted text-italic">

                                <?php
                                $k = $k + 1;
                                ?>
                                <b>{{$k%2==0?"Salió":'Ingresó' }}</b>: {{\Carbon\Carbon::parse($j->fecha)->diffForHumans(\Carbon\Carbon::now())}}

                            </p>
                        @endforeach
                        @if($k==0)
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-block">
                                        <form action="{{route('admin.marcacion.faltas.registro')}}" type="post">

                                            <div class="form-group">
                                                <label>Desde</label>
                                                <input type="date" class="form-control form-control-sm mydate"
                                                       name="desde"
                                                       value="{{date('y')."-".date('m').'-'.date('d')}}">
                                            </div>
                                            <div class="form-group">
                                                <label>Hasta</label>
                                                <input type="date" class="form-control form-control-sm mydate"
                                                       name="hasta"
                                                       value="{{date('y')."-".date('m').'-'.date('d')}}">
                                            </div>

                                            <div class="form-group">
                                                <label>Motivo</label>
                                                <input type="hidden" name="personal" value="{{$i->id_personal}}">
                                                <input type="hidden" name="ot" value="{{$i->id_ot}}">

                                                <select name="falta" class="form-control">
                                                    <option value="1">Vacaciones</option>
                                                    <option value="2">Permiso</option>
                                                    <option value="3">Falta injustificada</option>
                                                    <option value="4">Licencia médica</option>

                                                </select>
                                            </div>
                                            <button class="btn btn-danger btn-sm" type="submit">Registrar Falta
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-muted text-italic">No se puede registrar una falta si ya ha ingresado.</p>
                        @endif
                    </td>

                </tr>

            @endforeach
            </tbody>
        </table>
    </div>

@endsection
@section('scripts')
    <script>
        var now = new Date();
        var month = (now.getMonth() + 1);
        var day = now.getDate();
        if (month < 10)
            month = "0" + month;
        if (day < 10)
            day = "0" + day;
        var today = now.getFullYear() + '-' + month + '-' + day;
        $('.mydate').val(today);
        $('.mydate').prop("min", today);
    </script>
@endsection