<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }

    public function registerPage()
    {
        return view('auth.register');
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();

            if (Auth::attempt($credentials, true)) {
                $request->session()->regenerate();
                return redirect()->intended()->withSuccess('Login successfully');
            }

            return back()->withError('Email or password is incorrect!');
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage());
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $user = User::create([
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
            ]);

            Auth::login($user, true);

            return redirect()->intended()->withSuccess('Register successfully');
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('auth.loginPage');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
