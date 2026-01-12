@extends('layouts.app')

@section('content')
<section class="container" style="min-height: 85vh; padding-top: 4rem;">
    <div class="reveal" style="text-align: center; margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem; background: var(--gradient-text); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Lacak Pesanan Kamu</h1>
        <p style="color: var(--text-muted);">Masukkan nomor WhatsApp yang kamu gunakan saat memesan.</p>
    </div>
    
    <div class="glass-panel reveal" style="max-width: 600px; margin: 0 auto; padding: 2.5rem; position: relative; overflow: hidden;">
        <!-- Decorative blob -->
        <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: var(--primary); filter: blur(80px); opacity: 0.2;"></div>

        <form action="{{ route('order.check') }}" method="GET" style="position: relative; z-index: 2;">
            <div style="display: flex; gap: 8px; align-items: stretch;">
                <div style="flex: 1; background: rgba(0,0,0,0.3); padding: 4px; border-radius: 12px; border: 1px solid var(--glass-border); display: flex; align-items: center;">
                    <input type="text" name="phone" placeholder="Contoh: 081234567890" required value="{{ request('phone') }}" 
                        style="flex: 1; background: transparent; border: none; color: white; padding: 10px 15px; font-size: 1rem; outline: none;">
                </div>
                <button class="btn" style="border-radius: 10px; padding: 10px 18px; display: flex; align-items: center; justify-content: center; min-width: auto; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </div>
        </form>

        @if(isset($orders))
            <div style="margin-top: 3rem;">
                @if($orders->count() > 0)
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                        <h3 style="font-size: 1.2rem;">Riwayat Pesanan</h3>
                        <span style="background: rgba(255,255,255,0.1); padding: 4px 10px; border-radius: 20px; font-size: 0.8rem;">
                            {{ $orders->count() }} Transaksi
                        </span>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        @foreach($orders as $order)
                            @php
                                $statusColor = match($order->status) {
                                    'pending' => '#f59e0b', // Amber
                                    'confirmed' => '#3b82f6', // Blue
                                    'delivering' => '#8b5cf6', // Violet
                                    'completed' => '#10b981', // Emerald
                                    'cancelled' => '#ef4444', // Red
                                    default => '#64748b'
                                };
                                $statusLabel = match($order->status) {
                                    'pending' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 6px;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>Menunggu Konfirmasi',
                                    'confirmed' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 6px;"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>Sedang Diproses',
                                    'delivering' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 6px;"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>Sedang Diantar',
                                    'completed' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 6px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>Selesai',
                                    'cancelled' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 6px;"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>Dibatalkan',
                                    default => $order->status
                                };
                            @endphp
                            
                            <div class="glass-panel" style="padding: 1.5rem; border-left: 4px solid {{ $statusColor }}; transform: scale(1); transition: transform 0.2s;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                                    <div>
                                        <div style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 2px;">Order ID #{{ $order->id }}</div>
                                        <div style="font-weight: bold; font-size: 1.1rem;">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                    </div>
                                    <div style="background: {{ $statusColor }}20; color: {{ $statusColor }}; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; border: 1px solid {{ $statusColor }}40; display: flex; align-items: center;">
                                        {!! $statusLabel !!}
                                    </div>
                                </div>
                                
                                <div style="border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05); padding: 1rem 0; margin: 1rem 0;">
                                    @foreach($order->items as $item)
                                        <div style="display: flex; justify-content: space-between; font-size: 0.95rem; margin-bottom: 5px;">
                                            <span style="color: #e2e8f0;">{{ $item->quantity }}x {{ $item->product->name }}</span>
                                            <span style="color: var(--text-muted);">Rp {{ number_format($item->price * $item->quantity, 0) }}</span>
                                        </div>
                                    @endforeach
                                    @if($order->shipping_cost > 0)
                                        <div style="display: flex; justify-content: space-between; font-size: 0.95rem; margin-top: 5px; color: #94a3b8;">
                                            <span>Ongkir ({{ number_format($order->distance_meters) }}m)</span>
                                            <span>Rp {{ number_format($order->shipping_cost, 0) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div style="font-size: 0.9rem; color: var(--text-muted);">
                                        Via: {{ $order->delivery_method == 'delivery' ? 'Antar kerumah' : 'Ambil di Toko' }}
                                    </div>
                                    <div style="font-size: 1.2rem; font-weight: 700; color: var(--secondary);">
                                        Rp {{ number_format($order->total_price, 0) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 2rem; opacity: 0.7;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; color: var(--text-muted);">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <p>Belum ada pesanan dengan nomor tersebut.</p>
                        <a href="{{ route('order.create') }}" style="color: var(--primary); text-decoration: underline; font-size: 0.9rem;">Pesan sekarang?</a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection
