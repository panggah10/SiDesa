<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return back();
        }
        return view('pages.auth.login');
    }
    public function authenticate(Request $request)
    {
        if (Auth::check()) {
            return back();
        } else {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                // dd(Auth::user());
                $userStatus = Auth::user()->status;
                if ($userStatus  == 'submitted') {
                    return back()->withErrors([
                        'email' => 'Akun anda masih menunggu persetujuan admin',
                    ]);
                } else if ($userStatus  == 'rejected') {
                    return back()->withErrors([
                        'email' => 'Akun anda ditolak',
                    ]);
                }
                return redirect()->intended('dashboard');
            }

            return back()->withErrors([
                'email' => 'Terjadi kesealahan, periksa kembali email atau password anda.',
            ])->onlyInput('email');
        }
    }

    public function registerView()
    {
        if (Auth::check()) {
            return back();
        }
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            return back();
        }
        $validated = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role_id = 2;
        $user->saveOrFail();

        return redirect('/')->with('success', 'Berhasil mendaftarakan akun, menunggu persetujuan admin');
    }

    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/');
        }
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
