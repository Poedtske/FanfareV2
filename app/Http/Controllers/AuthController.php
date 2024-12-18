<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Functions\UserFunctions;

//Seems that this isn't used

class AuthController extends Controller
{
    public function register(Request $request){
        if($request->isMethod(('get'))){
            return view('auth.register');
        }

        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
        ]);

        $user=User::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($request->input('password')),
        ]);

        return redirect()
        ->route('login')
        ->with('success','Your account has been created! You can now login.');
    }

    public function login(Request $request){
        if($request->isMethod(('get'))){
            return view('auth.login');
        }

        $credentials=$request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        if(Auth::attempt($credentials)){
            UserFunctions::log('User login',$credentials['email']);
            return redirect()
                ->route('dashboard')
                ->with('success','You have successfully logged in');
        }
        UserFunctions::warning('User login Attempt',$credentials['email']);
        return redirect()
            ->route('login')
            ->withErrors('Provided login information is not valid');

    }

    public function logout(Request $request){
        UserFunctions::log('User logout',Auth::user()->email);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()
            ->route('home2')
            ->with('success','You have successfully logged out');
    }
}
