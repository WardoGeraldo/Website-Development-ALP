<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function show(){
        return view('auth.login');
    }

public function login_auth(Request $request)
{
    // Validate input email and password
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Manual authentication for user and admin
    if (
        ($validated['email'] == 'user@user.com' && $validated['password'] == 'user') ||
        ($validated['email'] == 'admin@admin.com' && $validated['password'] == 'admin')
    ) {
        // Set session user email
        session(['user' => $validated['email']]);

        // Set role session variable
        if ($validated['email'] == 'admin@admin.com') {
            session(['role' => 'admin']);
            // Redirect admin to admin dashboard
            return redirect()->route('admin.dash');
        } else {
            session(['role' => 'user']);
            // Redirect normal user to home page
            return redirect()->route('home');
        }
    } else {
        // Login failed, redirect back with error message
        return redirect()->route('login.show')->with('error', 'Invalid email or password.');
    }
     // $credentials = $request->validate([
        //     'email' => 'required|email:dns',
        //     'password' => 'required',
        // ]);
    
        // if(Auth::attempt($credentials)){
        //     $request->session()->regenerate();
    
        //     return redirect()->intended('/home');
        // }
    
        // return back()->with([
        //     'error' => 'The provided credentials do not match our records.'
        // ]);
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
    
    public function forgotPassword(){
        return view ('auth.password');
    }
    public function logout(Request $request){
        session()->forget('user');  // Hapus sesi user
        return redirect()->route('login.show');  // Redirect ke halaman login
        // Auth::logout();
    
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
    
        // return redirect()->route('login.show');
    }


    


}