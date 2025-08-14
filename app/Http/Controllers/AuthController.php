<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Generate OTP sederhana
            $otp = rand(100000, 999999);

            // Simpan OTP di session
            $request->session()->put('two_factor_code', $otp);

            // TODO: kirim OTP lewat email atau WhatsApp
            // Untuk testing, kita tampilkan langsung di layar
            return redirect()->route('two-factor.index')->with('info', 'OTP Anda: ' . $otp);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Anda telah logout.');
    }

    public function showTwoFactorForm()
    {
        return view('pages.auth.two-factor');
    }

    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $otp = session('two_factor_code');

        if ($request->otp == $otp) {
            // Hapus OTP dari session
            $request->session()->forget('two_factor_code');

            // Tandai 2FA sudah lolos
            $request->session()->put('two_factor_passed', true);

            return redirect('/dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['otp' => 'Kode OTP salah.']);
    }
}
