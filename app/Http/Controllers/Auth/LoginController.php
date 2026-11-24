<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function show(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // attempt() membandingkan input dengan HASH di tabel users
        if (Auth::attempt($data)) {
            // Regenerate ID session: mencegah session fixation
            $request->session()->regenerate();
            return redirect()->intended(route('buku.index'));
        }

        // Pesan generik: tidak membocorkan apakah email terdaftar
        return back()
            ->withErrors(['email' => 'Email atau kata sandi salah.'])
            ->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();       // batalkan session
        $request->session()->regenerateToken();  // token CSRF baru

        return redirect()->route('login');
    }
}