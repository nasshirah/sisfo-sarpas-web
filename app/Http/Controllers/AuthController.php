<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Tampilan Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors(['email' => 'Email atau Password salah']);
    }

    // Tampilan Form Register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

           $role= $request->input('role', 'user');

        // Hanya admin yang bisa membuat akun dengan level admin
        if ($role=== 'admin' && Auth::user()->role!== 'admin') {
            return back()->withErrors(['role' => 'You do not have permission to create an admin account.']);
        }

        User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'role' => 'user',
        ]);
        return redirect('/login')->with('success', 'Registration successful. Please log in.');
    }
    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}