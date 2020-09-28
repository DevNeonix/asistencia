@extends('layouts.admin')
@section('content')
    <h1 class="h4">Edicion de Centro de costo</h1>
    <div class="row">
        <div class="col-12 col-md-5">
            <form action="{{route('admin.cc.update',$centroCosto->id)}}" method="post">
                @method('put')
                <input type="hidden" class="form-control" name="id" value="{{$centroCosto->id}}">
                <div class="form-group">
                    <label>Codigo</label>
                    <input type="text" class="form-control" name="codigo" value="{{$centroCosto->codigo}}">
                </div>
                <div class="form-group">
                    <label>Detalle</label>
                    <input type="text" class="form-control" name="detalle" value="{{$centroCosto->detalle}}">
                </div>
                <div class="form-group">
                    <label>Area</label>
                    <input type="text" class="form-control" name="area" value="{{$centroCosto->area}}">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Editar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        // $("table").addClass('the-table');

    </script>
@endsection
