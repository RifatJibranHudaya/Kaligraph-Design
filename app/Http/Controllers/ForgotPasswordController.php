<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\User;
use App\Services\ActivityLogService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Show form to input email for password reset.
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Generate & send OTP code to email.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        $email = strtolower(trim($request->email));
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tersebut tidak terdaftar di sistem kami.'])->withInput();
        }

        // Generate 6 digit numeric OTP
        $otp = (string) random_int(100000, 999999);

        // Invalidate previous unused OTPs for this email
        DB::table('password_otp_codes')
            ->where('email', $email)
            ->where('is_used', false)
            ->update(['is_used' => true]);

        // Insert new OTP record (valid for 10 minutes)
        DB::table('password_otp_codes')->insert([
            'email'      => $email,
            'otp_code'   => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
            'is_used'    => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Send Email via Mailpit / SMTP
        try {
            Mail::to($email)->send(new OtpMail($otp, $email));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email OTP: ' . $e->getMessage()])->withInput();
        }

        // Store email in session for OTP verification
        session([
            'otp_email'      => $email,
            'otp_sent_at'    => Carbon::now()->timestamp,
            'otp_expires_at' => Carbon::now()->addMinutes(10)->timestamp,
        ]);

        ActivityLogService::log('otp_request', 'auth', "OTP requested for email: {$email}");

        return redirect()->route('password.otp.verify')->with('success', 'Kode OTP 6-digit telah dikirimkan ke email ' . $email . '. Silakan cek kotak masuk atau folder spam Anda.');
    }

    /**
     * Show form to enter 6 digit OTP.
     */
    public function showVerifyOtpForm()
    {
        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi telah berakhir, silakan masukkan email kembali.']);
        }

        $expiresAt = session('otp_expires_at', Carbon::now()->addMinutes(10)->timestamp);

        return view('auth.otp-verify', compact('email', 'expiresAt'));
    }

    /**
     * Verify the 6 digit OTP code.
     */
    public function verifyOtp(Request $request)
    {
        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi telah berakhir, silakan masukkan email kembali.']);
        }

        $request->validate([
            'otp_code' => 'required|string|size:6',
        ], [
            'otp_code.required' => 'Kode OTP wajib diisi.',
            'otp_code.size'     => 'Kode OTP harus terdiri dari 6 digit.',
        ]);

        $otpRecord = DB::table('password_otp_codes')
            ->where('email', $email)
            ->where('otp_code', trim($request->otp_code))
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->latest('id')
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp_code' => 'Kode OTP salah atau telah kadaluarsa. Silakan coba lagi.'])->withInput();
        }

        // Mark OTP as used
        DB::table('password_otp_codes')
            ->where('id', $otpRecord->id)
            ->update(['is_used' => true, 'updated_at' => Carbon::now()]);

        // Generate a temporary reset token
        $resetToken = Str::random(60);
        session([
            'reset_email' => $email,
            'reset_token' => $resetToken,
        ]);

        // Clear OTP sessions
        session()->forget(['otp_email', 'otp_sent_at', 'otp_expires_at']);

        ActivityLogService::log('otp_verified', 'auth', "OTP successfully verified for email: {$email}");

        return redirect()->route('password.reset.form')->with('success', 'Kode OTP terverifikasi! Silakan masukkan kata sandi baru Anda.');
    }

    /**
     * Resend OTP code.
     */
    public function resendOtp()
    {
        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi telah berakhir, silakan masukkan email kembali.']);
        }

        $otp = (string) random_int(100000, 999999);

        DB::table('password_otp_codes')
            ->where('email', $email)
            ->where('is_used', false)
            ->update(['is_used' => true]);

        DB::table('password_otp_codes')->insert([
            'email'      => $email,
            'otp_code'   => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
            'is_used'    => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        try {
            Mail::to($email)->send(new OtpMail($otp, $email));
        } catch (\Exception $e) {
            return back()->withErrors(['otp_code' => 'Gagal mengirim ulang OTP: ' . $e->getMessage()]);
        }

        session([
            'otp_sent_at'    => Carbon::now()->timestamp,
            'otp_expires_at' => Carbon::now()->addMinutes(10)->timestamp,
        ]);

        return back()->with('success', 'Kode OTP baru telah berhasil dikirim ke ' . $email);
    }

    /**
     * Show form to reset password.
     */
    public function showResetForm()
    {
        $email = session('reset_email');
        $token = session('reset_token');

        if (!$email || !$token) {
            return redirect()->route('password.request')->withErrors(['email' => 'Silakan verifikasi email dan OTP terlebih dahulu.']);
        }

        return view('auth.reset-password', compact('email'));
    }

    /**
     * Reset user's password.
     */
    public function resetPassword(Request $request)
    {
        $email = session('reset_email');
        $token = session('reset_token');

        if (!$email || !$token) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi telah berakhir. Silakan ulangi proses reset password.']);
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required'  => 'Password baru wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('password.request')->withErrors(['email' => 'User tidak ditemukan.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Invalidate reset session
        session()->forget(['reset_email', 'reset_token']);

        ActivityLogService::log('password_reset', 'auth', "Password reset completed for: {$user->username} ({$email})");

        // Redirect to appropriate login page based on user_type
        if ($user->user_type === 'customer') {
            return redirect()->route('login.customer')->with('success', 'Kata sandi berhasil diperbarui! Silakan masuk menggunakan kata sandi baru Anda.');
        }

        return redirect()->route('login.admin')->with('success', 'Kata sandi berhasil diperbarui! Silakan masuk menggunakan kata sandi baru Anda.');
    }
}
