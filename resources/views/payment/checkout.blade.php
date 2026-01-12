@extends('layouts.app')

@section('content')
<section class="container" style="padding: 4rem 2rem; min-height: 70vh;">
    <div class="glass-panel" style="max-width: 800px; margin: 0 auto; padding: 3rem;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="margin-bottom: 1rem;">💳 Pembayaran</h1>
            <p style="color: var(--text-muted);">Selesaikan pembayaran untuk pesanan Anda</p>
        </div>

        <!-- Order Summary -->
        <div style="background: rgba(139, 92, 246, 0.1); padding: 2rem; border-radius: 16px; margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem;">📦 Detail Pesanan</h3>
            <div style="display: grid; gap: 0.5rem;">
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-muted);">Order ID:</span>
                    <strong>#{{ $order->id }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-muted);">Nama:</span>
                    <strong>{{ $order->customer_name }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-muted);">Total:</span>
                    <strong style="font-size: 1.5rem; color: var(--primary);">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>

        <!-- Payment Button -->
        <button id="pay-button" class="btn" style="width: 100%; padding: 1rem; font-size: 1.1rem;">
            🔒 Bayar Sekarang
        </button>

        <div style="text-align: center; margin-top: 1.5rem;">
            <small style="color: var(--text-muted);">
                ✅ Pembayaran aman dengan Midtrans<br>
                Support: GoPay, OVO, DANA, ShopeePay, Bank Transfer, Credit Card
            </small>
        </div>
    </div>
</section>

<!-- Midtrans Snap.js -->
<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ $clientKey }}"></script>
<script>
    const payButton = document.getElementById('pay-button');
    const snapToken = '{{ $snapToken }}';

    payButton.addEventListener('click', function() {
        if (!snapToken) {
            alert('Payment token not available. Please try again.');
            return;
        }

        snap.pay(snapToken, {
            onSuccess: function(result) {
                console.log('Payment success:', result);
                window.location.href = '{{ route("payment.success", $order->id) }}';
            },
            onPending: function(result) {
                console.log('Payment pending:', result);
                alert('Menunggu pembayaran Anda. Silakan selesaikan pembayaran.');
            },
            onError: function(result) {
                console.log('Payment error:', result);
                window.location.href = '{{ route("payment.failed", $order->id) }}';
            },
            onClose: function() {
                console.log('Payment popup closed');
                alert('Anda menutup popup pembayaran. Silakan coba lagi.');
            }
        });
    });
</script>
@endsection
