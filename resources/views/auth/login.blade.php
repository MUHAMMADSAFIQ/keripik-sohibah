@extends('layouts.app')

@section('content')
<style>
    /* DESAIN ANTI-SENSOR DARK READER */
    /* Kita menghapus Label eksternal dan menggunakan Placeholder di dalam input */
    /* Input tetap PUTIH agar bersih dari autofill artifact hitam */
    
    .auth-card {
        background: rgba(15, 23, 42, 0.95) !important; /* Dark Glass Solid */
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #f8fafc !important;
        padding: 3rem 2rem !important; /* Spasi lebih luas */
    }

    .auth-card h2 {
        background: linear-gradient(135deg, #4ade80, #3b82f6) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        margin-bottom: 0.5rem !important;
    }

    /* Input: PUTIH BERSIH + Teks HITAM */
    .auth-card input:not([type="checkbox"]) {
        color-scheme: light !important; 
        background: #ffffff !important; 
        color: #1e293b !important; 
        border: 2px solid transparent !important;
        padding: 1rem 1.25rem !important; /* Padding besar enak dilihat */
        font-size: 1rem !important;
        font-weight: 500 !important;
        border-radius: 50px !important; /* Rounded Pill Shape - Modern */
        box-shadow: 0 4px 6px rgba(0,0,0,0.1) !important;
    }
    
    .auth-card input:not([type="checkbox"]):focus {
        border-color: #4ade80 !important;
        box-shadow: 0 0 0 4px rgba(74, 222, 128, 0.2) !important;
        outline: none !important;
    }

    /* Autofill Fix Absolute */
    .auth-card input:-webkit-autofill {
        -webkit-box-shadow: 0 0 0 1000px #ffffff inset !important;
        -webkit-text-fill-color: #1e293b !important;
        background-color: #ffffff !important;
        caret-color: #1e293b !important;
    }

    /* Placeholder style */
    .auth-card input::placeholder {
        color: #94a3b8 !important;
        font-weight: 400 !important;
        opacity: 1 !important; /* Firefox fix */
    }

    /* Checkbox & Links */
    .remember-me label {
        color: #cbd5e1 !important;
        font-size: 0.9rem !important;
    }
    .forgot-pass {
        color: #4ade80 !important;
        font-weight: 600 !important;
    }
    
    /* Tombol Login */
    .btn-login {
        width: 100%;
        padding: 1rem;
        border-radius: 50px !important; /* Pill shape */
        font-weight: 700 !important;
        font-size: 1.1rem !important;
        background: linear-gradient(135deg, #4ade80, #3b82f6) !important;
        color: white !important;
        border: none !important;
        cursor: pointer !important;
        margin-top: 1rem !important;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4) !important;
    }
    
    .or-divider span {
        background: #0f172a !important; 
        color: #94a3b8 !important;
    }
</style>

<div class="auth-container" style="min-height: 90vh; display: flex; align-items: center; justify-content: center; padding: 2rem;">
    <div class="auth-card glass-panel" style="width: 100%; max-width: 480px;">
        
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <h2 style="font-size: 2.2rem; font-weight: 800;">Selamat Datang!</h2>
            <p style="color: #cbd5e1; font-size: 1rem;">Masuk ke akun Keripik Sohibah Anda</p>
        </div>

        <form action="{{ route('login.perform') }}" method="POST" autocomplete="off">
            @csrf
            
            <!-- LABEL DIHAPUS, PINDAHKAN KE PLACEHOLDER AGAR TIDAK KENA SENSOR -->
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <input type="text" id="email" name="email" value="{{ old('email') }}" required autocomplete="off" 
                       placeholder="Email atau Username" aria-label="Email atau Username">
                @error('email')
                    <span style="color: #ef4444 !important; font-size: 0.85rem; margin-top: 0.5rem; display: block; margin-left: 1rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <input type="password" id="password" name="password" required autocomplete="new-password" 
                       placeholder="Password" aria-label="Password">
                @error('password')
                    <span style="color: #ef4444 !important; font-size: 0.85rem; margin-top: 0.5rem; display: block; margin-left: 1rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;" class="remember-me">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="remember" style="accent-color: #4ade80; width: 18px; height: 18px; cursor: pointer; box-shadow: none !important;">
                    Ingat Saya
                </label>
                <a href="#" class="forgot-pass" style="text-decoration: none;">Lupa Password?</a>
            </div>

            <button type="submit" class="btn-login" onmousedown="this.style.transform='scale(0.98)'" onmouseup="this.style.transform='scale(1)'">
                MASUK SEKARANG
            </button>

            <!-- Divider and Google Login Removed as per request -->

            <div style="text-align: center; color: #94a3b8 !important; font-size: 0.95rem; margin-top: 2rem;">
                Belum punya akun? <a href="{{ route('register') }}" style="color: #4ade80 !important; text-decoration: none; font-weight: 700;">Daftar disini</a>
            </div>
        </form>
    </div>
</div>
@endsection
