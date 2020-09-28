@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12 col-md-5">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.user.update',$user->id)}}" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{$user->name}}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" value="{{$user->email}}">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" value="{{$user->password}}">
                        </div>
                        <div class="form-group">
                            <label>Tipo</label>
                            <select class="form-control" id="tipo" name="tipo" onchange="cambiaTipo()">

                                <?php
                                $roles = \Illuminate\Support\Facades\DB::table('rol_empleado')->get();
                                ?>

                                @foreach($roles as $rol)
                                    <option value="{{$rol->id}}" {{$user->tipo == $rol->id?'selected':''}}>{{$rol->detalle}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <select class="form-control" id="estado" name="estado">
                                <option value="1" {{$user->tipo == 1?'selected':''}}>Activo</option>
                                <option value="0" {{$user->tipo == 0?'selected':''}}>Eliminado</option>

                            </select>
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label>Tipo</label>--}}
{{--                            <select class="form-control" id="tipo" name="tipo" onchange="cambiaTipo()">--}}
{{--                                <option value="-1" {{$user->tipo == '-1'?'selected':''}}>Cesado</option>--}}
{{--                                <option value="0" {{$user->tipo == '0'?'selected':''}}>Personal</option>--}}
{{--                                <option value="1" {{$user->tipo == '1'?'selected':''}}>Administrativo</option>--}}
{{--                                <option value="2" {{$user->tipo == '2'?'selected':''}}>Supervisor</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div id="supervisor-auth">--}}
{{--                            <div class="form-group">--}}
{{--                                <label>Usuario</label>--}}
{{--                                <input type="text" class="form-control" name="usuario" value="{{$user->usuario}}">--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label>Clave</label>--}}
{{--                                <input type="password" class="form-control" name="clave" value="{{$user->clave}}">--}}
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
            if (parseInt(tipo) == 0 || parseInt(tipo) == -1) {
                $("#supervisor-auth").css("display", "none")
            } else {
                $("#supervisor-auth").css("display", "block")
            }
        }

        cambiaTipo();
    </script>
@endsection