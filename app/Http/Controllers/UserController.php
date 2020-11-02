<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Util\myResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    public function loginview()
    {
        if(auth()->check()){
            return redirect()->to(route('admin.home'));
        }

        return view('pages.login');
    }

    public function login(LoginRequest $request)
    {
        $usuario = $request->input('usuario');
        $clave = $request->input('clave');
        $user = User::where('name', $usuario)->where('password', $clave);
        if ($user->count() == 0) {
            return redirect()->to('login')->withErrors('Las creedenciales no corresponden con nuestros registros.');
        } else {
            Auth::loginUsingId($user->get()[0]->id);
            Session::put('usuario', $user->get()[0]->id . '');
            return redirect()->to(route('admin.home'));
        }
    }

    public function loginApi(LoginRequest $request)
    {
        $usuario = $request->input('usuario');
        $clave = $request->input('clave');
        $user = User::where('name', $usuario)->where('password', $clave);
        if ($usuario == "" || $clave == "") {
            return response()->json(myResponse::apiResponse([], "Usuario o contraseña errada"), 403, [], 256);
        }
        if ($user->count() == 0) {
            return response()->json(myResponse::apiResponse([], "Usuario o contraseña errada"), 403, [], 256);
        } else {

            return response()->json(myResponse::apiResponse($user->get()[0], "Bienvenido " . $user->get()[0]->name), 200, [], 256);
        }
    }

    public function cerrarsesion()
    {
        Session::flush();
        return redirect()->to(route('login'));
    }

    public function list(Request $request)
    {
        if (!empty($request->input('buscar'))) {
            $data = User::where('name', 'like', '%' . $request->input('buscar') . '%');
            $data = $data->orWhere('email', 'like', '%' . $request->input('buscar') . '%');
            $data = $data->paginate()->appends(request()->query());
        } else {
            $data = User::paginate()->appends(request()->query());
        }

        return view('pages.users')->with('data', $data);
    }

    public function create()
    {
        return view('pages.user_create');
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $tipo = $request->input('tipo');
        $estado = $request->input('estado');
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'tipo' => $tipo,
            'estado' => $estado,
        ]);
        $id = $user->id;


        return redirect()->route('admin.users')->with('success', "El usuario #${id} ha sido registrado correctamente.");
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->get()[0];
        return view('pages.user_edit')->with(compact('user'));
    }

    public function update($id, Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $tipo = $request->input('tipo');
        $estado = $request->input('estado');
        User::where('id', $id)->update([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'tipo' => $tipo,
            'estado' => $estado,
        ]);
        return redirect()->route('admin.users')->with('success', "El usuario  ha sido modificado correctamente.");
    }

    public function home()
    {
        return view('admin.home');
    }
}
