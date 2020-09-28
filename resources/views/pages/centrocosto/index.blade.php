@extends('layouts.admin')
@section('content')
    <h1 class="h4">Listado de Órdenes de trabajo</h1>
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
        <div class="col-12">
            <a href="{{route('admin.cc.create')}}" class="m-2 btn btn-primary btn-sm">Nuevo</a>
        </div>
    </div>
    <table class="table table-sm table-responsive-stack">
        <thead>
        <tr class="row">
            <th class="col-md-1">Id</th>
            <th class="col-md-2">Codigo</th>
            <th class="col-md-3" style="width: 150px">Detalle</th>
            <th class="col-md-3">Ubicacion</th>
            <th class="col-md-3">Acciones</th>

        </tr>
        </thead>
        <tbody>

        @foreach($data as $i)
            <tr class="row">
                <td class="col-md-1">{{$i->id}}</td>
                <td class="col-md-2">{{$i->codigo}}</td>
                <td class="col-md-3">{{$i->detalle}}</td>
                <td class="col-md-3">{{$i->ubicacion}}</td>

                <td class="col-md-3">

                    <a href="{{route('admin.cc.edit',$i->id)}}" class="btn btn-success btn-sm">Editar</a>

                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    {{$data->links()}}
@endsection
@section('scripts')
    <script>
        // $("table").addClass('the-table');

    </script>
@endsection
