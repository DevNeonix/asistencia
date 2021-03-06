@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12 col-md-5">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.ots.store')}}" method="post" >
                        <div class="form-group">
                            <label>Nro Orden</label>
                            <input type="text" class="form-control" name="nro_orden" value="{{old('nro_orden')}}">
                        </div>
                        <div class="form-group">
                            <label>Producto a Fabricar</label>
                            <input type="text" class="form-control" name="producto_fabricar" value="{{old('producto_fabricar')}}">
                        </div>
                        <div class="form-group">
                            <label>Cliente</label>
                            <input type="text" class="form-control" name="cliente" value="{{old('cliente')}}">
                        </div>
                        <div class="form-group">
                            <label>Centro de Costo</label>
                            <select name="centro_costo_id" id="centro_costo_id" class="form-control">
                                <option ></option>
                                @php
                                    $centroCostos = \App\Models\CentroCosto::all();
                                @endphp
                                @foreach($centroCostos as $costo)
                                    <option value="{{$costo->id}}" >{{$costo->codigo."-".$costo->detalle}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ubicacion</label>
                            <input type="text" class="form-control" name="ubicacion" value="{{old('ubicacion','')}}">
                        </div>
                        <div class="form-group">
                            <label>Viático S/.</label>
                            <input type="text" class="form-control" name="viatico" value="{{old('viatico',0)}}">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection
