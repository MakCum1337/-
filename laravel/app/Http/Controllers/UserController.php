<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    public function register (Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);
        $user = User::create($request->all());
        event(new Registered($user));
        Auth::login($user);
        return redirect()->route('verification.notice');
    }

    public function sign_in(Request $request){
        $datas = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($datas)){
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email_or_password' => 'Wrong email or password'
        ]);
        // dd($request->all());
    }
}
