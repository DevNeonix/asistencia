@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12 col-md-5">
            <div class="card">
                <div class="card-body">
                    <?php $ottt = 0 ?>
                    @foreach($ot as $o)
                        Nro Orden: <b>{{$o->nro_orden}}</b><br>
                        Producto: <b>{{$o->producto_fabricar}}</b><br>
                        Cliente: <b>{{$o->cliente}}</b>
                        <?php $ottt = $o->id?>
                    @endforeach
                    <br>
                    <h6>Asignados</h6>
                    <table>
                        @foreach($data as $i)
                            <tr>
                                <td>{{$i->nombre}}</td>
                                <td>
                                    <form action="{{route('admin.ots_personal.delete')}}" method="get">
                                        <input type="hidden" name="personal" value="{{$i->id_personal}}">
                                        <input type="hidden" name="ot" value="{{$ottt}}">
                                        <button class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <hr>
                    <h6>Disponibles</h6>
                    <?php
                    $disponibles = DB::select(DB::raw("SELECT * FROM personal where id not in (select id_personal from `view_orden_trabajo_personal` where id_ot=" . $ottt . ") order by apellidos"));
                    ?>
                    <table>

                        @foreach($disponibles as $i)
                            <tr>
                                <td>{{$i->apellidos}} {{$i->nombres}}</td>
                                <td>
                                    <form action="{{route('admin.ots_personal.store')}}" method="get">
                                        <input type="hidden" name="personal" value="{{$i->id}}">
                                        <input type="hidden" name="ot" value="{{$ottt}}">
                                        <button class="btn btn-success btn-sm">Agregar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection