<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    

    public function loginForm(){
        return view("auth.login");
    }

    public function login(Request $request){
        
        // validate input
        $data = $request->validate([
            "email" => ['required' ,'email'],
            "password" => ['required']
        ]);

        // login user and redirect to dashboard
        if(Auth::attempt($data)) {
            $request->session()->regenerate();

            return redirect()->route("dashboard.index");
        }


        // erroe redirect

        return back()->withErrors([
            'email'=> "Email or Password Incorrect.",
        ])->onlyInput('email');

        // error redirect
        // return back()->withErrors([
        //     'email' => 'The provided credentials do not match our records.',
        // ])->onlyInput('email');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/');

    }

    public function signupForm(){
        return view("auth.signup");
    }

    public function register(Request $request){

        /// validate user input
        $request->validate([
        "name" => ['required'],
        "email" => ['required', 'email', 'unique:users,email'],
        "password" => ['required', 'confirmed', 'min:4'],
        ]);


        // create user 
        User::create([
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            "password" => Hash::make($request->input('password'))
        ]);

        // after signup redirect to login
        return redirect()->route('loginForm');
    }
}
