@extends('layouts.app')

@section('content')
<section class="container" style="text-align: center;">
    <div class="glass-panel" style="padding: 3rem; max-width: 600px; margin: 0 auto; margin-top: 3rem;">
        <h1>Pesanan #{{ $order->id }}</h1>
        <p style="font-size: 1.2rem; margin-bottom: 2rem;">Waktu Pemesanan: {{ $order->created_at->format('d M Y H:i') }}</p>
        
        <div style="background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 10px; margin-bottom: 2rem;">
            <h2>Status: 
                <span style="color: {{ $order->status == 'cancelled' ? 'red' : 'var(--secondary)' }};">
                    {{ ucfirst($order->status) == 'Pending' ? 'Mohon Menunggu' : ucfirst($order->status) }}
                </span>
            </h2>
            @if($order->status == 'pending')
                <p>Mohon menunggu, admin sedang memproses pesanan Anda.</p>
                <div style="font-size: 3rem; margin-top: 10px;">⏳</div>
            @elseif($order->status == 'confirmed')
                <p>Pesanan dikonfirmasi! Sedang disiapkan.</p>
            @elseif($order->status == 'delivering')
                <p>Pesanan sedang diantar ke alamat Anda! 🚚</p>
            @elseif($order->status == 'completed')
                <p>Pesanan selesai. Terima kasih telah berbelanja!</p>
            @elseif($order->status == 'cancelled')
                <p style="color:red;">Maaf, pesanan dibatalkan (Stok habis / Alamat tidak terjangkau).</p>
            @endif
        </div>

        <h3>Rincian Pesanan</h3>
        <ul style="text-align: left; list-style: none; margin-bottom: 2rem; padding: 0;">
            @foreach($order->items as $item)
                <li style="padding: 5px 0; border-bottom: 1px solid rgba(255,255,255,0.1);">
                    {{ $item->product->name }} (x{{ $item->quantity }}) 
                    <span style="float: right;">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                </li>
            @endforeach
        </ul>
        <div style="text-align: left; padding-top: 10px;">
            <p>Ongkir: <span style="float: right;">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span></p>
            <h3 style="margin-top: 10px; border-top: 1px solid white; padding-top: 10px;">
                Total: <span style="float: right;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </h3>
        </div>
        
        <a href="{{ route('home') }}" class="btn" style="margin-top: 2rem;">Kembali ke Home</a>
    </div>
</section>
@endsection
