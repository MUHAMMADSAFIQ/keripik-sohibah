@extends('layouts.app')

@section('content')
<div class="container" style="padding: 120px 20px 60px;">
    
    <div style="max-width: 900px; margin: 0 auto;">
        <!-- Header -->
        <div style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem; background: linear-gradient(135deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Profil Saya</h1>
                <p style="color: var(--text-muted);">Kelola informasi akun dan preferensi Anda</p>
            </div>
            
            <!-- Admin Link if Admin -->
            @if(Auth::user()->is_admin)
            <a href="{{ route('admin.dashboard') }}" class="btn" style="display: flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 12px; font-weight: 600;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                Dashboard Admin
            </a>
            @endif
        </div>

        <div class="glass-panel" style="padding: 2rem;">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 3rem; align-items: start;">
                    
                    <!-- Left Column: Avatar -->
                    <div style="text-align: center;">
                        <div style="position: relative; width: 150px; height: 150px; margin: 0 auto 1.5rem; cursor: pointer;" onclick="document.getElementById('avatarInput').click()">
                            <div style="width: 100%; height: 100%; border-radius: 50%; overflow: hidden; border: 4px solid white; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                                @if($user->avatar)
                                    <img src="{{ $user->avatar }}" id="avatarPreview" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div id="avatarPlaceholder" style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-size: 3rem; color: white; font-weight: 700;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <img src="" id="avatarPreview" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                @endif
                            </div>
                            
                            <!-- Edit Icon overlay -->
                            <div style="position: absolute; bottom: 5px; right: 5px; background: var(--primary); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; border: 3px solid white; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                            </div>
                        </div>
                        <input type="file" name="avatar" id="avatarInput" style="display: none;" accept="image/*" onchange="previewImage(this)">
                        
                        <h3 style="margin-bottom: 0.5rem; font-weight: 700;">{{ $user->name }}</h3>
                        <p style="color: var(--text-muted); font-size: 0.9rem;">{{ '@' . $user->username }}</p>
                    </div>

                    <!-- Right Column: Form Fields -->
                    <div style="display: display; gap: 1.5rem;">
                        <h3 style="font-size: 1.2rem; font-weight: 700; border-bottom: 1px solid var(--glass-border); padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Informasi Dasar</h3>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                            <!-- Name -->
                            <div class="profile-field-wrapper">
                                <label class="profile-label">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="profile-input" autocomplete="off_name">
                                @error('name') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
                            </div>

                            <!-- Username -->
                            <div class="profile-field-wrapper">
                                <label class="profile-label">Username</label>
                                <input type="text" name="username" value="{{ old('username', $user->username) }}" class="profile-input" autocomplete="off_username">
                                @error('username') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                            <!-- Email -->
                            <div class="profile-field-wrapper">
                                <label class="profile-label">Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="profile-input" autocomplete="off_email">
                                @error('email') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
                            </div>

                            <!-- Phone -->
                            <div class="profile-field-wrapper">
                                <label class="profile-label">Nomor WhatsApp</label>
                                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890" class="profile-input" autocomplete="off_phone">
                                @error('phone') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
                                <small style="display: block; margin-top: 5px; color: var(--text-muted); font-size: 0.75rem;">Pastikan nomor aktif untuk mempermudah komunikasi.</small>
                            </div>
                        </div>

                        <!-- Password Section (Toggle) -->
                        <div style="margin-top: 1rem;">
                            <div style="display: flex; align-items: center; justify-content: space-between; cursor: pointer; padding: 10px 0;" onclick="togglePasswordSection()">
                                <h3 style="font-size: 1.2rem; font-weight: 700; width: 100%; margin: 0;">Ganti Password (Opsional)</h3>
                                <span id="passToggleIcon" style="transition: transform 0.3s;">▼</span>
                            </div>
                            
                            <div id="passwordFields" style="display: none; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--glass-border);">
                                <div class="profile-field-wrapper" style="grid-column: span 2;">
                                    <label class="profile-label">Password Saat Ini</label>
                                    <input type="password" name="current_password" placeholder="Wajib diisi jika mengganti password" class="profile-input" autocomplete="new-password">
                                    @error('current_password') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
                                </div>
                                <div class="profile-field-wrapper">
                                    <label class="profile-label">Password Baru</label>
                                    <input type="password" name="new_password" placeholder="Minimal 8 karakter" class="profile-input" autocomplete="new-password">
                                    @error('new_password') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
                                </div>
                                <div class="profile-field-wrapper">
                                    <label class="profile-label">Ulangi Password Baru</label>
                                    <input type="password" name="new_password_confirmation" class="profile-input" autocomplete="new-password">
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 2rem; text-align: right;">
                            <button type="submit" class="btn" style="padding: 12px 30px; font-weight: 700; font-size: 1rem; border-radius: 50px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; border: none; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                var preview = document.getElementById('avatarPreview');
                var placeholder = document.getElementById('avatarPlaceholder');
                
                preview.src = e.target.result;
                preview.style.display = 'block';
                if(placeholder) placeholder.style.display = 'none';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    function togglePasswordSection() {
        var section = document.getElementById('passwordFields');
        var icon = document.getElementById('passToggleIcon');
        if (section.style.display === 'none') {
            section.style.display = 'grid';
            icon.style.transform = 'rotate(180deg)';
        } else {
            section.style.display = 'none';
            icon.style.transform = 'rotate(0deg)';
        }
    }
</script>

<style>
/* Login-style Premium Input Styling */
.profile-input {
    width: 100%;
    padding: 14px 24px;
    border-radius: 50px;
    border: 2px solid transparent; 
    background: #ffffff;
    color: #000000 !important; /* Absolute Black for Max Contrast */
    font-size: 1.05rem; /* Larger Text */
    font-weight: 700; /* Bolder Text */
    outline: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.profile-input:focus {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(139, 92, 246, 0.3);
    border-color: var(--primary);
}

/* Autofill Fix */
.profile-input:-webkit-autofill,
.profile-input:-webkit-autofill:hover, 
.profile-input:-webkit-autofill:focus, 
.profile-input:-webkit-autofill:active{
    -webkit-box-shadow: 0 0 0 1000px #ffffff inset !important;
    -webkit-text-fill-color: #000000 !important;
    caret-color: #000000 !important;
    font-weight: 700 !important;
    font-size: 1.05rem !important;
    border-radius: 50px !important;
}

.profile-input::placeholder {
    color: #64748b;
    font-weight: 500;
}

.profile-field-wrapper {
    margin-bottom: 0.5rem; /* Add breathing room */
    position: relative;
}

.profile-label {
    display: block; 
    margin-bottom: 0.8rem; /* More space between label and input */
    font-weight: 700; /* Bold Labels */
    font-size: 1rem; /* Larger Labels */
    color: #ffffff; /* Pure White */
    margin-left: 12px;
    letter-spacing: 0.5px; /* Slight tracking */
    text-shadow: 0 2px 4px rgba(0,0,0,0.5); /* Stronger shadow for lift */
}

@media (max-width: 768px) {
    div[style*="grid-template-columns: 1fr 2fr"] {
        grid-template-columns: 1fr !important;
        gap: 2rem !important;
    }
    
    #passwordFields, 
    div[style*="grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
    
    .profile-field-wrapper[style*="grid-column: span 2"] {
        grid-column: span 1 !important;
    }
}
</style>
@endsection
