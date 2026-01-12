<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginField = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $attempt = Auth::attempt([
            $loginField => $request->email,
            'password' => $request->password
        ], $request->filled('remember'));

        if ($attempt) {
            $request->session()->regenerate();
            // Force redirect to Home regardless of intended URL to avoid confusion with Admin redirects
            return redirect()->route('home')->with('success', 'Berhasil login! Selamat datang.');
        }

        return back()->withErrors([
            'email' => 'Username/Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Auth::login($user); // Auto-login disabled as per request

        return redirect(route('login'))->with('success', 'Registrasi berhasil! Silakan login dengan akun baru Anda.');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        // Do NOT invalidate session, to keep Admin session alive if active
        // $request->session()->invalidate(); 
        // $request->session()->regenerateToken();

        return redirect(route('home'))->with('success', 'Berhasil logout.');
    }

    // Google Auth
    public function redirectToGoogle()
    {
        if (empty(config('services.google.client_id'))) {
            return back()->with('error', 'Login Google belum dikonfigurasi (Missing API Keys). Silakan gunakan login manual.');
        }
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('email', $googleUser->getEmail())->first();

            if(!$user) {
                // Register new user from Google
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'username' => 'user_' . strtolower(str_replace(' ', '', $googleUser->getName())) . rand(100,999),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make('google_' . rand(100000,999999)), // Random password
                ]);
            } else {
                // Update avatar/google_id
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar()
                ]);
            }

            Auth::login($user);
            return redirect(route('home'))->with('success', 'Login Google Berhasil!');

        } catch (\Exception $e) {
            return redirect(route('login'))->with('error', 'Gagal login Google. Silakan coba manual.');
        }
    }
}
