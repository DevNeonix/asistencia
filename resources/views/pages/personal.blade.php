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
                <a class="btn btn-sm btn-primary text-white" href="{{route('admin.personal.create')}}">Nuevo</a>
            </div>
        </div>
    </div>

    <table class="table table-sm table-responsive-stack">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Doc. Identidad</th>
            <th>Tipo Usuario</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>

        @foreach($data as $i)
            <tr>
                <td>{{$i->id}}</td>
                <td>{{$i->apellidos}} {{$i->nombres}}</td>
                <td>{{$i->doc_ide}}</td>
                <td>
	 	    @if($i->tipo == -1)
			Cesado
                    @elseif($i->tipo == 0)
                        Personal
                    @elseif($i->tipo == 1)
                        Administrativo
                    @elseif($i->tipo == 2)
                        Supervisor
                    @endif

                </td>
                <td>

                    <a href="{{route('admin.personal.edit',$i->id)}}" class="btn btn-success btn-sm">Editar</a>

                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    {{$data->links()}}
@endsection
