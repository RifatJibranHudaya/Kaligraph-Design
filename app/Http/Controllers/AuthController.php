<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show the login choice portal (Customer vs Admin).
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Show Admin / Staff Login form.
     */
    public function showAdminLogin()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login-admin');
    }

    /**
     * Process Admin / Staff Login.
     */
    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        // Check if user exists & is an admin/staff
        $user = User::where('username', $credentials['username'])
            ->orWhere('email', $credentials['username'])
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->onlyInput('username');
        }

        if ($user->isCustomer()) {
            return back()->withErrors([
                'username' => 'Akun ini terdaftar sebagai Akun Pelanggan. Silakan masuk melalui Halaman Login Pelanggan.',
            ])->onlyInput('username');
        }

        Auth::guard('web')->login($user, $remember);

        if ($user->branch_id) {
            Session::put('active_branch_id', $user->branch_id);
        }

        ActivityLogService::log('login_admin', 'auth', 'Admin/Staff logged in: ' . $user->username);

        return redirect()->intended(route('dashboard'))->with('success', 'Selamat datang kembali, ' . $user->username . '!');
    }

    /**
     * Show Customer Login form.
     */
    public function showCustomerLogin()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.dashboard');
        }
        return view('auth.login-customer');
    }

    /**
     * Process Customer Login.
     */
    public function loginCustomer(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Email atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        // Check if user exists by email or username
        $user = User::where('email', $credentials['email'])
            ->orWhere('username', $credentials['email'])
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'Email atau kata sandi tidak sesuai.',
            ])->onlyInput('email');
        }

        if (!$user->isCustomer()) {
            // If an admin logs in here, log them into web guard and redirect to admin dashboard
            Auth::guard('web')->login($user, $remember);
            if ($user->branch_id) {
                Session::put('active_branch_id', $user->branch_id);
            }
            return redirect()->intended(route('dashboard'))->with('success', 'Selamat datang kembali, ' . $user->username . '!');
        }

        Auth::guard('customer')->login($user, $remember);

        ActivityLogService::log('login_customer', 'auth', 'Customer logged in: ' . $user->username);

        $usernameDisplay = $user->username ?: 'Pelanggan';
        return redirect()->intended(route('customer.dashboard'))->with('success', 'Selamat datang di Portal Pelanggan, ' . $usernameDisplay . '!');
    }

    /**
     * Show Customer Registration form.
     */
    public function showCustomerRegister()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.dashboard');
        }
        return view('auth.register-customer');
    }

    /**
     * Process Customer Registration.
     */
    public function registerCustomer(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:100|unique:users,email',
            'phone'    => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar. Silakan gunakan email lain atau masuk ke akun Anda.',
            'phone.required'     => 'Nomor WhatsApp/HP wajib diisi.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Generate username from email or name
        $baseUsername = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode('@', $validated['email'])[0]));
        $username = $baseUsername;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        $user = User::create([
            'username'  => $username,
            'email'     => strtolower(trim($validated['email'])),
            'phone'     => $validated['phone'],
            'password'  => Hash::make($validated['password']),
            'level'     => 'customer',
            'user_type' => 'customer',
        ]);

        Auth::guard('customer')->login($user);

        ActivityLogService::log('register_customer', 'auth', "New customer registered: {$user->username} ({$user->email})");

        return redirect()->route('customer.dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang di Kaligraph Design.');
    }

    /**
     * Logout Admin / Staff user.
     */
    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            ActivityLogService::log('logout', 'auth', 'Admin/Staff logged out: ' . Auth::guard('web')->user()->username);
            Auth::guard('web')->logout();
        }

        return redirect()->route('home')->with('success', 'Anda telah berhasil keluar.');
    }

    /**
     * Logout Customer user.
     */
    public function customerLogout(Request $request)
    {
        if (Auth::guard('customer')->check()) {
            ActivityLogService::log('logout_customer', 'auth', 'Customer logged out: ' . Auth::guard('customer')->user()->username);
            Auth::guard('customer')->logout();
        }

        return redirect()->route('home')->with('success', 'Anda telah berhasil keluar dari Portal Pelanggan.');
    }

    /**
     * Switch Active Branch for Admin/Owner.
     */
    public function switchBranch(Request $request)
    {
        $request->validate([
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        $user = Auth::guard('web')->user();
        if (!$user || !$user->isOwner()) {
            return back()->with('error', 'Hanya Owner/Superadmin yang dapat mengubah cabang aktif.');
        }

        Session::put('active_branch_id', $request->branch_id ?: null);

        return back()->with('success', 'Cabang aktif berhasil diubah.');
    }
}
