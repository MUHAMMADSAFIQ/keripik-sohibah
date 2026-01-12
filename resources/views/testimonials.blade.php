@extends('layouts.app')

@section('content')
<section class="container">
    <h1 style="text-align: center;">Testimoni Pelanggan</h1>
    
    <div class="glass-panel" style="padding: 2rem; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
        <h3 style="text-align: center;">Berikan Masukan Anda</h3>
        <form action="{{ route('testimonials.store') }}" method="POST">
            @csrf
            <label>Nama</label>
            <input type="text" name="customer_name" required placeholder="Nama Anda">
            
            <label>Rating</label>
            <select name="rating" required style="width: 100%; background: #333; color: white;">
                <option value="5">⭐⭐⭐⭐⭐ (Sangat Puas)</option>
                <option value="4">⭐⭐⭐⭐ (Puas)</option>
                <option value="3">⭐⭐⭐ (Cukup)</option>
                <option value="2">⭐⭐ (Kurang)</option>
                <option value="1">⭐ (Kecewa)</option>
            </select>
            
            <label>Ulasan</label>
            <textarea name="content" rows="3" required placeholder="Ceritakan pengalaman Anda..."></textarea>
            
            <button type="submit" class="btn" style="width: 100%;">Kirim Testimoni</button>
        </form>
    </div>

    <div class="grid">
        @foreach($testimonials as $testi)
            <div class="card glass-panel">
                 <div style="color: var(--secondary); margin-bottom: 10px;">
                    @for($i=0; $i<$testi->rating; $i++) ★ @endfor
                </div>
                <p>"{{ $testi->content }}"</p>
                <div style="margin-top: 1rem; font-weight: bold; color: var(--primary);">
                    - {{ $testi->customer_name }}
                </div>
                <small style="color: var(--text-muted);">{{ $testi->created_at->format('d M Y') }}</small>
            </div>
        @endforeach
    </div>
</section>
@endsection
