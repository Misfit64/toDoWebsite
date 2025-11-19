<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;

class SignupController extends Controller
{
    public function index()
    {
        return view("auth.signup");
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $request->merge([
            'username' => strtolower($request->input('username')),
            'email' => strtolower($request->input('email')),
        ]);

       $request->validate([
            "username" => 'required|unique:users,username',
            "email" => 'required|email|unique:users,email',
            'password'=> 'required|confirmed:confirm-password',
            'confirm-password'=> 'required',
        ]);

        $user = User::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        Auth::login($user);

        $redirectUrl = route('home');

        Mail::to($user->email)->queue(new \App\Mail\UserCreated($user));

        if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'message' => 'Registration successful',
                    'redirect' => $redirectUrl
                ], 200);
            }


        return redirect()->route('home');
    }
}
