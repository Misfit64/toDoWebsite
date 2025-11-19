<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function index()
    {
        return view("auth.login");
    }

    public function authenticate(Request $request)
    {
        $creds = $request->validate([
            "username" => 'required',
            'password'=> 'required',
        ]);

        if(Auth::attempt(['username' => $creds['username'], 'password' => $creds['password']])) {
            // Mail::to(Auth::user()->email)->queue(new \App\Mail\UserCreated($user = Auth::user()));
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('success','Login Successful');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request): RedirectResponse
    {
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();
    return redirect()->route('home');
    }
}
