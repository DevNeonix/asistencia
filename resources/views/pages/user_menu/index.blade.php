@extends('layouts.admin')
@section('content')
    <table class="table table-sm">

        <thead>
        <tr>
            <th>Usuario</th>
            <th>Ruta</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <form action="{{route('usuarios-menus.store')}}" method="POST">
            <tr>
                <td>
                    <select name="user_id" id="">
                        @php($users = \App\Models\User::all())
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="menu_id" id="">
                        @php($menus = \App\Models\Menu::all())
                        @foreach($menus as $menu)
                            <option value="{{$menu->id}}">{{$menu->titulo}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </td>
            </tr>
        </form>
        @foreach($user_menus as $mm)
            <tr>
                <td>{{$mm->user->name}}</td>
                <td>{{$mm->menu->titulo}}</td>
                <td>
                    <form action="{{route('usuarios-menus.destroy',$mm->id)}}" method="POST">
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach


        </tbody>


    </table>
@endsection
