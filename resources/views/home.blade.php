@extends('layouts.app')

@section('content')
<!-- Hero Section / Home -->
<section id="home" style="position: relative; text-align: center; padding: 12rem 2rem 10rem; overflow: hidden;">
    <!-- Background Elements -->
    <div style="position: absolute; top: -20%; left: 50%; transform: translateX(-50%); width: 600px; height: 600px; background: radial-gradient(circle, rgba(139, 92, 246, 0.15) 0%, rgba(0,0,0,0) 70%); filter: blur(80px); z-index: -1; animation: pulse 6s infinite;"></div>
    
    <div class="reveal">
        <div style="display: inline-block; padding: 0.5rem 1.5rem; background: rgba(139, 92, 246, 0.1); border-radius: 50px; border: 1px solid rgba(139, 92, 246, 0.2); backdrop-filter: blur(10px); margin-bottom: 2rem;">
            <span style="font-weight: 600; color: var(--primary); letter-spacing: 1px; text-transform: uppercase; font-size: 0.9rem;">✨ Since 2025</span>
        </div>
        <h1 style="font-size: clamp(3rem, 8vw, 5rem); margin-bottom: 1.5rem; line-height: 1.1; font-weight: 800;">
            Nikmati <span style="background: linear-gradient(120deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Kerenyahan</span><br>
            Yang <span style="background: linear-gradient(120deg, var(--secondary), var(--primary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Sungguhan</span>
        </h1>
        <p style="font-size: 1.25rem; color: var(--text-muted); margin-bottom: 3rem; max-width: 600px; margin-left: auto; margin-right: auto; line-height: 1.8;">
            Keripik Sohibah hadir dengan cita rasa otentik bumbu rahasia. Dibuat dengan cinta untuk menemani setiap momen santai Anda.
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="#menu" class="btn" style="padding: 16px 48px; font-size: 1.1rem; box-shadow: 0 10px 30px -10px rgba(139, 92, 246, 0.4);">Pesan Sekarang</a>
            <a href="#testimonials" class="btn" style="padding: 16px 48px; font-size: 1.1rem; background: transparent; border: 2px solid var(--primary); color: var(--primary); box-shadow: none;">Kata Mereka</a>
        </div>
    </div>
</section>

<!-- Layanan Tambahan (Moved Up) -->
<section class="container reveal" style="margin-top: -5rem; padding-top: 0;">
    <div class="glass-panel" style="padding: 2rem; display: flex; justify-content: space-around; flex-wrap: wrap; gap: 2rem; align-items: center; border-radius: 24px; position: relative; z-index: 10;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 50px; height: 50px; background: rgba(139, 92, 246, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--primary);">🚀</div>
            <div>
                <h4 style="margin:0;">Pengiriman Cepat</h4>
                <small style="color: var(--text-muted);">Aman sampai tujuan</small>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 50px; height: 50px; background: rgba(59, 130, 246, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--secondary);">💯</div>
            <div>
                <h4 style="margin:0;">Rasa Premium</h4>
                <small style="color: var(--text-muted);">Bumbu rempah asli</small>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 50px; height: 50px; background: rgba(59, 130, 246, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--secondary);">🛡️</div>
            <div>
                <h4 style="margin:0;">Halal & Higienis</h4>
                <small style="color: var(--text-muted);">Terjamin kualitasnya</small>
            </div>
        </div>
    </div>
</section>

<!-- Daftar Menu Section -->
<section id="menu" class="container reveal" style="padding-top: 5rem;">
    <div style="text-align: center; margin-bottom: 4rem;">
        <span style="color: var(--secondary); font-weight: bold; letter-spacing: 1px;">OUR MENU</span>
        <h1 style="font-size: 2.5rem; margin-top: 0.5rem;">Pilihan Favorit</h1>
    </div>
    
    <div class="grid" id="productGrid">
        @foreach($products as $index => $product)
            <div class="card glass-panel product-item {{ $index >= 3 ? 'hidden-product' : '' }}" style="{{ $index >= 3 ? 'display: none;' : '' }}; position: relative; overflow: visible;">
                
                @if($index === 0)
                    <div style="position: absolute; top: -10px; right: -10px; background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 5px 15px; border-radius: 20px; font-weight: bold; font-size: 0.8rem; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.4); z-index: 5;">
                        👑 Best Seller
                    </div>
                @endif

                <div style="position: relative; overflow: hidden; border-radius: 16px; margin-bottom: 1.5rem; height: 220px; background: rgba(0,0,0,0.05);">
                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : route('product.image', basename($product->image)) }}" 
                         alt="{{ $product->name }}" 
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300.png?text={{ urlencode($product->name) }}';">
                </div>
                
                <h3>{{ $product->name }}</h3>
                <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; flex: 1;">{{ $product->description }}</p>
                <div class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                
                <div style="margin-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1rem;">
                    <div style="font-size: 0.85rem; margin-bottom: 10px; display: flex; align-items: center; gap: 5px; color: {{ $product->stock > 0 ? 'var(--text-main)' : '#ef4444' }}">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: {{ $product->stock > 0 ? 'var(--primary)' : '#ef4444' }}; display: inline-block;"></span>
                        {{ $product->stock > 0 ? 'Stok Tersedia: '.$product->stock : 'Stok Habis' }}
                    </div>

                    @if($product->stock > 0)
                        <a href="{{ route('order.create') }}" class="btn" style="width: 100%; text-align: center;">Pesan Sekarang</a>
                    @else
                        <button class="btn" style="width: 100%; text-align: center; background: #334155; cursor: not-allowed; box-shadow: none; filter: grayscale(1);" disabled>Stok Habis</button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    @if($products->count() > 3)
        <div style="text-align: center; margin-top: 3rem;">
            <button id="loadMoreBtn" onclick="toggleProducts()" class="btn" style="background: transparent; border: 1px solid rgba(255,255,255,0.2); color: white;">
                Lihat Menu Lainnya ⬇
            </button>
        </div>
    @endif
    
    <script>
        function toggleProducts() {
            const hiddenItems = document.querySelectorAll('.hidden-product');
            const btn = document.getElementById('loadMoreBtn');
            const isHidden = hiddenItems[0].style.display === 'none';
            
            hiddenItems.forEach(item => {
                if(isHidden) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
            
            if(isHidden) {
                btn.innerHTML = 'Tutup Menu ⬆';
            } else {
                btn.innerHTML = 'Lihat Menu Lainnya ⬇';
                document.getElementById('menu').scrollIntoView({behavior: 'smooth'});
            }
        }
    </script>
    
    <!-- Other Services (Pulsa/Galon) -->
    <div style="margin-top: 5rem;" class="reveal">
         <h4 style="text-align: center; margin-bottom: 2rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Kebutuhan Lainnya</h4>
         <div style="display: flex; justify-content: center; gap: 1.5rem; flex-wrap: wrap;">
            <div class="glass-panel" style="padding: 1.5rem 2rem; border-radius: 16px; display: flex; align-items: center; gap: 1rem; flex: 1; min-width: 250px; max-width: 350px;">
                <div style="font-size: 2rem;">⚡</div>
                <div>
                    <strong>Isi Pulsa & Data</strong>
                    <div style="font-size: 0.8rem; color: var(--text-muted);">All Operator 24 Jam</div>
                </div>
            </div>
            <div class="glass-panel" style="padding: 1.5rem 2rem; border-radius: 16px; display: flex; align-items: center; gap: 1rem; flex: 1; min-width: 250px; max-width: 350px;">
                <div style="font-size: 2rem;">💧</div>
                <div>
                    <strong>Galon Mineral</strong>
                    <div style="font-size: 0.8rem; color: var(--text-muted);">Layanan Antar Jemput</div>
                </div>
            </div>
            <div class="glass-panel" style="padding: 1.5rem 2rem; border-radius: 16px; display: flex; align-items: center; gap: 1rem; flex: 1; min-width: 250px; max-width: 350px;">
                <div style="font-size: 2rem;">🔥</div>
                <div>
                    <strong>Gas LPG</strong>
                    <div style="font-size: 0.8rem; color: var(--text-muted);">Sedia 3Kg & 12Kg</div>
                </div>
            </div>
         </div>
    </div>
</section>

<!-- Testimoni Section -->
<section id="testimonials" class="container reveal" style="padding-top: 5rem;">
    <h1 style="text-align: center; margin-bottom: 1rem;">Kata Mereka</h1>
    <p style="text-align: center; color: var(--text-muted); margin-bottom: 3rem;">Pengalaman pelanggan setia Keripik Sohibah</p>

    <div class="grid">
        @foreach($testimonials as $testi)
            <div class="card glass-panel" style="background: linear-gradient(145deg, rgba(30,41,59,0.7), rgba(15,23,42,0.8));">
                 <div style="color: #fbbf24; margin-bottom: 1rem; font-size: 1.2rem;">
                    @for($i=0; $i<$testi->rating; $i++) ★ @endfor
                </div>
                <p style="font-style: italic; font-size: 1.05rem; line-height: 1.6; margin-bottom: 1.5rem;">"{{ $testi->content }}"</p>
                <div style="margin-top: auto; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1rem;">
                    <div style="font-weight: bold; color: var(--text-main);">{{ $testi->customer_name }}</div>
                    <small style="color: var(--text-muted);">{{ $testi->created_at->format('d M Y') }}</small>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="glass-panel" style="padding: 3rem; margin-top: 4rem; max-width: 700px; margin-left: auto; margin-right: auto;">
        <h3 style="text-align: center; margin-bottom: 1.5rem;">Bagikan Pengalaman Anda</h3>
        <form action="{{ route('testimonials.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label>Nama</label>
                    <input type="text" name="customer_name" required placeholder="Nama Anda" style="width: 100%;">
                </div>
                <div>
                    <label>Rating</label>
                    <select name="rating" required style="width: 100%; height: 50px;">
                        <option value="5">⭐⭐⭐⭐⭐ (Sempurna)</option>
                        <option value="4">⭐⭐⭐⭐ (Puas)</option>
                        <option value="3">⭐⭐⭐ (Cukup)</option>
                        <option value="2">⭐⭐ (Kurang)</option>
                        <option value="1">⭐ (Kecewa)</option>
                    </select>
                </div>
            </div>
            
            <label>Ulasan</label>
            <textarea name="content" rows="3" required placeholder="Ceritakan pengalaman Anda di sini..."></textarea>
            
            <button type="submit" class="btn" style="width: 100%;">Kirim Testimoni</button>
        </form>
    </div>
</section>

<!-- Mitra Section -->
<section id="mitra" class="container reveal" style="padding-top: 5rem;">
    <h1 style="text-align: center; margin-bottom: 1rem;">Lokasi Mitra</h1>
    <p style="text-align: center; color: var(--text-muted); margin-bottom: 3rem;">Jaringan distribusi kami</p>

    <div class="grid">
        @forelse($partners as $partner)
            <div class="card glass-panel" style="align-items: center; text-align: center;">
                <div style="width: 60px; height: 60px; background: rgba(59, 130, 246, 0.1); color: var(--secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1rem;">
                    📍
                </div>
                <h3>{{ $partner->name }}</h3>
                <p style="color: var(--text-muted); margin-bottom: 0.5rem;">{{ $partner->address }}</p>
                <small style="color: var(--secondary); display: block; margin-bottom: 1.5rem;">{{ $partner->info }}</small>
                <a href="https://maps.google.com/?q={{ $partner->latitude }},{{ $partner->longitude }}" target="_blank" class="btn" style="font-size: 0.9rem; padding: 10px 24px;">Buka Maps</a>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 2rem;" class="glass-panel">
                <p>Belum ada mitra terdaftar saat ini.</p>
            </div>
        @endforelse
    </div>
    
    <div style="text-align: center; margin-top: 3rem;">
        <p style="color: var(--text-muted); margin-bottom: 1rem;">Ingin menjadi bagian dari kami?</p>
        <a href="#contact" style="color: var(--primary); font-weight: bold; text-decoration: none;">Hubungi Admin &rarr;</a>
    </div>
</section>

<!-- Kontak Kami Section -->
<section id="contact" class="container reveal" style="padding: 5rem 1.5rem;">
    <!-- Section Header -->
    <div style="text-align: center; margin-bottom: 3rem;">
        <div style="display: inline-block; padding: 0.5rem 1.5rem; background: rgba(59, 130, 246, 0.1); border-radius: 50px; border: 1px solid rgba(59, 130, 246, 0.2); backdrop-filter: blur(10px); margin-bottom: 1rem;">
            <span style="font-weight: 600; color: var(--secondary); letter-spacing: 1px; text-transform: uppercase; font-size: 0.85rem;">💬 Hubungi Kami</span>
        </div>
        <h1 style="font-size: clamp(2.5rem, 5vw, 3.5rem); margin-bottom: 0.75rem; background: linear-gradient(120deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Mari Terhubung</h1>
        <p style="color: var(--text-muted); font-size: 1.05rem; max-width: 600px; margin: 0 auto;">Kami siap mendengar masukan dan pertanyaan Anda</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 450px), 1fr)); gap: 2rem; max-width: 1100px; margin: 0 auto;">
        <!-- Contact Form -->
        <div class="glass-panel" style="padding: 2rem; background: linear-gradient(145deg, rgba(30,41,59,0.8), rgba(15,23,42,0.9)); border: 1px solid rgba(139, 92, 246, 0.2); position: relative; overflow: hidden;">
            <!-- Decorative Background -->
            <div style="position: absolute; top: -30%; right: -30%; width: 250px; height: 250px; background: radial-gradient(circle, rgba(139, 92, 246, 0.1) 0%, rgba(0,0,0,0) 70%); filter: blur(60px); z-index: 0;"></div>
            
            <div style="position: relative; z-index: 1;">
                <!-- Form Header - Centered -->
                <div style="margin-bottom: 2rem; text-align: center;">
                    <div style="width: 56px; height: 56px; background: linear-gradient(135deg, var(--primary), var(--secondary)); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                    <h3 style="margin: 0 0 0.5rem 0; font-size: 1.5rem; font-weight: 700;">Kirim Pesan</h3>
                    <p style="color: var(--text-muted); margin: 0; font-size: 0.875rem;">Isi form di bawah ini</p>
                </div>

                <form action="{{ route('contact.store') }}" method="POST" id="contactForm">
                    @csrf
                    
                    <!-- Name Input -->
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; color: var(--text-main); font-size: 0.9rem; font-weight: 600; margin-bottom: 0.5rem; text-align: left;">Nama</label>
                        <div style="position: relative;">
                            <svg style="position: absolute; left: 1rem; top: 0.875rem; pointer-events: none; z-index: 2;" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <input type="text" name="name" required 
                                   style="width: 100%; padding: 0.875rem 1rem 0.875rem 2.75rem; background: rgba(15, 23, 42, 0.5); border: 1.5px solid rgba(139, 92, 246, 0.3); border-radius: 10px; color: white; font-size: 0.95rem; transition: all 0.3s ease; outline: none;"
                                   placeholder="Nama Lengkap"
                                   onfocus="this.style.borderColor='var(--primary)'; this.style.background='rgba(15, 23, 42, 0.8)'; this.style.boxShadow='0 4px 12px rgba(139, 92, 246, 0.2)';"
                                   onblur="this.style.borderColor='rgba(139, 92, 246, 0.3)'; this.style.background='rgba(15, 23, 42, 0.5)'; this.style.boxShadow='none';">
                        </div>
                    </div>
                    
                    <!-- Email Input -->
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; color: var(--text-main); font-size: 0.9rem; font-weight: 600; margin-bottom: 0.5rem; text-align: left;">Email</label>
                        <div style="position: relative;">
                            <svg style="position: absolute; left: 1rem; top: 0.875rem; pointer-events: none; z-index: 2;" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--secondary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                            <input type="email" name="email" 
                                   style="width: 100%; padding: 0.875rem 1rem 0.875rem 2.75rem; background: rgba(15, 23, 42, 0.5); border: 1.5px solid rgba(59, 130, 246, 0.3); border-radius: 10px; color: white; font-size: 0.95rem; transition: all 0.3s ease; outline: none;"
                                   placeholder="email@contoh.com"
                                   onfocus="this.style.borderColor='var(--secondary)'; this.style.background='rgba(15, 23, 42, 0.8)'; this.style.boxShadow='0 4px 12px rgba(59, 130, 246, 0.2)';"
                                   onblur="this.style.borderColor='rgba(59, 130, 246, 0.3)'; this.style.background='rgba(15, 23, 42, 0.5)'; this.style.boxShadow='none';">
                        </div>
                    </div>
                    
                    <!-- Phone Input -->
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; color: var(--text-main); font-size: 0.9rem; font-weight: 600; margin-bottom: 0.5rem; text-align: left;">No. HP (WhatsApp)</label>
                        <div style="position: relative;">
                            <svg style="position: absolute; left: 1rem; top: 0.875rem; pointer-events: none; z-index: 2;" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#25D366" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            <input type="text" name="phone" 
                                   style="width: 100%; padding: 0.875rem 1rem 0.875rem 2.75rem; background: rgba(15, 23, 42, 0.5); border: 1.5px solid rgba(37, 211, 102, 0.3); border-radius: 10px; color: white; font-size: 0.95rem; transition: all 0.3s ease; outline: none;"
                                   placeholder="08..."
                                   onfocus="this.style.borderColor='#25D366'; this.style.background='rgba(15, 23, 42, 0.8)'; this.style.boxShadow='0 4px 12px rgba(37, 211, 102, 0.2)';"
                                   onblur="this.style.borderColor='rgba(37, 211, 102, 0.3)'; this.style.background='rgba(15, 23, 42, 0.5)'; this.style.boxShadow='none';">
                        </div>
                    </div>
                    
                    <!-- Message Textarea -->
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; color: var(--text-main); font-size: 0.9rem; font-weight: 600; margin-bottom: 0.5rem; text-align: left;">Pesan</label>
                        <div style="position: relative;">
                            <svg style="position: absolute; left: 1rem; top: 0.875rem; pointer-events: none; z-index: 2;" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                            <textarea name="message" rows="4" required
                                      style="width: 100%; padding: 0.875rem 1rem 0.875rem 2.75rem; background: rgba(15, 23, 42, 0.5); border: 1.5px solid rgba(139, 92, 246, 0.3); border-radius: 10px; color: white; font-size: 0.95rem; transition: all 0.3s ease; outline: none; resize: vertical; font-family: inherit; min-height: 100px;"
                                      placeholder="Tulis pesan Anda..."
                                      onfocus="this.style.borderColor='var(--primary)'; this.style.background='rgba(15, 23, 42, 0.8)'; this.style.boxShadow='0 4px 12px rgba(139, 92, 246, 0.2)';"
                                      onblur="this.style.borderColor='rgba(139, 92, 246, 0.3)'; this.style.background='rgba(15, 23, 42, 0.5)'; this.style.boxShadow='none';"></textarea>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="btn" 
                            style="width: 100%; padding: 1rem; font-size: 1.05rem; font-weight: 600; background: linear-gradient(135deg, var(--primary), var(--secondary)); border: none; border-radius: 10px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3); display: flex; align-items: center; justify-content: center; gap: 0.5rem;"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(139, 92, 246, 0.4)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(139, 92, 246, 0.3)';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                        Kirim Pesan
                    </button>

                    <!-- Info Text -->
                    <div style="margin-top: 1rem; text-align: center; padding-top: 1rem; border-top: 1px solid rgba(139, 92, 246, 0.15);">
                        <small style="color: var(--text-muted); font-size: 0.85rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            Pesan Anda akan kami balas dalam 1x24 jam
                        </small>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Location & Social Media -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Location Card -->
            <div class="glass-panel" style="padding: 2rem; background: linear-gradient(145deg, rgba(30,41,59,0.8), rgba(15,23,42,0.9)); border: 1px solid rgba(59, 130, 246, 0.2);">
                <!-- Location Header -->
                <div style="margin-bottom: 1.5rem; text-align: center;">
                    <div style="width: 56px; height: 56px; background: linear-gradient(135deg, var(--secondary), var(--primary)); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1rem;">📍</div>
                    <h3 style="margin: 0 0 0.5rem 0; font-size: 1.5rem; font-weight: 700;">Lokasi Toko</h3>
                    <p style="color: var(--text-muted); margin: 0; font-size: 0.9rem;">Kunjungi kami langsung</p>
                </div>

                <!-- Google Maps -->
                <div style="border-radius: 12px; overflow: hidden; background: #1e293b; border: 2px solid rgba(59, 130, 246, 0.3); box-shadow: 0 4px 12px rgba(0,0,0,0.3); margin-bottom: 1.5rem; height: 220px;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d506230.08700194274!2d109.63464843323553!3d-7.5834090127458245!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7abe05aaaaaaab%3A0x62a8dd962c4d3cd1!2sMASJID%20ASSU&#39;ADA!5e0!3m2!1sid!2sid!4v1767864667040!5m2!1sid!2sid" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <!-- Contact Info Cards -->
                <div style="display: grid; gap: 0.75rem;">
                    <div style="padding: 1rem; background: rgba(139, 92, 246, 0.08); border-radius: 10px; border: 1px solid rgba(139, 92, 246, 0.2); display: flex; align-items: center; gap: 1rem; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(139, 92, 246, 0.12)'; this.style.transform='translateX(4px)';" onmouseout="this.style.background='rgba(139, 92, 246, 0.08)'; this.style.transform='translateX(0)';">
                        <div style="font-size: 1.5rem; flex-shrink: 0;">📞</div>
                        <div style="flex: 1;">
                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Telepon</div>
                            <div style="font-weight: 600; font-size: 1rem; color: var(--text-main);">+62 856-4352-7635</div>
                        </div>
                    </div>
                    <div style="padding: 1rem; background: rgba(59, 130, 246, 0.08); border-radius: 10px; border: 1px solid rgba(59, 130, 246, 0.2); display: flex; align-items: center; gap: 1rem; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(59, 130, 246, 0.12)'; this.style.transform='translateX(4px)';" onmouseout="this.style.background='rgba(59, 130, 246, 0.08)'; this.style.transform='translateX(0)';">
                        <div style="font-size: 1.5rem; flex-shrink: 0;">⏰</div>
                        <div style="flex: 1;">
                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Jam Operasional</div>
                            <div style="font-weight: 600; font-size: 1rem; color: var(--text-main);">Setiap Hari, 08:00 - 20:00</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Card -->
            <div class="glass-panel" style="padding: 2rem; background: linear-gradient(145deg, rgba(30,41,59,0.8), rgba(15,23,42,0.9)); border: 1px solid rgba(139, 92, 246, 0.2); text-align: center;">
                <h4 style="margin-bottom: 1.25rem; font-size: 1.15rem; font-weight: 700;">
                    <span style="background: linear-gradient(120deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        Temukan Kami di Sosial Media
                    </span>
                </h4>
                <div style="display: flex; gap: 1rem; align-items: center; justify-content: center; flex-wrap: wrap; margin-bottom: 1rem;">
                    <!-- Instagram -->
                    <a href="https://instagram.com/sohibah" target="_blank" 
                       style="width: 54px; height: 54px; background: linear-gradient(135deg, #f09433, #bc1888); border-radius: 13px; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(240, 148, 51, 0.3);" 
                       onmouseover="this.style.transform='translateY(-4px) scale(1.08)'; this.style.boxShadow='0 8px 20px rgba(240, 148, 51, 0.5)';" 
                       onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 12px rgba(240, 148, 51, 0.3)';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/6285643527635" target="_blank" 
                       style="width: 54px; height: 54px; background: linear-gradient(135deg, #25D366, #128C7E); border-radius: 13px; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);" 
                       onmouseover="this.style.transform='translateY(-4px) scale(1.08)'; this.style.boxShadow='0 8px 20px rgba(37, 211, 102, 0.5)';" 
                       onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 12px rgba(37, 211, 102, 0.3)';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </a>

                    <!-- Facebook -->
                    <a href="https://facebook.com/sohibah" target="_blank" 
                       style="width: 54px; height: 54px; background: linear-gradient(135deg, #1877F2, #0d5dbf); border-radius: 13px; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(24, 119, 242, 0.3);" 
                       onmouseover="this.style.transform='translateY(-4px) scale(1.08)'; this.style.boxShadow='0 8px 20px rgba(24, 119, 242, 0.5)';" 
                       onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 12px rgba(24, 119, 242, 0.3)';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                </div>
                <p style="margin: 0; color: var(--text-muted); font-size: 0.85rem; line-height: 1.5;">
                    Follow untuk update produk terbaru! 🎉
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
