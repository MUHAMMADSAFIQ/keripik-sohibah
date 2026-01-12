@extends('layouts.app')

@section('content')
<section class="container" style="padding-top: 8rem; padding-bottom: 5rem;">
    <!-- Hero Header -->
    <div style="text-align: center; margin-bottom: 4rem; position: relative;" class="reveal">
        <div style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); width: 100px; height: 100px; background: radial-gradient(circle, rgba(0,174,213,0.2), transparent); filter: blur(40px); z-index: -1;"></div>
        <span style="color: var(--secondary); font-weight: bold; letter-spacing: 2px; text-transform: uppercase; font-size: 0.85rem; display: inline-block; padding: 8px 20px; background: rgba(0,170,19,0.1); border-radius: 50px; margin-bottom: 1rem;">🌟 Our Premium Products</span>
        <h1 style="font-size: 3.5rem; margin-top: 0.5rem; background: linear-gradient(120deg, var(--primary), var(--secondary), #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 900; letter-spacing: -1px;">Daftar Menu Lezat</h1>
        <p style="color: var(--text-muted); max-width: 650px; margin: 1.5rem auto; font-size: 1.15rem; line-height: 1.7;">Pilihan camilan terbaik untuk menemani harimu. Dijamin renyah, gurih, dan bikin nagih! 🎉</p>
    </div>

    <!-- Category Tabs -->
    <div style="display: flex; justify-content: center; gap: 1rem; margin-bottom: 3rem; flex-wrap: wrap;" class="reveal">
        <button onclick="filterByCategory('all')" class="category-tab active" data-category="all" style="padding: 12px 28px; border-radius: 50px; border: 2px solid var(--glass-border); background: var(--primary); color: white; font-weight: 700; cursor: pointer; transition: all 0.3s;">
            Semua Produk
        </button>
        <button onclick="filterByCategory('keripik')" class="category-tab" data-category="keripik" style="padding: 12px 28px; border-radius: 50px; border: 2px solid var(--glass-border); background: transparent; color: var(--text-main); font-weight: 700; cursor: pointer; transition: all 0.3s;">
            🥔 Keripik
        </button>
        <button onclick="filterByCategory('minuman')" class="category-tab" data-category="minuman" style="padding: 12px 28px; border-radius: 50px; border: 2px solid var(--glass-border); background: transparent; color: var(--text-main); font-weight: 700; cursor: pointer; transition: all 0.3s;">
            🥤 Minuman
        </button>
    </div>

    <!-- Advanced Filter Bar -->
    <div class="glass-panel reveal" style="padding: 2rem; margin-bottom: 3rem; border-radius: 24px; box-shadow: 0 8px 32px rgba(0,0,0,0.08);">
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 1.5rem; align-items: end;">
            <!-- Search -->
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main); font-size: 0.9rem;">🔍 Cari Produk</label>
                <input type="text" id="searchInput" placeholder="Ketik nama produk..." 
                       style="width: 100%; padding: 14px 18px; border-radius: 12px; border: 2px solid var(--glass-border); background: var(--glass); font-size: 1rem; transition: border-color 0.3s;"
                       onfocus="this.style.borderColor='var(--primary)'"
                       onblur="this.style.borderColor='var(--glass-border)'"
                       onkeyup="filterProducts()">
            </div>
            
            <!-- Price Range -->
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main); font-size: 0.9rem;">💰 Harga Max</label>
                <input type="range" id="priceRange" min="0" max="50000" value="50000" step="1000"
                       style="width: 100%; accent-color: var(--primary);"
                       oninput="updatePriceLabel(); filterProducts()">
                <div style="text-align: center; margin-top: 5px; font-weight: 700; color: var(--primary);" id="priceLabel">Rp 50.000</div>
            </div>
            
            <!-- Sort -->
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main); font-size: 0.9rem;">📊 Urutkan</label>
                <select id="sortFilter" onchange="filterProducts()" 
                        style="width: 100%; padding: 14px 18px; border-radius: 12px; border: 2px solid var(--glass-border); background: var(--glass); font-size: 1rem; cursor: pointer;">
                    <option value="default">Default</option>
                    <option value="price-low">Harga ↑</option>
                    <option value="price-high">Harga ↓</option>
                    <option value="name">Nama A-Z</option>
                    <option value="stock">Stok Banyak</option>
                </select>
            </div>
        </div>
        
        <!-- Filter Summary -->
        <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--glass-border); display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; gap: 10px; align-items: center;">
                <span style="font-size: 0.9rem; color: var(--text-muted);">Menampilkan:</span>
                <span id="productCount" style="font-weight: 800; color: var(--primary); font-size: 1.1rem;">{{ $products->count() }}</span>
                <span style="font-size: 0.9rem; color: var(--text-muted);">produk</span>
            </div>
            <button onclick="resetFilters()" style="padding: 8px 20px; border-radius: 8px; border: 1px solid var(--glass-border); background: transparent; color: var(--text-muted); cursor: pointer; font-weight: 600; transition: all 0.2s;"
                    onmouseover="this.style.background='var(--glass-border)'"
                    onmouseout="this.style.background='transparent'">
                🔄 Reset Filter
            </button>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid reveal" id="productsGrid" style="margin-bottom: 5rem; position: relative;">
        @foreach($products as $product)
            <div class="glass-panel product-item" 
                 data-product-id="{{ $product->id }}"
                 data-name="{{ strtolower($product->name) }}"
                 data-category="{{ $product->category }}"
                 data-price="{{ $product->price }}"
                 data-stock="{{ $product->stock }}"
                 style="padding: 0; border-radius: 24px; display: flex; flex-direction: column; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); overflow: hidden; position: relative;"
                 onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.12)'"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0, 0, 0, 0.05)'">
                 
                <!-- Product Badge -->
                @if($loop->first)
                    <div class="product-badge badge-bestseller" style="position: absolute; top: 15px; right: 15px; z-index: 10;">
                        👑 Best Seller
                    </div>
                @elseif($product->created_at->diffInDays(now()) < 7)
                    <div class="product-badge badge-new" style="position: absolute; top: 15px; right: 15px; z-index: 10;">
                        ✨ Baru
                    </div>
                @endif
                
                <!-- Image Container -->
                <div style="position: relative; overflow: hidden; height: 240px; background: linear-gradient(135deg, rgba(0,174,213,0.05), rgba(0,170,19,0.05));">
                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : route('product.image', basename($product->image)) }}" 
                         alt="{{ $product->name }}" 
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);"
                         onmouseover="this.style.transform='scale(1.08)'"
                         onmouseout="this.style.transform='scale(1)'"
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300.png?text={{ urlencode($product->name) }}';">
                    
                    <!-- Quick View Button -->
                    <button onclick="openQuickView({{ $product->id }}, '{{ $product->name }}', '{{ $product->description }}', {{ $product->price }}, {{ $product->stock }})" 
                            style="position: absolute; bottom: 15px; right: 15px; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border: none; border-radius: 50%; width: 45px; height: 45px; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.15); opacity: 0; transition: opacity 0.3s, transform 0.3s; font-size: 1.2rem;"
                            onmouseover="this.style.transform='scale(1.1)'; this.parentElement.parentElement.querySelector('img').style.transform='scale(1.08)'; this.style.opacity='1'"
                            onmouseout="this.style.transform='scale(1)'"
                            class="quick-view-btn">
                        👁️
                    </button>
                </div>
                
                <!-- Product Info -->
                <div style="padding: 1.5rem; flex: 1; display: flex; flex-direction: column;">
                    <h3 style="font-size: 1.3rem; margin-bottom: 0.75rem; font-weight: 800; color: var(--text-main); line-height: 1.3;">{{ $product->name }}</h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; flex: 1; margin-bottom: 1.5rem;">{{ Str::limit($product->description, 85) }}</p>
                    
                    <!-- Price & Stock -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; padding: 12px; background: rgba(0,174,213,0.05); border-radius: 12px;">
                        <div>
                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 2px; font-weight: 600;">HARGA</div>
                            <div class="price" style="font-size: 1.5rem; color: var(--primary); font-weight: 900; letter-spacing: -0.5px;">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 2px; font-weight: 600;">STOK</div>
                            <div style="font-size: 0.95rem; display: flex; align-items: center; gap: 6px; color: {{ $product->stock > 0 ? '#10b981' : '#ef4444' }}; font-weight: 700;">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: {{ $product->stock > 0 ? '#10b981' : '#ef4444' }}; display: inline-block; box-shadow: 0 0 8px {{ $product->stock > 0 ? '#10b981' : '#ef4444' }};"></span>
                                {{ $product->stock > 0 ? $product->stock : 'Habis' }}
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @if($product->stock > 0)
                        <div style="display: grid; grid-template-columns: 1fr auto; gap: 10px;">
                            <a href="{{ route('order.create') }}" class="btn" style="text-align: center; border-radius: 14px; padding: 14px; transition: all 0.3s; font-weight: 700; font-size: 0.95rem; box-shadow: 0 4px 12px rgba(0,174,213,0.3);"
                               onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0,174,213,0.4)'"
                               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0,174,213,0.3)'">
                                🛒 Pesan
                            </a>
                            <button class="btn" style="background: transparent; border: 2px solid var(--glass-border); color: var(--text-main); padding: 14px 18px; border-radius: 14px; transition: all 0.3s; font-size: 1.2rem;" 
                                    onclick="addToWishlist({{ $product->id }})"
                                    onmouseover="this.style.borderColor='#ef4444'; this.style.color='#ef4444'; this.style.transform='scale(1.1)'"
                                    onmouseout="this.style.borderColor='var(--glass-border)'; this.style.color='var(--text-main)'; this.style.transform='scale(1)'">
                                ❤️
                            </button>
                        </div>
                    @else
                        <button class="btn" style="width: 100%; text-align: center; background: #e2e8f0; color: #94a3b8; cursor: not-allowed; box-shadow: none; border-radius: 14px; pointer-events: none; font-weight: 700;" disabled>
                            ❌ Stok Habis
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- No Results Message -->
    <div id="noResults" style="display: none; text-align: center; padding: 5rem 2rem;" class="glass-panel">
        <div style="font-size: 5rem; margin-bottom: 1.5rem; opacity: 0.4;">🔍</div>
        <h3 style="margin-bottom: 0.75rem; font-size: 1.5rem;">Produk tidak ditemukan</h3>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">Coba kata kunci atau filter lain</p>
        <button onclick="resetFilters()" class="btn" style="padding: 12px 30px; border-radius: 50px;">
            🔄 Reset Semua Filter
        </button>
    </div>
    
    <!-- Other Services -->
    <div class="glass-panel reveal" style="padding: 4rem 3rem; text-align: center; border-radius: 28px; position: relative; overflow: hidden; background: linear-gradient(135deg, rgba(0,174,213,0.03), rgba(0,170,19,0.03));">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 6px; background: linear-gradient(90deg, var(--primary), var(--secondary), #f59e0b);"></div>
        <h3 style="margin-bottom: 1.5rem; font-size: 2.2rem; background: linear-gradient(120deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 900;">Layanan & Produk Harian</h3>
        <p style="color: var(--text-muted); margin-bottom: 3.5rem; font-size: 1.05rem;">Kami juga menyediakan kebutuhan rumah tangga Anda dengan harga bersahabat.</p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
            <div class="glass-panel" style="padding: 2.5rem 2rem; border-radius: 24px; transition: all 0.4s;" 
                 onmouseover="this.style.transform='translateY(-12px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.12)'"
                 onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 20px rgba(0, 0, 0, 0.05)'">
                <div style="font-size: 4rem; margin-bottom: 1.25rem; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));">⚡</div>
                <h4 style="margin-bottom: 0.75rem; font-size: 1.2rem; font-weight: 800;">Pulsa & Data</h4>
                <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.6;">All Operator, 24 Jam Online</p>
            </div>
            <div class="glass-panel" style="padding: 2.5rem 2rem; border-radius: 24px; transition: all 0.4s;" 
                 onmouseover="this.style.transform='translateY(-12px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.12)'"
                 onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 20px rgba(0, 0, 0, 0.05)'">
                <div style="font-size: 4rem; margin-bottom: 1.25rem; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));">💧</div>
                <h4 style="margin-bottom: 0.75rem; font-size: 1.2rem; font-weight: 800;">Galon Mineral</h4>
                <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.6;">Antar Jemput Sampai Dapur</p>
            </div>
            <div class="glass-panel" style="padding: 2.5rem 2rem; border-radius: 24px; transition: all 0.4s;" 
                 onmouseover="this.style.transform='translateY(-12px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.12)'"
                 onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 20px rgba(0, 0, 0, 0.05)'">
                <div style="font-size: 4rem; margin-bottom: 1.25rem; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));">🔥</div>
                <h4 style="margin-bottom: 0.75rem; font-size: 1.2rem; font-weight: 800;">Gas LPG</h4>
                <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.6;">Sedia 3Kg (Melon) & 12Kg</p>
            </div>
        </div>
        
        <a href="https://wa.me/6285643527635?text=Halo%20Admin,%20saya%20mau%20pesan%20pulsa/galon/gas" target="_blank" class="btn" 
           style="background: #25D366; color: white; padding: 16px 40px; border-radius: 50px; display: inline-flex; align-items: center; gap: 10px; font-size: 1.05rem; font-weight: 700; box-shadow: 0 8px 24px rgba(37,211,102,0.3); transition: all 0.3s;"
           onmouseover="this.style.transform='translateY(-3px) scale(1.05)'; this.style.boxShadow='0 12px 32px rgba(37,211,102,0.4)'"
           onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 8px 24px rgba(37,211,102,0.3)'">
            <span style="font-size: 1.4rem;">📞</span> Pesan via WhatsApp
        </a>
    </div>
</section>

<!-- Quick View Modal -->
<div id="quickViewModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.75); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(8px); padding: 20px;" onclick="closeQuickView()">
    <div class="glass-panel" style="max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto; border-radius: 28px; padding: 0; box-shadow: 0 25px 50px rgba(0,0,0,0.3); animation: modalSlideIn 0.3s ease-out;" onclick="event.stopPropagation()">
        <div style="padding: 2rem; border-bottom: 1px solid var(--glass-border); display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, rgba(0,174,213,0.05), rgba(0,170,19,0.05));">
            <h2 id="modalTitle" style="margin: 0; font-size: 1.8rem; font-weight: 900;">Product Detail</h2>
            <button onclick="closeQuickView()" style="background: none; border: none; font-size: 2.5rem; cursor: pointer; color: var(--text-muted); transition: all 0.2s; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;"
                    onmouseover="this.style.background='rgba(0,0,0,0.05)'; this.style.transform='rotate(90deg)'"
                    onmouseout="this.style.background='none'; this.style.transform='rotate(0)'">
                ×
            </button>
        </div>
        <div id="modalContent" style="padding: 2rem;"></div>
    </div>
</div>

<style>
@keyframes modalSlideIn {
    from { transform: translateY(-50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.product-item:hover .quick-view-btn {
    opacity: 1 !important;
}

.category-tab:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.category-tab.active {
    background: var(--primary) !important;
    color: white !important;
    border-color: var(--primary) !important;
}
</style>

<script>
let currentCategory = 'all';

function filterByCategory(category) {
    currentCategory = category;
    
    // Update tab styles
    document.querySelectorAll('.category-tab').forEach(tab => {
        if (tab.dataset.category === category) {
            tab.classList.add('active');
            tab.style.background = 'var(--primary)';
            tab.style.color = 'white';
            tab.style.borderColor = 'var(--primary)';
        } else {
            tab.classList.remove('active');
            tab.style.background = 'transparent';
            tab.style.color = 'var(--text-main)';
            tab.style.borderColor = 'var(--glass-border)';
        }
    });
    
    filterProducts();
}

function updatePriceLabel() {
    const price = document.getElementById('priceRange').value;
    document.getElementById('priceLabel').textContent = 'Rp ' + parseInt(price).toLocaleString('id-ID');
}

function filterProducts() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const maxPrice = parseInt(document.getElementById('priceRange').value);
    const sortBy = document.getElementById('sortFilter').value;
    const products = Array.from(document.querySelectorAll('.product-item'));
    
    let visibleCount = 0;
    let filteredProducts = [];
    
    products.forEach(product => {
        const name = product.dataset.name;
        const category = product.dataset.category;
        const price = parseInt(product.dataset.price);
        
        const matchesSearch = name.includes(searchTerm);
        const matchesCategory = currentCategory === 'all' || category === currentCategory;
        const matchesPrice = price <= maxPrice;
        
        if (matchesSearch && matchesCategory && matchesPrice) {
            product.style.display = 'flex';
            visibleCount++;
            filteredProducts.push(product);
        } else {
            product.style.display = 'none';
        }
    });
    
    if (sortBy !== 'default') {
        filteredProducts.sort((a, b) => {
            switch(sortBy) {
                case 'price-low':
                    return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                case 'price-high':
                    return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                case 'name':
                    return a.dataset.name.localeCompare(b.dataset.name);
                case 'stock':
                    return parseInt(b.dataset.stock) - parseInt(a.dataset.stock);
            }
        });
        
        const grid = document.getElementById('productsGrid');
        filteredProducts.forEach(product => grid.appendChild(product));
    }
    
    document.getElementById('productCount').textContent = visibleCount;
    document.getElementById('noResults').style.display = visibleCount === 0 ? 'block' : 'none';
}

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('priceRange').value = 50000;
    document.getElementById('sortFilter').value = 'default';
    updatePriceLabel();
    filterByCategory('all');
}

function openQuickView(id, name, desc, price, stock) {
    const modal = document.getElementById('quickViewModal');
    const content = document.getElementById('modalContent');
    
    content.innerHTML = `
        <h3 style="font-size: 1.5rem; margin-bottom: 1rem; font-weight: 800;">${name}</h3>
        <p style="color: var(--text-muted); line-height: 1.7; margin-bottom: 1.5rem;">${desc}</p>
        <div style="background: rgba(0,174,213,0.05); padding: 1.5rem; border-radius: 16px; margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 5px;">HARGA</div>
                    <div style="font-size: 2rem; color: var(--primary); font-weight: 900;">Rp ${parseInt(price).toLocaleString('id-ID')}</div>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 5px;">STOK</div>
                    <div style="font-size: 1.2rem; color: ${stock > 0 ? '#10b981' : '#ef4444'}; font-weight: 700;">${stock > 0 ? stock + ' Tersedia' : 'Habis'}</div>
                </div>
            </div>
        </div>
        ${stock > 0 ? 
            `<a href="{{ route('order.create') }}" class="btn" style="width: 100%; text-align: center; padding: 16px; border-radius: 14px; font-size: 1.1rem; font-weight: 700;">🛒 Pesan Sekarang</a>` :
            `<button class="btn" style="width: 100%; padding: 16px; background: #e2e8f0; color: #94a3b8; cursor: not-allowed;" disabled>Stok Habis</button>`
        }
    `;
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeQuickView() {
    document.getElementById('quickViewModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function addToWishlist(productId) {
    alert('❤️ Produk ditambahkan ke wishlist!');
}

// Initialize
updatePriceLabel();
</script>
@endsection

<section class="container" style="padding-top: 8rem; padding-bottom: 5rem;">
    <!-- Header Section -->
    <div style="text-align: center; margin-bottom: 4rem;" class="reveal">
        <span style="color: var(--secondary); font-weight: bold; letter-spacing: 1px; text-transform: uppercase; font-size: 0.9rem;">Our Products</span>
        <h1 style="font-size: 3rem; margin-top: 0.5rem; background: linear-gradient(120deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 800;">Daftar Menu Lezat</h1>
        <p style="color: var(--text-muted); max-width: 600px; margin: 1.5rem auto; font-size: 1.1rem;">Pilihan camilan terbaik untuk menemani harimu. Dijamin renyah, gurih, dan bikin nagih!</p>
    </div>

    <!-- Search & Filter Bar -->
    <div class="glass-panel reveal" style="padding: 1.5rem; margin-bottom: 3rem; border-radius: 20px;">
        <div style="display: grid; grid-template-columns: 1fr auto auto; gap: 1rem; align-items: center;">
            <div style="position: relative;">
                <input type="text" id="searchInput" placeholder="🔍 Cari produk..." 
                       style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--glass-border); background: var(--glass);"
                       onkeyup="filterProducts()">
            </div>
            
            <select id="categoryFilter" onchange="filterProducts()" 
                    style="padding: 12px 16px; border-radius: 12px; border: 1px solid var(--glass-border); background: var(--glass); min-width: 150px;">
                <option value="all">Semua Kategori</option>
                <option value="keripik">Keripik</option>
                <option value="minuman">Minuman</option>
            </select>
            
            <select id="sortFilter" onchange="filterProducts()" 
                    style="padding: 12px 16px; border-radius: 12px; border: 1px solid var(--glass-border); background: var(--glass); min-width: 150px;">
                <option value="default">Urutkan</option>
                <option value="price-low">Harga: Rendah-Tinggi</option>
                <option value="price-high">Harga: Tinggi-Rendah</option>
                <option value="name">Nama: A-Z</option>
                <option value="stock">Stok Tersedia</option>
            </select>
        </div>
    </div>

    <!-- Product Count -->
    <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
        <p style="color: var(--text-muted); font-size: 0.9rem;">
            Menampilkan <span id="productCount" style="font-weight: 700; color: var(--primary);">{{ $products->count() }}</span> produk
        </p>
        <button onclick="toggleView()" class="btn" style="padding: 8px 16px; font-size: 0.85rem; background: transparent; border: 1px solid var(--glass-border); color: var(--text-main);">
            <span id="viewIcon">⊞</span> Ubah Tampilan
        </button>
    </div>

    <!-- Products Grid -->
    <div class="grid reveal" id="productsGrid" style="margin-bottom: 5rem;">
        @foreach($products as $product)
            <div class="glass-panel product-item" 
                 data-product-id="{{ $product->id }}"
                 data-name="{{ strtolower($product->name) }}"
                 data-category="{{ $product->category }}"
                 data-price="{{ $product->price }}"
                 data-stock="{{ $product->stock }}"
                 style="padding: 1.5rem; border-radius: 20px; display: flex; flex-direction: column; transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.1)'"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0, 0, 0, 0.05)'">
                 
                <!-- Product Badge -->
                @if($loop->first)
                    <div class="product-badge badge-bestseller">
                        👑 Best Seller
                    </div>
                @elseif($product->created_at->diffInDays(now()) < 7)
                    <div class="product-badge badge-new">
                        ✨ Baru
                    </div>
                @endif
                
                <!-- Image Container -->
                <div style="position: relative; overflow: hidden; border-radius: 16px; margin-bottom: 1.5rem; height: 220px; background: rgba(0,0,0,0.02);">
                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : route('product.image', basename($product->image)) }}" 
                         alt="{{ $product->name }}" 
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
                         onmouseover="this.style.transform='scale(1.05)'"
                         onmouseout="this.style.transform='scale(1)'"
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300.png?text={{ urlencode($product->name) }}';">
                </div>
                
                <!-- Product Info -->
                <div style="flex: 1; display: flex; flex-direction: column;">
                    <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem; font-weight: 700; color: var(--text-main);">{{ $product->name }}</h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; flex: 1; margin-bottom: 1.5rem;">{{ Str::limit($product->description, 80) }}</p>
                    
                    <!-- Price & Stock -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <div class="price" style="font-size: 1.3rem; color: var(--primary); font-weight: 800;">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                        <div style="font-size: 0.85rem; display: flex; align-items: center; gap: 5px; color: {{ $product->stock > 0 ? 'var(--text-main)' : '#ef4444' }}; font-weight: 600;">
                            <span style="width: 8px; height: 8px; border-radius: 50%; background: {{ $product->stock > 0 ? '#10b981' : '#ef4444' }}; display: inline-block;"></span>
                            {{ $product->stock > 0 ? $product->stock.' Tersedia' : 'Habis' }}
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @if($product->stock > 0)
                        <div style="display: grid; grid-template-columns: 1fr auto; gap: 8px;">
                            <a href="{{ route('order.create') }}" class="btn" style="text-align: center; border-radius: 12px; padding: 10px; transition: all 0.2s ease;">
                                🛒 Pesan
                            </a>
                            <button class="btn" style="background: transparent; border: 1px solid var(--glass-border); color: var(--text-main); padding: 10px 16px; border-radius: 12px; transition: all 0.2s ease;" onclick="addToWishlist({{ $product->id }})">
                                ❤️
                            </button>
                        </div>
                    @else
                        <button class="btn" style="width: 100%; text-align: center; background: #334155; cursor: not-allowed; box-shadow: none; filter: grayscale(1); border-radius: 12px; pointer-events: none;" disabled>
                            Stok Habis
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- No Results Message -->
    <div id="noResults" style="display: none; text-align: center; padding: 4rem 2rem;" class="glass-panel">
        <div style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.5;">🔍</div>
        <h3 style="margin-bottom: 0.5rem;">Produk tidak ditemukan</h3>
        <p style="color: var(--text-muted);">Coba kata kunci atau filter lain</p>
    </div>
    
    <!-- Other Products Section -->
    <div class="glass-panel reveal" style="padding: 3rem; text-align: center; border-radius: 24px; position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 5px; background: linear-gradient(90deg, var(--primary), var(--secondary));"></div>
        <h3 style="margin-bottom: 1rem; font-size: 1.8rem; background: linear-gradient(120deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Layanan & Produk Harian</h3>
        <p style="color: var(--text-muted); margin-bottom: 3rem;">Kami juga menyediakan kebutuhan rumah tangga Anda dengan harga bersahabat.</p>
        
        <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
            <div class="glass-panel" style="padding: 2rem; border-radius: 20px; width: 220px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 3rem; margin-bottom: 1rem;">⚡</div>
                <h4 style="margin-bottom: 0.5rem;">Pulsa & Data</h4>
                <p style="font-size: 0.9rem; color: var(--text-muted);">All Operator, 24 Jam Online</p>
            </div>
            <div class="glass-panel" style="padding: 2rem; border-radius: 20px; width: 220px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 3rem; margin-bottom: 1rem;">💧</div>
                <h4 style="margin-bottom: 0.5rem;">Galon Mineral</h4>
                <p style="font-size: 0.9rem; color: var(--text-muted);">Antar Jemput Sampai Dapur</p>
            </div>
            <div class="glass-panel" style="padding: 2rem; border-radius: 20px; width: 220px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🔥</div>
                <h4 style="margin-bottom: 0.5rem;">Gas LPG</h4>
                <p style="font-size: 0.9rem; color: var(--text-muted);">Sedia 3Kg (Melon) & 12Kg</p>
            </div>
        </div>
        
        <div style="margin-top: 3rem;">
             <a href="https://wa.me/6285643527635?text=Halo%20Admin,%20saya%20mau%20pesan%20pulsa/galon/gas" target="_blank" class="btn" style="background: #25D366; color: white; padding: 12px 30px; border-radius: 50px; display: inline-flex; align-items: center; gap: 8px;">
                <span style="font-size: 1.2rem;">📞</span> Pesan via WhatsApp
             </a>
        </div>
    </div>
</section>

<script>
let gridView = true;

function filterProducts() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const category = document.getElementById('categoryFilter').value;
    const sortBy = document.getElementById('sortFilter').value;
    const products = Array.from(document.querySelectorAll('.product-item'));
    
    let visibleCount = 0;
    let filteredProducts = [];
    
    products.forEach(product => {
        const name = product.dataset.name;
        const productCategory = product.dataset.category;
        
        const matchesSearch = name.includes(searchTerm);
        const matchesCategory = category === 'all' || productCategory === category;
        
        if (matchesSearch && matchesCategory) {
            product.style.display = 'flex';
            visibleCount++;
            filteredProducts.push(product);
        } else {
            product.style.display = 'none';
        }
    });
    
    if (sortBy !== 'default') {
        filteredProducts.sort((a, b) => {
            switch(sortBy) {
                case 'price-low':
                    return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                case 'price-high':
                    return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                case 'name':
                    return a.dataset.name.localeCompare(b.dataset.name);
                case 'stock':
                    return parseInt(b.dataset.stock) - parseInt(a.dataset.stock);
            }
        });
        
        const grid = document.getElementById('productsGrid');
        filteredProducts.forEach(product => grid.appendChild(product));
    }
    
    document.getElementById('productCount').textContent = visibleCount;
    document.getElementById('noResults').style.display = visibleCount === 0 ? 'block' : 'none';
}

function toggleView() {
    gridView = !gridView;
    const grid = document.getElementById('productsGrid');
    const icon = document.getElementById('viewIcon');
    
    if (gridView) {
        grid.style.gridTemplateColumns = 'repeat(auto-fit, minmax(300px, 1fr))';
        icon.textContent = '⊞';
    } else {
        grid.style.gridTemplateColumns = '1fr';
        icon.textContent = '▦';
    }
}

function addToWishlist(productId) {
    alert('Produk ditambahkan ke wishlist! ❤️');
}
</script>
@endsection
