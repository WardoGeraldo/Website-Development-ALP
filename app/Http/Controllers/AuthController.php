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

    public function login_auth(Request $request){

         // Validasi input email dan password
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek kredensial
        if ($validated['email'] == 'user@user.com' && $validated['password'] == 'user') { //MANUAL
            // Set session untuk user yang login
            session(['user' => $validated['email']]);

            // Redirect ke halaman home setelah login berhasil
            return redirect()->route('home');
        } else {
            // Jika login gagal, tampilkan pesan error
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