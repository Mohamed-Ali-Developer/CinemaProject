<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function show(){
        return view('Login.LoginPage');
    }

    public function store(LoginRequest $request){
        
        if(
            !Auth::attempt([
                'email'=>$request->email,
                'password'=>$request->password
            ])
        ){
            return back()->withErrors([
                'email' => 'Invalid credentials',
            ])->withInput();
        }
        if (Auth::user()->role !== 'admin') {
            Auth::logout();

            return back()->withErrors([
                'email' => 'You are not authorized as admin.',
            ])->withInput();
        }
        $request->session()->regenerate();
        return redirect()->route('MainAdmin');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('Login');
    }
}
