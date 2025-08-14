<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate(['otp_code' => 'required']);

        $otp = session('otp_code');
        $expires = session('otp_expires_at');

        if (!$otp || !$expires) {
            return redirect('/login')->withErrors(['otp_code' => 'OTP tidak ditemukan. Silakan login ulang.']);
        }

        if (now()->gt($expires)) {
            return redirect('/login')->withErrors(['otp_code' => 'OTP sudah kadaluarsa. Silakan login ulang.']);
        }

        if ($request->otp_code != $otp) {
            return redirect()->back()->withErrors(['otp_code' => 'Kode OTP salah.']);
        }

        // OTP benar → hapus session
        session()->forget(['otp_code', 'otp_expires_at']);

        return redirect('/dashboard');
    }
}
