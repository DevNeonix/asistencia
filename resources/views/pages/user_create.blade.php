@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12 col-md-5">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.user.store')}}" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{old('name')}}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" value="{{old('email')}}">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" value="{{old('password')}}">
                        </div>
                        <div class="form-group">
                            <label>Tipo</label>
                            <select class="form-control" id="tipo" name="tipo" onchange="cambiaTipo()">

                                <?php
                                $roles = \Illuminate\Support\Facades\DB::table('rol_empleado')->get();
                                ?>

                                @foreach($roles as $rol)
                                    <option value="{{$rol->id}}">{{$rol->detalle}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <select class="form-control" id="estado" name="estado">
                                <option value="1">Activo</option>
                                <option value="0">Eliminado</option>

                            </select>
                        </div>
                        {{--                        <div id="supervisor-auth">--}}
                        {{--                            <div class="form-group">--}}
                        {{--                                <label>Usuario</label>--}}
                        {{--                                <input type="text" class="form-control" name="usuario" value="{{old('usuario')}}">--}}
                        {{--                            </div>--}}
                        {{--                            <div class="form-group">--}}
                        {{--                                <label>Clave</label>--}}
                        {{--                                <input type="password" class="form-control" name="clave" value="{{old('clave')}}">--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
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
    <script>
        function cambiaTipo() {
            var tipo = $("#tipo").val();
            if (tipo == 0) {
                $("#supervisor-auth").css("display", "none")
            } else {
                $("#supervisor-auth").css("display", "block")
            }
        }

        cambiaTipo();
    </script>
@endsection