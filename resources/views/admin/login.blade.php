@extends('layouts.app')

@section('content')
<section class="container" style="min-height: 80vh; display: flex; justify-content: center; align-items: center;">
    <div class="glass-panel" style="padding: 3rem; width: 100%; max-width: 400px; text-align: center;">
        <h1 style="margin-bottom: 2rem;">Admin Login 🔐</h1>
        
        @if(session('error'))
            <div style="background: rgba(239, 68, 68, 0.2); color: #fca5a5; padding: 10px; border-radius: 8px; margin-bottom: 1rem;">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.login.perform') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 1.5rem; text-align: left;">
                <label style="display: block; margin-bottom: 5px;">Email</label>
                <input type="email" name="email" required placeholder="admin@sohibah.com" 
                       style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: rgba(0,0,0,0.3); color: white;">
            </div>
            
            <div style="margin-bottom: 2rem; text-align: left;">
                <label style="display: block; margin-bottom: 5px;">Password</label>
                <input type="password" name="password" required placeholder="••••••••" 
                       style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: rgba(0,0,0,0.3); color: white;">
            </div>
            
            <button type="submit" class="btn" style="width: 100%; padding: 12px; font-size: 1.1rem;">Masuk</button>
        </form>
    </div>
</section>
@endsection
