<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $field = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'roll';
        $credentials = [
            $field => $data['login'],
            'password' => $data['password'],
        ];

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->with('error', 'Invalid email, roll, or password.')->onlyInput('login');
        }

        $request->session()->regenerate();

        if (Auth::user()->status === 'blocked') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account is blocked.');
        }

        return redirect()->route(Auth::user()->isAdmin() ? 'admin.dashboard' : 'student.dashboard');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'roll' => ['required', 'string', 'max:30', 'unique:users,roll'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'roll' => $data['roll'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'student',
            'status' => 'active',
        ]);

        Auth::login($user);

        return redirect()->route('student.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out.');
    }
}