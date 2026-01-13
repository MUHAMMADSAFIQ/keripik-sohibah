@extends('layouts.app')

@section('content')
<style>
    /* DESAIN ADAPTIF TEAM-AWARE - REGISTER PAGE */
    
    .auth-card {
        background: rgba(255, 255, 255, 0.9) !important; /* Light Default */
        backdrop-filter: blur(15px);
        border: 1px solid rgba(0, 0, 0, 0.1);
        color: #1e293b !important; /* Dark Text */
        padding: 3rem 2.5rem !important;
        transition: all 0.3s ease;
    }

    body.dark-mode .auth-card {
        background: rgba(15, 23, 42, 0.95) !important; /* Dark Mode */
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #f8fafc !important; /* Light Text */
    }

    .auth-card h2 {
        background: linear-gradient(135deg, #4ade80, #3b82f6) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        margin-bottom: 0.5rem !important;
    }

    /* Input Styling - Adaptive */
    .auth-card input:not([type="checkbox"]) {
        color-scheme: light !important; 
        background: #ffffff !important; 
        color: #1e293b !important; 
        border: 2px solid #e2e8f0 !important;
        padding: 1rem 1.25rem !important; 
        font-size: 1rem !important;
        font-weight: 500 !important;
        border-radius: 50px !important; 
        box-shadow: 0 4px 6px rgba(0,0,0,0.05) !important;
        width: 100%;
        margin-bottom: 0.5rem; 
    }

    /* Dark Mode Input Override */
    body.dark-mode .auth-card input:not([type="checkbox"]) {
        border-color: transparent !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.2) !important;
    }
    
    .auth-card input:not([type="checkbox"]):focus {
        border-color: #4ade80 !important;
        box-shadow: 0 0 0 4px rgba(74, 222, 128, 0.2) !important;
        outline: none !important;
    }

    /* Placeholder style */
    .auth-card input::placeholder {
        color: #94a3b8 !important;
        font-weight: 400 !important;
        opacity: 1 !important;
    }

    /* Tombol Register */
    .btn-register {
        width: 100%;
        padding: 1rem;
        border-radius: 50px !important;
        font-weight: 700 !important;
        font-size: 1.1rem !important;
        background: linear-gradient(135deg, #4ade80, #3b82f6) !important;
        color: white !important;
        border: none !important;
        cursor: pointer !important;
        margin-top: 1.5rem !important;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4) !important;
        transition: transform 0.2s;
    }
    
    .form-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }
    
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: 0;
        }
    }
    
    .error-msg {
        color: #ef4444 !important;
        font-size: 0.8rem;
        margin-left: 1rem;
        margin-bottom: 0.5rem;
        display: block;
    }
</style>

<div class="auth-container" style="min-height: 90vh; display: flex; align-items: center; justify-content: center; padding: 2rem;">
    <div class="auth-card glass-panel" style="width: 100%; max-width: 600px;">
        
        <div style="text-align: center; margin-bottom: 2rem;">
            <h2 style="font-size: 2.2rem; font-weight: 800;">Buat Akun Baru</h2>
            <p style="color: var(--text-muted); font-size: 1rem;">Bergabunglah dengan Keripik Sohibah sekarang!</p>
        </div>

        <form action="{{ route('register.perform') }}" method="POST" autocomplete="off">
            @csrf
            
            <!-- Row 1: Name & Username -->
            <div class="form-row">
                <div style="flex: 1;">
                    <input type="text" name="name" value="{{ old('name') }}" required 
                           placeholder="Nama Lengkap">
                    @error('name') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div style="flex: 1;">
                    <input type="text" name="username" value="{{ old('username') }}" required 
                           placeholder="Username">
                    @error('username') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Row 2: Phone & Email -->
            <div class="form-row">
                <div style="flex: 1;">
                    <input type="tel" name="phone" value="{{ old('phone') }}" required 
                           placeholder="Nomor WhatsApp (Contoh: 0812...)">
                    @error('phone') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div style="flex: 1;">
                    <input type="email" name="email" value="{{ old('email') }}" required 
                           placeholder="Alamat Email Valid">
                    @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Row 3: Password -->
            <div style="margin-bottom: 0.5rem;">
                <input type="password" name="password" required autocomplete="new-password" 
                       placeholder="Buat Password Baru (Min. 8 karakter)">
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <!-- Row 4: Confirm Password -->
            <div style="margin-bottom: 0.5rem;">
                <input type="password" name="password_confirmation" required 
                       placeholder="Ulangi Password">
            </div>

            <button type="submit" class="btn-register" onmousedown="this.style.transform='scale(0.98)'" onmouseup="this.style.transform='scale(1)'">
                DAFTAR SEKARANG
            </button>

            <!-- Divider and Google Register Removed as per request -->

            <div style="text-align: center; color: #94a3b8 !important; font-size: 0.95rem; margin-top: 2rem;">
                Sudah punya akun? <a href="{{ route('login') }}" style="color: #4ade80 !important; text-decoration: none; font-weight: 700;">Masuk disini</a>
            </div>
        </form>
    </div>
</div>
@endsection
