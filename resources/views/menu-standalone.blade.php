<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Keripik Sohibah</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: Arial, sans-serif; 
            background: #f8fafc; 
            padding: 20px;
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
        }
        h1 { 
            text-align: center; 
            margin: 40px 0 20px; 
            color: #1e293b;
        }
        .grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
            gap: 20px; 
            margin-top: 40px;
        }
        .card { 
            background: white; 
            border: 1px solid #e2e8f0; 
            border-radius: 12px; 
            padding: 20px;
        }
        .card img { 
            width: 100%; 
            height: 200px; 
            object-fit: cover; 
            border-radius: 8px; 
            margin-bottom: 15px;
        }
        .card h3 { 
            font-size: 1.1rem; 
            margin-bottom: 10px; 
            color: #1e293b;
        }
        .card p { 
            color: #64748b; 
            font-size: 0.9rem; 
            margin-bottom: 15px;
        }
        .price { 
            font-size: 1.3rem; 
            color: #00AED5; 
            font-weight: bold; 
            margin-bottom: 10px;
        }
        .stock { 
            font-size: 0.85rem; 
            margin-bottom: 15px; 
            font-weight: 600;
        }
        .btn { 
            display: block; 
            text-align: center; 
            background: #00AED5; 
            color: white; 
            padding: 12px; 
            border-radius: 8px; 
            text-decoration: none; 
            font-weight: 600;
            border: none;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
        }
        .btn:hover { 
            background: #0099bb; 
        }
        .btn-disabled { 
            background: #cbd5e1 !important; 
            color: #64748b !important; 
            cursor: not-allowed !important;
            pointer-events: none;
        }
        .back-link {
            display: inline-block;
            margin: 20px 0;
            color: #00AED5;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Menu Keripik Sohibah</h1>
        <p style="text-align: center; color: #64748b; margin-bottom: 40px;">
            Pilihan camilan terbaik untuk menemani harimu
        </p>

        <div class="grid">
            @foreach($products as $product)
                <div class="card">
                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : route('product.image', basename($product->image)) }}" 
                         alt="{{ $product->name }}"
                         onerror="this.src='https://via.placeholder.com/400x300.png?text={{ urlencode($product->name) }}';">
                    
                    <h3>{{ $product->name }}</h3>
                    <p>{{ Str::limit($product->description, 80) }}</p>
                    
                    <div class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    
                    <div class="stock" style="color: {{ $product->stock > 0 ? '#10b981' : '#ef4444' }}">
                        {{ $product->stock > 0 ? '✓ Stok: '.$product->stock : '✕ Stok Habis' }}
                    </div>

                    @if($product->stock > 0)
                        <a href="{{ route('order.create') }}" class="btn">🛒 Pesan Sekarang</a>
                    @else
                        <span class="btn btn-disabled">Stok Habis</span>
                    @endif
                </div>
            @endforeach
        </div>
        
        <div style="text-align: center; margin-top: 40px;">
            <a href="/" style="color: #00AED5; text-decoration: none; font-weight: 600;">← Kembali ke Home</a>
        </div>
    </div>

    <!-- NO JAVASCRIPT AT ALL -->
</body>
</html>
