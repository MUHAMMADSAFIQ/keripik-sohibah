@extends('layouts.app')

@section('content')
<section class="container" style="padding: 4rem 2rem; min-height: 70vh; display: flex; align-items: center; justify-content: center;">
    <div class="glass-panel" style="max-width: 600px; text-align: center; padding: 3rem;">
        <div style="font-size: 5rem; margin-bottom: 1rem;">✅</div>
        <h1 style="color: var(--primary); margin-bottom: 1rem;">Pembayaran Berhasil!</h1>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">
            Terima kasih! Pembayaran Anda telah kami terima.
        </p>

        <div style="background: rgba(139, 92, 246, 0.1); padding: 2rem; border-radius: 16px; margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem;">📋 Detail Pesanan</h3>
            <div style="display: grid; gap: 0.5rem; text-align: left;">
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-muted);">Order ID:</span>
                    <strong>#{{ $order->id }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-muted);">Nama:</span>
                    <strong>{{ $order->customer_name }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-muted);">Total Bayar:</span>
                    <strong style="color: var(--primary);">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-muted);">Metode:</span>
                    <strong>{{ strtoupper($order->payment_method ?? 'N/A') }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-muted);">Waktu Bayar:</span>
                    <strong>{{ $order->paid_at ? $order->paid_at->format('d M Y H:i') : 'N/A' }}</strong>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="{{ route('home') }}" class="btn">🏠 Kembali ke Home</a>
            <a href="{{ route('order.track') }}" class="btn" style="background: transparent; border: 2px solid var(--primary); color: var(--primary);">
                📦 Cek Status Pesanan
            </a>
        </div>
    </div>
</section>
@endsection
