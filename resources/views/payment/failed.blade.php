@extends('layouts.app')

@section('content')
<section class="container" style="padding: 4rem 2rem; min-height: 70vh; display: flex; align-items: center; justify-content: center;">
    <div class="glass-panel" style="max-width: 600px; text-align: center; padding: 3rem;">
        <div style="font-size: 5rem; margin-bottom: 1rem;">❌</div>
        <h1 style="color: #ef4444; margin-bottom: 1rem;">Pembayaran Gagal</h1>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">
            Maaf, pembayaran Anda tidak dapat diproses. Silakan coba lagi.
        </p>

        <div style="background: rgba(239, 68, 68, 0.1); padding: 2rem; border-radius: 16px; margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem;">📋 Detail Pesanan</h3>
            <div style="display: grid; gap: 0.5rem; text-align: left;">
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-muted);">Order ID:</span>
                    <strong>#{{ $order->id }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-muted);">Status:</span>
                    <strong style="color: #ef4444;">{{ strtoupper($order->payment_status) }}</strong>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('payment.show', $order->id) }}" class="btn">
                🔄 Coba Lagi
            </a>
            <a href="{{ route('home') }}" class="btn" style="background: transparent; border: 2px solid var(--primary); color: var(--primary);">
                🏠 Kembali ke Home
            </a>
        </div>

        <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--glass-border);">
            <p style="color: var(--text-muted); font-size: 0.9rem;">
                Butuh bantuan? <a href="https://wa.me/6285643527635" target="_blank" style="color: var(--primary);">Hubungi Admin</a>
            </p>
        </div>
    </div>
</section>
@endsection
