@extends('layouts.app')

@section('content')
<section class="container" style="padding-top: 8rem; padding-bottom: 5rem;">
    <h1 style="text-align: center; margin-bottom: 3rem;">Daftar Menu</h1>

    <!-- Simple Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        @foreach($products as $product)
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 1.5rem;">
                <!-- Image -->
                <div style="margin-bottom: 1rem;">
                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : route('product.image', basename($product->image)) }}" 
                         alt="{{ $product->name }}" 
                         style="width: 100%; height: 200px; object-fit: cover; border-radius: 12px;"
                         onerror="this.src='https://via.placeholder.com/400x300.png?text={{ urlencode($product->name) }}';">
                </div>
                
                <!-- Info -->
                <h3 style="margin-bottom: 0.5rem;">{{ $product->name }}</h3>
                <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1rem;">{{ Str::limit($product->description, 80) }}</p>
                
                <!-- Price -->
                <div style="font-size: 1.2rem; color: #00AED5; font-weight: bold; margin-bottom: 1rem;">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>
                
                <!-- Stock -->
                <div style="font-size: 0.85rem; margin-bottom: 1rem; color: {{ $product->stock > 0 ? '#10b981' : '#ef4444' }}">
                    {{ $product->stock > 0 ? 'Stok: '.$product->stock : 'Stok Habis' }}
                </div>

                <!-- Button -->
                @if($product->stock > 0)
                    <a href="{{ route('order.create') }}" style="display: block; text-align: center; background: #00AED5; color: white; padding: 10px; border-radius: 8px; text-decoration: none;">
                        Pesan Sekarang
                    </a>
                @else
                    <button style="width: 100%; background: #94a3b8; color: white; padding: 10px; border: none; border-radius: 8px; cursor: not-allowed;" disabled>
                        Stok Habis
                    </button>
                @endif
            </div>
        @endforeach
    </div>
</section>
@endsection
