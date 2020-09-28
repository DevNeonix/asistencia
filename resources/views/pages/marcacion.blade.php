@extends('layouts.admin')
@section('content')
    <h1 class="h4">Listado de Órdenes de trabajo para Marcación</h1>
    <div class="row">
        <div class="col-12 col-md-4">
            <form>
                <div class="form-group form-inline">
                    <input type="text" class="form-control form-control-sm" placeholder="Buscar" name="buscar"
                           value="{{request('buscar')}}">
                    <button type="submit" class="btn btn-primary btn-sm mx-1">Buscar</button>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-sm table-responsive-stack">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nro Orden</th>
            <th>Producto</th>
            <th>Cliente</th>
            <th>Estado</th>
            <th>Acciones</th>
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
                <td class="">

                    <a href="{{route('admin.marcacion.registro',$i->id)}}" class="btn btn-success btn-sm m-2">Registrar
                        Marcas</a>

                    <a class="btn btn-sm btn-danger text-white m-2" href="{{route('admin.marcacion.faltas',$i->id)}}">Registrar
                        Faltas</a>

                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    {{$data->links()}}
@endsection