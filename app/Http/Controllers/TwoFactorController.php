<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFactorController extends Controller
{
    public function showSetupForm()
    {
        $google2fa = new Google2FA();
        $user = Auth::user();
        $isTwoFactorEnabled = !is_null($user->google2fa_secret);

        // Jika 2FA sudah aktif, kita kirim statusnya ke view tanpa generate QR baru
        if ($isTwoFactorEnabled) {
            return view('auth.2fa-setup', compact('isTwoFactorEnabled'));
        }

        // Generate secret key baru
        $secretKey = $google2fa->generateSecretKey();

        // Simpan secret di session sementara (jangan simpan di DB dulu sebelum diverifikasi)
        session(['2fa_secret_temp' => $secretKey]);

        // Generate QR Code URL
        $qrCodeUrl = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secretKey
        );

        return view('auth.2fa-setup', compact('qrCodeUrl', 'secretKey', 'isTwoFactorEnabled'));
    }

    public function enable(Request $request)
    {
        $request->validate(['otp' => 'required']);

        $google2fa = new Google2FA();
        $secret = session('2fa_secret_temp');

        // Validasi input user vs secret sementara
        if ($google2fa->verifyKey($secret, $request->otp)) {
            // Simpan permanen ke user
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->google2fa_secret = $secret;
            $user->save();

            session()->forget('2fa_secret_temp'); // Hapus temp
            session(['2fa_verified' => true]); // Set verified untuk sesi ini

            return redirect('/dashboard')->with('success', '2FA Berhasil Diaktifkan!');
        }

        return back()->withErrors(['otp' => 'Kode salah. Coba scan ulang.']);
    }

    public function disable(Request $request)
    {
        // 1. Validasi Password saat ini demi keamanan
        $request->validate([
            'current_password' => 'required|current_password',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 2. Kosongkan kolom secret
        $user->google2fa_secret = null;
        $user->save();

        // 3. Hapus status verifikasi di session (agar bersih)
        session()->forget('2fa_verified');

        return back()->with('success', 'Two-Factor Authentication berhasil dinonaktifkan.');
    }

    public function showVerifyForm()
    {
        return view('auth.2fa-verify');
    }

    public function verify(Request $request)
    {
        $request->validate(['otp' => 'required']);

        $google2fa = new Google2FA();
        $user = Auth::user();

        // Cek kode user vs secret di DB
        if ($google2fa->verifyKey($user->google2fa_secret, $request->otp)) {
            session(['2fa_verified' => true]);
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['otp' => 'Kode OTP salah.']);
    }
}
