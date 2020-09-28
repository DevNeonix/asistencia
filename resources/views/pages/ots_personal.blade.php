@extends('layouts.admin')
@section('content')
    <h1 class="h4">Listado de personal por OT'S</h1>
    <div class="col-12 col-md-4">
        <form>
            <div class="form-group form-inline">
                <input type="text" class="form-control form-control-sm" placeholder="Buscar" name="buscar"
                       value="{{request('buscar')}}">
                <button type="submit" class="btn btn-primary btn-sm mx-1">Buscar</button>
            </div>
        </form>
    </div>
    <table class="table table-sm table-responsive-stack">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nro Orden</th>
            <th>Producto</th>
            <th>Cliente</th>
            <th>Estado</th>
        </tr>
        </thead>
        <tbody>

        @foreach($data as $i)
            <tr>
                <td>{{$i->id}}</td>
                <td>{{$i->nro_orden}}</td>
                <td>{{$i->producto_fabricar}}</td>
                <td>{{$i->cliente}}</td>
                <td>{{$i->estado == 1 ? 'Activo':'Finalizado'}}</td>
                <td>
                    <a class="btn btn-sm btn-success" href="{{route('admin.ots_personal.edit',$i->id)}}">Editar
                        Personal</a>
                </td>
            </tr>
            <tr style="border-top: none">
                <td style="border-top: none">
                    <b>Personal: </b>
                    <ul>
                        <?php
                        $personal = \Illuminate\Support\Facades\DB::table('view_orden_trabajo_personal')->where('id_ot', $i->id)->orderBy('nombre')->get();
                        ?>

                        @foreach($personal as $p)
                            <li>{{$p->nombre}}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    {{$data->links()}}
@endsection