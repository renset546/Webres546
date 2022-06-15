<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use Illuminate\Support\Facades\Auth;

use LoginAlert;

use Session;

class AuthController extends Controller
{
    public function register(){

        return view('register');

    }

    public function saveUser(Request $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return redirect('/');

    }

    public function login(){

        if(!Session::has('email')){
            return view('/login');
        } else {
            return redirect('/dashboard');
        }
    }



    public function loginUser(Request $request){
        
        if(!Auth::attempt([
            'email' => $request->email, 
            'password' => $request->password
        ])){
            return  redirect('/');
        } else {
            Session::put('email', $request->email);
            return redirect('/dashboard');
        }
    }

    public function dashboard(){

        if(!Session::has('email')){
            return redirect('/');
        } else {
            return view('/dashboard');
        }
        
    }

    public function logout(){

        Session::flush();
        return redirect('/');

    }
}
