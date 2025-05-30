<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function show()
    {
        return view('auth.login'); // your login form
    }

    public function login_auth(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Regenerate session
            $request->session()->regenerate();
            //  dd(Auth::user()->role);

            // Store role into session manually
            $role = Auth::user()->role;   // Get the role from DB
            $id = Auth::user()->user_id;
            session(['user_role' => $role]);
            session(['user_id'=> $id]); 
            $user = Auth::user();
            session(['user'=>$user]);
            //dd(session('user')); // Save to session
            //dd(session('user_role'));
            // dd(session('role'));
            // dd($role);

            // Redirect based on role
            if ($role === 'admin') {
                return redirect()->route('admin.dash');
            }

            return redirect()->route('home');
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah'])
            ->onlyInput('email');
    }



    public function auth_register(Request $request)
    {
        return view('auth.register');
        // // Validate form input
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email:dns|unique:users,email',
        //     'password' => 'required|string|min:8|confirmed',
        // ]);

        // // Create and save the user
        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

        // // Auto-login after registration (optional)
        // Auth::login($user);

        // // Redirect to home/dashboard
        // return redirect()->intended('/home');
    }

    public function forgotPassword()
    {
        return view('auth.password');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        // Flush all session
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
