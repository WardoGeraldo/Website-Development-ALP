<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
            session(['user_id' => $id]);
            $user = Auth::user();
            session(['user' => $user]);
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

    public function storeRegister(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
        ]);

        // Insert data user
        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => bcrypt($request->password),
            'role'         => 'customer', // default role
            'address'      => $request->address,
            'phone_number' => $request->phone_number,
            'birthdate'    => $request->birthdate,
            'status_del'   => 0, // aktif
        ]);

        // Redirect
        return redirect()->route('login')->with('success', 'Account created successfully!');
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
