@extends('layouts.app')

@section('content')
<section class="container" style="padding: 6rem 2rem; min-height: 85vh; display: flex; align-items: center; justify-content: center;">
    <div class="glass-panel" style="max-width: 600px; width: 100%; padding: 2.5rem; border-radius: 20px;">
        
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="width: 60px; height: 60px; background: rgba(139, 92, 246, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; border: 1px solid rgba(139, 92, 246, 0.3);">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                    <line x1="1" y1="10" x2="23" y2="10"></line>
                </svg>
            </div>
            <h1 style="font-size: 1.8rem; font-weight: 800; margin-bottom: 0.5rem;">Pilih Metode Pembayaran</h1>
            <p style="color: var(--text-muted);">Selesaikan pesanan #{{ $order->id }} sebesar <strong style="color: var(--primary);">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></p>
        </div>

        <form action="{{ route('payment.process', $order->id) }}" method="POST">
            @csrf
            
            <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
                <!-- Online Payment -->
                <label style="cursor: pointer;">
                    <input type="radio" name="payment_method" value="midtrans" checked class="payment-radio" style="display: none;">
                    <div class="payment-card" style="padding: 1.25rem; border: 2px solid var(--glass-border); border-radius: 16px; background: rgba(255,255,255,0.03); transition: all 0.3s ease; display: flex; align-items: center; gap: 1rem;">
                        <div style="background: rgba(139, 92, 246, 0.1); padding: 12px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; color: var(--text-main); font-size: 1rem; margin-bottom: 4px;">Transfer Bank / E-Wallet</div>
                            <div style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.4;">OVO, DANA, GoPay, ShopeePay, VA (BCA, BRI, BNI), Kartu Kredit</div>
                        </div>
                        <div class="radio-check"></div>
                    </div>
                </label>
                
                <!-- COD -->
                <label style="cursor: pointer;">
                    <input type="radio" name="payment_method" value="cod" class="payment-radio" style="display: none;">
                    <div class="payment-card" style="padding: 1.25rem; border: 2px solid var(--glass-border); border-radius: 16px; background: rgba(255,255,255,0.03); transition: all 0.3s ease; display: flex; align-items: center; gap: 1rem;">
                        <div style="background: rgba(16, 185, 129, 0.1); padding: 12px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; color: var(--text-main); font-size: 1rem; margin-bottom: 4px;">Bayar di Tempat (COD)</div>
                            <div style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.4;">Bayar tunai kepada kurir saat pesanan sampai di tujuan</div>
                        </div>
                        <div class="radio-check"></div>
                    </div>
                </label>
            </div>

            <button type="submit" class="btn" style="width: 100%; padding: 16px; font-size: 1.1rem; font-weight: 700; background: linear-gradient(135deg, var(--primary), var(--secondary)); border: none; box-shadow: 0 8px 24px rgba(139, 92, 246, 0.4);">
                Lanjut Pembayaran →
            </button>
        </form>
        
        <style>
            .payment-card:hover { border-color: var(--primary); transform: translateY(-3px); }
            .payment-radio:checked + .payment-card { background: rgba(139, 92, 246, 0.1); border-color: var(--primary); box-shadow: 0 8px 24px rgba(139, 92, 246, 0.2); }
            .payment-radio:checked + .payment-card .radio-check { background: var(--primary); box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.2); border-color: var(--primary); }
            .radio-check { width: 24px; height: 24px; border: 2px solid var(--text-muted); border-radius: 50%; transition: all 0.2s; }
        </style>

    </div>
</section>
@endsection
