@extends('layouts.admin')
@section('content')
    <h1 class="h4">Listado de personal</h1>
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
            <div class="form-group">
                <a class="btn btn-sm btn-primary text-white" href="{{route('admin.user.create')}}">Nuevo</a>
            </div>
        </div>
    </div>

    <table class="table table-sm table-responsive-stack">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>

        @foreach($data as $i)
            <tr class="{{$i->estado==0?'text-muted':''}}">
                <td>{{$i->id}}</td>
                <td>{{$i->name}}</td>
                <td>{{$i->email}}</td>
                <td>
                    <?php
                    $roles = DB::table('rol_empleado')->where('id', $i->tipo)->get();
                    ?>

                    @foreach($roles as $rol)
                        {{$rol->detalle}}
                    @endforeach

                </td>
                <td>
                    {{$i->estado == 1?'Activo':'Eliminado'}}
                </td>
                <td>

                    <a href="{{route('admin.user.edit',$i->id)}}" class="btn btn-success btn-sm">Editar</a>

                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    {{$data->links()}}
@endsection
