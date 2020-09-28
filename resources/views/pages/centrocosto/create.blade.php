@extends('layouts.admin')
@section('content')
    <h1 class="h4">Creación de Centro de costo</h1>
    <div class="row">
        <div class="col-12 col-md-5">
            <form action="{{route('admin.cc.store')}}" method="POST">

                <div class="form-group">
                    <label>Codigo</label>
                    <input type="text" class="form-control" name="codigo">
                </div>
                <div class="form-group">
                    <label>Detalle</label>
                    <input type="text" class="form-control" name="detalle">
                </div>
                <div class="form-group">
                    <label>Area</label>
                    <input type="text" class="form-control" name="area">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Registrar</button>
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
