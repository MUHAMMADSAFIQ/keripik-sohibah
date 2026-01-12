@extends('layouts.app')

@section('content')
@section('content')
<section class="container" style="padding-top: 8rem; padding-bottom: 5rem;">
    <div style="text-align: center; margin-bottom: 4rem;" class="reveal">
        <span style="color: var(--secondary); font-weight: bold; letter-spacing: 1px; text-transform: uppercase;">Partnership</span>
        <h1 style="font-size: 3rem; margin-top: 0.5rem; background: linear-gradient(120deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Mitra Keripik Sohibah</h1>
        <p style="color: var(--text-muted); max-width: 600px; margin: 1rem auto;">Temukan produk kami di toko-toko terdekat atau bergabunglah menjadi bagian dari kesuksesan kami!</p>
    </div>
    
    <!-- Join Banner -->
    <div class="glass-panel reveal" style="padding: 3rem; margin-bottom: 4rem; text-align: center; border-radius: 24px; border: 1px solid var(--primary); background: linear-gradient(145deg, rgba(0, 174, 213, 0.05), rgba(0, 174, 213, 0.01));">
        <h3 style="font-size: 1.8rem; margin-bottom: 1rem;">Ingin Menjadi Mitra?</h3>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">Dapatkan harga khusus reseller, materi promosi, dan keuntungan menarik lainnya.</p>
        <a href="{{ route('contact') }}" class="btn" style="padding: 12px 32px; border-radius: 50px;">Hubungi Kami Sekarang</a>
    </div>

    <div style="margin-bottom: 2rem;">
        <h3 style="border-left: 4px solid var(--secondary); padding-left: 1rem;">Lokasi Mitra Aktif</h3>
    </div>

    <div class="grid reveal">
        @forelse($partners as $partner)
            <div class="card glass-panel" style="align-items: center; text-align: center; border-radius: 20px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="width: 70px; height: 70px; background: rgba(6, 182, 212, 0.1); color: var(--secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 1.5rem;">
                    📍
                </div>
                <h3 style="margin-bottom: 0.5rem;">{{ $partner->name }}</h3>
                <p style="color: var(--text-muted); margin-bottom: 1rem; font-size: 0.95rem;">{{ $partner->address }}</p>
                
                <div style="background: rgba(255,255,255,0.05); padding: 0.5rem 1rem; border-radius: 8px; width: 100%; margin-bottom: 1.5rem;">
                     <small style="color: var(--secondary); display: block; font-weight: bold;">{{ $partner->info }}</small>
                </div>
                
                <a href="https://maps.google.com/?q={{ $partner->latitude }},{{ $partner->longitude }}" target="_blank" class="btn" style="font-size: 0.9rem; padding: 12px 0; width: 100%; border-radius: 12px; background: transparent; border: 1px solid var(--glass-border);">
                    🗺️ Lihat di Peta
                </a>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 4rem;" class="glass-panel">
                <div style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;">📭</div>
                <p>Belum ada mitra terdaftar saat ini.</p>
            </div>
        @endforelse
    </div>
</section>
@endsection
