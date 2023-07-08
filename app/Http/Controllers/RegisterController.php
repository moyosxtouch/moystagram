<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    //
   public function index ()
    {
    return view('auth.register');
}
public function store(Request $request)
{
  //  dd($request);
 // dd($request->get('username'));
 //Modificar el request
 $request->request->add(['username'=>Str::slug($request->username)]);
 //Validacion
 $this->validate($request, [
    'name'=>'required|max:30',
    'username'=>'required|unique:users|min:3|max:20',
    'email'=>'required|unique:users|email|max:60',
    'password'=>'required|confirmed|min:6'
 ]);
 User::create([
    'name'=>$request->name,
    'username'=>$request->username,
    'email'=>$request->email,
    'password'=>$request->password
 ]);
 //autenticar un usuario
//  auth()->attempt([
//     'email'=>$request->email,
//     'password'=>$request->password
//  ]);
//Otra forma de autenticar usuario
auth()->attempt($request->only('email','password'));
 //Redireccionar
 return redirect()->route('posts.index', ['user' => auth()->user()->username]);
}
}
