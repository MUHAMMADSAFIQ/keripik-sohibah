@extends('layouts.app')

@section('content')
<section class="container" style="min-height: 85vh; padding-top: 6rem; padding-bottom: 4rem;">
    <!-- Animated Background Blobs -->
    <div style="position: fixed; top: 10%; left: 5%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(139, 92, 246, 0.15), transparent); filter: blur(60px); z-index: 0; animation: float 8s ease-in-out infinite;"></div>
    <div style="position: fixed; bottom: 10%; right: 5%; width: 250px; height: 250px; background: radial-gradient(circle, rgba(59, 130, 246, 0.15), transparent); filter: blur(60px); z-index: 0; animation: float 10s ease-in-out infinite reverse;"></div>

    <div class="reveal" style="text-align: center; margin-bottom: 3rem; position: relative; z-index: 1;">
        <div style="display: inline-block; padding: 0.4rem 1.2rem; background: rgba(139, 92, 246, 0.1); border-radius: 50px; border: 1px solid rgba(139, 92, 246, 0.3); backdrop-filter: blur(10px); margin-bottom: 0.8rem; display: flex; align-items: center; gap: 8px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
            </svg>
            <span style="font-weight: 600; color: var(--primary); letter-spacing: 0.5px; text-transform: uppercase; font-size: 0.75rem;">Pesan Sekarang</span>
        </div>
        <h1 style="font-size: clamp(1.8rem, 4vw, 2.5rem); margin-bottom: 0.5rem; background: linear-gradient(135deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 800; letter-spacing: -0.02em;">Form Pemesanan</h1>
        <p style="color: var(--text-muted); font-size: 1rem; max-width: 600px; margin: 0 auto;">Isi data diri dan pilih menu favorit Anda dengan mudah</p>
    </div>
    
    <div class="glass-panel glass-panel-order reveal" style="max-width: 1000px; margin: 0 auto; position: relative; z-index: 1; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.1);">
        <style>
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
        </style>

        <form action="{{ route('order.store') }}" method="POST" id="orderForm" style="position: relative; z-index: 2;" enctype="multipart/form-data">
            @csrf
            
            <div class="order-main-grid">
                 <!-- Left Column: Personal Data -->
                 <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1.5rem;">
                        <div style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--primary), var(--secondary)); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 700; color: white; font-size: 1rem; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);">1</div>
                        <h3 style="margin: 0; color: var(--text-main); font-size: 1.2rem; font-weight: 700;">Data Diri</h3>
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 8px; font-size: 0.95rem; font-weight: 600; color: var(--text-main);">Nama Lengkap</label>
                        <input type="text" name="customer_name" required placeholder="Masukkan nama Anda" style="width: 100%; padding: 14px 16px; background: rgba(255,255,255,0.05); border: 1.5px solid var(--glass-border); border-radius: 12px; color: var(--text-main); font-size: 1rem; transition: all 0.3s ease;" onfocus="this.style.borderColor='var(--primary)'; this.style.background='rgba(139, 92, 246, 0.05)'" onblur="this.style.borderColor='var(--glass-border)'; this.style.background='rgba(255,255,255,0.05)'">
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 8px; font-size: 0.95rem; font-weight: 600; color: var(--text-main);">No. HP (WhatsApp)</label>
                        <input type="text" name="phone" required placeholder="08xxxxxxxxxx" style="width: 100%; padding: 14px 16px; background: rgba(255,255,255,0.05); border: 1.5px solid var(--glass-border); border-radius: 12px; color: var(--text-main); font-size: 1rem; transition: all 0.3s ease;" onfocus="this.style.borderColor='var(--primary)'; this.style.background='rgba(139, 92, 246, 0.05)'" onblur="this.style.borderColor='var(--glass-border)'; this.style.background='rgba(255,255,255,0.05)'">
                    </div>
                    
                    <div id="shippingGroup" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.05), rgba(59, 130, 246, 0.05)); padding: 25px; border-radius: 16px; border: 1.5px solid rgba(139, 92, 246, 0.2); margin-top: 2rem;">
                        <h4 style="margin-top: 0; margin-bottom: 20px; color: var(--primary); font-size: 1.1rem; display: flex; align-items: center; gap: 10px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            Alamat Pengiriman Lengkap
                        </h4>
                        
                        <!-- Hidden Inputs for Backend -->
                        <input type="hidden" name="shipping_cost" id="shippingCostInput" value="0">
                        <input type="hidden" name="shipping_service" id="shippingServiceInput">
                        
                        <div class="address-grid">
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Provinsi</label>
                                <select id="provinceSelect" onchange="loadCities(this.value)" style="width: 100%;">
                                    <option value="">Pilih Provinsi...</option>
                                </select>
                            </div>
                            
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Kota/Kabupaten</label>
                                <select name="city_id" id="citySelect" onchange="loadDistricts(this.value)" disabled style="width: 100%;">
                                    <option value="">Pilih Kota...</option>
                                </select>
                            </div>
                        </div>

                        <div style="margin-top: 15px;">
                            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Kecamatan</label>
                            <select name="district_id" id="districtSelect" onchange="enableGPS()" disabled style="width: 100%;">
                                <option value="">Pilih Kecamatan...</option>
                            </select>
                        </div>
                        
                        <div style="margin-top: 20px;">
                            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">Titik Lokasi Pengiriman (Wajib)</label>
                            <button type="button" id="gpsButton" onclick="getLocation()" disabled style="width: 100%; padding: 12px; border-radius: 12px; border: 1.5px dashed var(--glass-border); background: rgba(59, 130, 246, 0.1); color: var(--primary); font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.3s ease; cursor: not-allowed; opacity: 0.6;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <span>Gunakan Lokasi Saya (GPS)</span>
                            </button>
                            <div id="gpsStatus" style="font-size: 0.8rem; margin-top: 5px; color: var(--text-muted); text-align: center;">Pilih Kecamatan dulu untuk aktifkan GPS</div>
                            <input type="hidden" name="latitude" id="latInput">
                            <input type="hidden" name="longitude" id="lngInput">
                        </div>

                        <div style="margin-top: 15px; margin-bottom: 12px;">
                            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Detail Alamat (Jalan, No. Rumah, RT/RW)</label>
                            <textarea name="address" required id="addressInput" placeholder="Contoh: Jl. Mawar No. 5, RT 01 RW 02" style="width: 100%; padding: 14px 16px; background: rgba(255,255,255,0.05); border: 1.5px solid var(--glass-border); border-radius: 12px; color: var(--text-main); min-height: 80px; font-size: 0.95rem; resize: vertical; transition: all 0.3s ease; font-family: inherit;" onfocus="this.style.borderColor='var(--primary)'; this.style.background='rgba(139, 92, 246, 0.05)'" onblur="this.style.borderColor='var(--glass-border)'; this.style.background='rgba(255,255,255,0.05)'"></textarea>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Kurir</label>
                            <select name="courier" id="courierSelect" onchange="checkShipping()" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--glass-border); background: rgba(255,255,255,0.05); color: var(--text-main);">
                                <option value="jne">JNE (Jalur Nugraha Ekakurir)</option>
                                <option value="pos">POS Indonesia</option>
                                <option value="tiki">TIKI (Titipan Kilat)</option>
                            </select>
                        </div>
                        
                        <div id="shippingResult" style="margin-top: 20px; padding: 15px; background: rgba(0,0,0,0.2); border-radius: 12px; display: none;">
                            <label style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 10px; color: var(--secondary);">✨ Layanan Pengiriman Tersedia:</label>
                            <div id="serviceOptions" style="display: flex; flex-direction: column; gap: 10px;">
                                <!-- Options injected by JS -->
                            </div>
                        </div>
                        
                        <div id="loadingShipping" style="display: none; text-align: center; color: var(--text-muted); font-size: 0.9rem; margin-top: 15px;">
                            <span class="spin" style="display: inline-block; animation: spin 1s linear infinite;">↻</span> Sedang menghitung ongkir...
                        </div>
                    </div>
                 </div>

                 <!-- Right Column: Order Items & Payment -->
                 <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1.5rem;">
                        <div style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--primary), var(--secondary)); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 700; color: white; font-size: 1rem; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);">2</div>
                        <h3 style="margin: 0; color: var(--text-main); font-size: 1.2rem; font-weight: 700;">Menu Pilihan</h3>
                    </div>

                    <div id="itemsContainer" style="max-height: 450px; overflow-y: auto; padding-right: 8px; margin-bottom: 1rem;">
                        <div class="item-row" style="display: flex; gap: 12px; margin-bottom: 12px; align-items: center;">
                            <select name="items[0][id]" class="product-select" onchange="updatePrice(this); calculateTotal()" required style="flex: 1; padding: 14px 16px; background: rgba(255,255,255,0.05); border: 1.5px solid var(--glass-border); border-radius: 12px; color: var(--text-main); font-size: 1rem; font-weight: 500; cursor: pointer; transition: all 0.3s ease;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--glass-border)'">
                                <option value="" data-price="0">Pilih Produk...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }} - Rp {{ number_format($product->price, 0) }}</option>
                                @endforeach
                            </select>
                            <input type="number" name="items[0][quantity]" value="1" min="1" style="width: 80px; padding: 14px 12px; background: rgba(255,255,255,0.05); border: 1.5px solid var(--glass-border); border-radius: 12px; color: var(--text-main); text-align: center; font-weight: 600; font-size: 1rem;" onchange="calculateTotal()" required>
                        </div>
                    </div>
                    
                    <button type="button" class="btn" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(59, 130, 246, 0.1)); border: 1.5px dashed rgba(139, 92, 246, 0.4); width: 100%; margin-bottom: 2rem; font-size: 0.95rem; padding: 12px; font-weight: 600; color: var(--primary);" onclick="addItem()">+ Tambah Menu Lain</button>

                    <div style="padding: 2rem; background: linear-gradient(135deg, rgba(0,0,0,0.2), rgba(0,0,0,0.1)); border-radius: 16px; border: 1.5px solid var(--glass-border); backdrop-filter: blur(10px); margin-bottom: 2rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; align-items: center;">
                            <span style="color: var(--text-muted); font-size: 0.95rem;">Ongkos Kirim</span>
                            <span id="shippingDisplay" style="font-weight: 700; font-size: 1.05rem; color: var(--text-main);">Rp 0</span>
                        </div>
                        <div style="height: 1.5px; background: linear-gradient(90deg, transparent, var(--glass-border), transparent); margin: 16px 0;"></div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 1.15rem; font-weight: 700; color: var(--text-main);">Total Bayar</span>
                            <span id="totalDisplay" style="font-size: 1.6rem; font-weight: 800; background: linear-gradient(135deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Rp 0</span>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn" style="width: 100%; padding: 15px; font-size: 1.05rem; font-weight: 700; background: linear-gradient(135deg, var(--primary), var(--secondary)); box-shadow: 0 8px 24px rgba(139, 92, 246, 0.4); border: none; position: relative; overflow: hidden;">
                        <span style="position: relative; z-index: 1; display: flex; align-items: center; justify-content: center; gap: 10px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 16 16 12 12 8"></polyline>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            Pesan Sekarang
                        </span>
                        <div style="position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); animation: shimmer 2s infinite;"></div>
                    </button>
                 </div>
            </div>
            
            <!-- Scripts -->
            <script>
                $(document).ready(function() {
                    // Initialize Select2
                    $('#provinceSelect').select2({ placeholder: "Pilih / Cari Provinsi...", width: '100%' });
                    $('#citySelect').select2({ placeholder: "Pilih / Cari Kota...", width: '100%' });
                    $('#districtSelect').select2({ placeholder: "Pilih / Cari Kecamatan...", width: '100%' });
            
                    // Load Provinces on Start
                    loadProvinces();
            
                    // Event Listeners for Select2
                    $('#provinceSelect').on('select2:select', function(e) {
                        loadCities(e.params.data.id);
                    });
            
                    $('#citySelect').on('select2:select', function(e) {
                        loadDistricts(e.params.data.id);
                    });

                    $('#districtSelect').on('select2:select', function(e) {
                        enableGPS();
                    });
                });
            
                async function loadProvinces() {
                    try {
                        const res = await fetch('/api/provinces');
                        const data = await res.json();
                        const select = $('#provinceSelect');
                        select.empty().append('<option></option>');
                        data.forEach(p => select.append(new Option(p.province, p.province_id, false, false)));
                    } catch(e) { console.error(e); }
                }
            
                async function loadCities(provinceId) {
                    $('#citySelect').empty().append('<option></option>').prop('disabled', true);
                    $('#districtSelect').empty().append('<option></option>').prop('disabled', true);
                    resetCost();

                    if (!provinceId) return;
                    
                    try {
                        const res = await fetch(`/api/cities?province_id=${provinceId}`);
                        const data = await res.json();
                        const select = $('#citySelect');
                        data.forEach(c => select.append(new Option(`${c.type} ${c.city_name}`, c.city_id, false, false)));
                        select.prop('disabled', false).trigger('change'); 
                        select.select2('open');
                    } catch(e) { console.error(e); }
                }

                async function loadDistricts(cityId) {
                    $('#districtSelect').empty().append('<option></option>').prop('disabled', true);
                    resetCost();

                    if (!cityId) return;

                    try {
                        const res = await fetch(`/api/districts?city_id=${cityId}`);
                        const data = await res.json();
                        const select = $('#districtSelect');
                        data.forEach(d => select.append(new Option(d.district_name, d.district_id, false, false)));
                        select.prop('disabled', false).trigger('change');
                        select.select2('open');
                    } catch(e) { console.error(e); }
                }

                function enableGPS() {
                    $('#gpsButton').prop('disabled', false).css({'cursor': 'pointer', 'opacity': '1'});
                    $('#gpsStatus').text('Silakan klik tombol di atas untuk deteksi lokasi akurat.');
                    resetCost();
                }

                function getLocation() {
                    if (navigator.geolocation) {
                        $('#gpsButton').html('<span class="spin">↻</span> Mendeteksi Lokasi...').prop('disabled', true);
                        navigator.geolocation.getCurrentPosition(showPosition, showError);
                    } else { 
                        $('#gpsStatus').text("Geolocation tidak didukung oleh browser ini.");
                    }
                }

                function showPosition(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    document.getElementById('latInput').value = lat;
                    document.getElementById('lngInput').value = lng;
                    
                    $('#gpsButton').html('✅ Lokasi Terdeteksi').css({'background': 'rgba(16, 185, 129, 0.2)', 'color': '#10b981', 'border-color': '#10b981'});
                    $('#gpsStatus').text(`Koordinat: ${lat.toFixed(5)}, ${lng.toFixed(5)}`);
                    
                    // Auto-fill address using Reverse Geocoding (Nominatim OpenStreetMap)
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.display_name) {
                                const addressInput = document.getElementById('addressInput');
                                addressInput.value = data.display_name;
                                // Flash effect to indicate update
                                addressInput.style.borderColor = '#10b981';
                                setTimeout(() => addressInput.style.borderColor = 'var(--glass-border)', 1000);
                            }
                        })
                        .catch(err => console.error("Gagal reverse geocoding:", err));
                    
                    // Trigger check shipping now that we have precise location
                    checkShipping();
                }

                function showError(error) {
                    let msg = "Terjadi kesalahan GPS.";
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            msg = "Izin lokasi ditolak. Mohon izinkan akses lokasi.";
                            break;
                        case error.POSITION_UNAVAILABLE:
                            msg = "Informasi lokasi tidak tersedia.";
                            break;
                        case error.TIMEOUT:
                            msg = "Waktu permintaan lokasi habis.";
                            break;
                    }
                    $('#gpsStatus').text(msg).css('color', '#ef4444');
                    // Enable button again to retry
                    $('#gpsButton').html('<span>Gunakan Lokasi Saya (GPS)</span>').prop('disabled', false);
                }
            
                function resetCost() {
                    document.getElementById('shippingCostInput').value = 0;
                    selectedShippingCost = 0;
                    calculateTotal();
                    $('#serviceOptions').empty();
                    $('#shippingResult').hide();
                }

                async function checkShipping() {
                    // Trigger strictly if GPS is gathered (or manual fallback if needed, but per requirement GPS is key)
                    const cityId = $('#citySelect').val();
                    const districtId = $('#districtSelect').val();
                    const courier = $('#courierSelect').val();
                    const weight = calculateWeight(); 
                    const lat = document.getElementById('latInput').value;
                    
                    if (!cityId || !districtId || !courier || !lat) return;
                    
                    $('#loadingShipping').show();
                    $('#shippingResult').hide();
                    
                    try {
                        const res = await fetch('/api/shipping-cost', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            },
                            body: JSON.stringify({
                                destination: cityId, 
                                weight: weight,
                                courier: courier
                            })
                        });
                        
                        const costs = await res.json();
                        renderShippingOptions(costs); 
                        
                    } catch (e) {
                        alert("Gagal cek ongkir.");
                    } finally {
                        $('#loadingShipping').hide();
                    }
                }

                function renderShippingOptions(costs) {
                    const container = document.getElementById('serviceOptions');
                    container.innerHTML = '';
                    
                    if (costs.length === 0) {
                        container.innerHTML = '<div style="padding: 15px; background: rgba(239, 68, 68, 0.1); border-radius: 8px; color: #fca5a5; font-size: 0.9rem;">⚠️ Tidak ada layanan pengiriman tersedia untuk rute ini.</div>';
                        $('#shippingResult').fadeIn();
                        return;
                    }

                    costs.forEach((service, index) => {
                        const costVal = service.cost[0].value;
                        const etd = service.cost[0].etd;
                        const serviceName = service.service;
                        const description = service.description; 
                        const etdText = etd.includes('HARI') ? etd : `${etd} Hari`;

                        const div = document.createElement('div');
                        div.className = 'shipping-option';
                        div.style.cssText = `
                            padding: 14px; 
                            margin-bottom: 8px;
                            border: 1.5px solid var(--glass-border); 
                            border-radius: 12px; 
                            cursor: pointer; 
                            background: rgba(255,255,255,0.03); 
                            display: flex; 
                            justify-content: space-between; 
                            align-items: center;
                            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                        `;
                        div.onmouseover = () => { if(!div.classList.contains('active')) div.style.background = 'rgba(255,255,255,0.08)'; };
                        div.onmouseout = () => { if(!div.classList.contains('active')) div.style.background = 'rgba(255,255,255,0.03)'; };

                        div.onclick = () => selectShipping(costVal, serviceName, div);
                        
                        div.innerHTML = `
                            <div style="display: flex; gap: 12px; align-items: center;">
                                <div style="background: rgba(139, 92, 246, 0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                </div>
                                <div>
                                    <div style="font-weight: 700; font-size: 0.95rem; color: var(--text-main);">${serviceName}</div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">${description} • Estimasi ${etdText}</div>
                                </div>
                            </div>
                            <div style="font-weight: 700; color: var(--primary); font-size: 1rem;">Rp ${costVal.toLocaleString('id-ID')}</div>
                        `;
                        
                        container.appendChild(div);
                        if (index === 0) selectShipping(costVal, serviceName, div);
                    });
                    
                    $('#shippingResult').fadeIn();
                }

                function selectShipping(cost, serviceName, element) {
                    document.querySelectorAll('.shipping-option').forEach(el => {
                        el.style.background = 'rgba(255,255,255,0.03)';
                        el.style.borderColor = 'var(--glass-border)';
                        el.classList.remove('active');
                    });
                    
                    element.style.background = 'rgba(139, 92, 246, 0.15)';
                    element.style.borderColor = 'var(--primary)';
                    element.classList.add('active');
                    
                    selectedShippingCost = cost;
                    document.getElementById('shippingCostInput').value = cost;
                    document.getElementById('shippingServiceInput').value = serviceName;
                    
                    calculateTotal();
                }
                
                function toggleDistance(isDelivery) {
                    const group = document.getElementById('shippingGroup');
                    if(isDelivery) {
                        $(group).slideDown();
                        selectedShippingCost = 0; 
                        if($('#villageSelect').val()) checkShipping(); 
                    } else {
                        $(group).slideUp();
                        selectedShippingCost = 0;
                        document.getElementById('shippingCostInput').value = 0;
                        calculateTotal();
                    }
                }

                function calculateTotal() {
                    let productTotal = 0;
                    const rows = document.querySelectorAll('.item-row');
                    
                    rows.forEach(row => {
                        const select = row.querySelector('select');
                        const qtyInput = row.querySelector('input[type="number"]');
                        
                        if(select && qtyInput) {
                            const qty = qtyInput.value;
                            const price = select.options[select.selectedIndex].getAttribute('data-price') || 0;
                            productTotal += price * qty;
                        }
                    });
                    
                    const total = productTotal + selectedShippingCost;
                    
                    document.getElementById('shippingDisplay').innerText = 'Rp ' + selectedShippingCost.toLocaleString('id-ID');
                    document.getElementById('totalDisplay').innerText = 'Rp ' + total.toLocaleString('id-ID');
                }
                
                // Legacy: Keep plain JS for dynamic add item to avoid conflict
                function addItem() {
                    const container = document.getElementById('itemsContainer');
                    const div = document.createElement('div');
                    div.className = 'item-row';
                    div.style.cssText = 'display: flex; gap: 12px; margin-bottom: 12px; align-items: center;';
                    
                    const firstSelect = document.querySelector('.product-select').cloneNode(true);
                    firstSelect.name = `items[${itemCount}][id]`;
                    firstSelect.value = '';
                    firstSelect.selectedIndex = 0;
                    
                    div.innerHTML = `
                        <div style="flex: 1;">${firstSelect.outerHTML}</div>
                        <input type="number" name="items[${itemCount}][quantity]" value="1" min="1" style="width: 80px; padding: 14px 12px; background: rgba(255,255,255,0.05); border: 1.5px solid var(--glass-border); border-radius: 12px; color: var(--text-main); text-align: center; font-weight: 600; font-size: 1rem;" onchange="calculateTotal()" required>
                        <button type="button" onclick="this.parentElement.remove(); checkShipping(); calculateTotal()" style="background: #ef4444; color: white; border: none; border-radius: 8px; cursor: pointer; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 1rem; font-weight: bold;">✕</button>
                    `;
                    
                    div.querySelector('select').addEventListener('change', function() {
                        updatePrice(this);
                    });

                    container.appendChild(div);
                    itemCount++;
                }

                function updatePrice(select) {
                    calculateTotal();
                }
            </script>
            </div>
            
            <!-- Mobile Responsive Style -->
            <style>
                @keyframes shimmer {
                    0% { left: -100%; }
                    100% { left: 200%; }
                }
                
                /* Default Desktop Styles */
                .order-main-grid {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 2.5rem;
                    align-items: start;
                }
                
                .address-grid {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 15px;
                }

                .glass-panel-order {
                    padding: 2.5rem;
                }
                
                .item-row {
                    display: flex;
                    gap: 12px;
                    margin-bottom: 12px;
                    align-items: center;
                }

                /* Mobile Styles */
                @media (max-width: 768px) {
                    .order-main-grid {
                        grid-template-columns: 1fr;
                        gap: 2rem;
                    }
                    
                    .glass-panel-order {
                        padding: 1.5rem !important; /* Reduced padding */
                    }

                    .address-grid {
                        grid-template-columns: 1fr; /* Stack Province & City */
                    }
                    
                    /* Tweak item row for very small screens */
                    .item-row {
                        flex-wrap: wrap;
                    }
                    
                    .item-row select {
                        width: 100% !important;
                        flex: 100% !important;
                    }
                    
                    .item-row input[type="number"] {
                        flex: 1;
                    }
                    
                    .item-row button {
                        /* Keep delete button size */
                    }
                }
                
                .delivery-radio:checked + .delivery-card {
                    background: linear-gradient(135deg, var(--primary), var(--secondary)) !important;
                    border-color: var(--primary) !important;
                    color: white !important;
                    box-shadow: 0 8px 24px rgba(139, 92, 246, 0.4) !important;
                    transform: translateY(-2px);
                }
                
                .delivery-card:hover {
                    border-color: var(--primary);
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(139, 92, 246, 0.2);
                }

                .payment-radio:checked + .payment-card {
                    background: rgba(139, 92, 246, 0.1) !important;
                    border-color: var(--primary) !important;
                    box-shadow: 0 4px 12px rgba(139, 92, 246, 0.2);
                }
                
                .payment-radio:checked + .payment-card .radio-check {
                    width: 20px;
                    height: 20px;
                    background: var(--primary);
                    border-radius: 50%;
                    box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.2);
                }

                .radio-check {
                    width: 20px;
                    height: 20px;
                    border: 2px solid var(--text-muted);
                    border-radius: 50%;
                }
                
                /* Dropdown options styling */
                select.product-select option {
                    background: #1e293b;
                    color: white;
                    padding: 10px;
                }
                
                select.product-select {
                    color: var(--text-main) !important;
                }
            </style>
        </form>
    </div>
</section>

<!-- Add Select2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Custom Select2 Styling to match Glassmorphism */
    .select2-container--default .select2-selection--single {
        background-color: rgba(255,255,255,0.05) !important;
        border: 1.5px solid var(--glass-border) !important;
        border-radius: 12px !important;
        height: 50px !important;
        display: flex !important;
        align-items: center !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: var(--text-main) !important;
        padding-left: 16px !important;
        font-size: 0.95rem !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 48px !important;
        right: 10px !important;
    }
    .select2-dropdown {
        background-color: #1e293b !important;
        border: 1px solid var(--glass-border) !important;
        border-radius: 12px !important;
        backdrop-filter: blur(20px);
    }
    .select2-search__field {
        background-color: rgba(255,255,255,0.1) !important;
        border: 1px solid var(--glass-border) !important;
        color: white !important;
        border-radius: 8px !important;
    }
    .select2-results__option {
        color: #cbd5e1 !important;
        padding: 10px 16px !important;
    }
    .select2-results__option--highlighted {
        background-color: var(--primary) !important;
        color: white !important;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let itemCount = 1;
    let selectedShippingCost = 0;

    $(document).ready(function() {
        // Initialize Select2
        $('#provinceSelect').select2({
            placeholder: "Cari Provinsi...",
            width: '100%'
        });
        
        $('#citySelect').select2({
            placeholder: "Cari Kota/Kabupaten...",
            width: '100%'
        });

        // Load Provinces on Start
        loadProvinces();

        // Event Listeners
        $('#provinceSelect').on('select2:select', function(e) {
            loadCities(e.params.data.id);
        });

        $('#citySelect').on('select2:select', function(e) {
            checkShipping();
        });
    });

    async function loadProvinces() {
        try {
            const res = await fetch('/api/provinces');
            const data = await res.json();
            
            if(data.length === 0) {
                 console.error("No provinces found. API Key might be invalid.");
                 return;
            }

            const select = $('#provinceSelect');
            select.empty();
            select.append('<option></option>'); // Placeholder
            
            data.forEach(p => {
                const option = new Option(p.province, p.province_id, false, false);
                select.append(option);
            });
            select.trigger('change');
            
        } catch (e) {
            console.error("Failed to load provinces", e);
        }
    }

    async function loadCities(provinceId) {
        if (!provinceId) return;
        
        // Reset
        $('#citySelect').empty().append('<option></option>').prop('disabled', true);
        document.getElementById('shippingCostInput').value = 0;
        selectedShippingCost = 0;
        calculateTotal();
        $('#serviceOptions').empty();
        $('#shippingResult').hide();

        try {
            const res = await fetch(`/api/cities?province_id=${provinceId}`);
            const data = await res.json();
            
            const select = $('#citySelect');
            data.forEach(c => {
                const text = `${c.type} ${c.city_name}`;
                const option = new Option(text, c.city_id, false, false);
                select.append(option);
            });
            select.prop('disabled', false).trigger('change');
            select.select2('open'); // Auto open for better UX
            
        } catch (e) {
            console.error("Failed to load cities", e);
        }
    }

    function calculateWeight() {
        let totalItems = 0;
        document.querySelectorAll('input[name*="[quantity]"]').forEach(input => {
            totalItems += parseInt(input.value || 0);
        });
        return Math.max(totalItems * 200, 100); 
    }

    async function checkShipping() {
        const cityId = $('#citySelect').val();
        const courier = document.getElementById('courierSelect').value;
        const weight = calculateWeight();
        
        if (!cityId || !courier) return;
        
        $('#loadingShipping').show();
        $('#shippingResult').hide();
        
        try {
            const res = await fetch('/api/shipping-cost', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    destination: cityId,
                    weight: weight,
                    courier: courier
                })
            });
            const costs = await res.json();
            renderShippingOptions(costs);
            
        } catch (e) {
            console.error(e);
            alert("Gagal cek ongkir. Pastikan koneksi internet lancar.");
        } finally {
            $('#loadingShipping').hide();
        }
    }

    function renderShippingOptions(costs) {
        const container = document.getElementById('serviceOptions');
        container.innerHTML = '';
        
        if (costs.length === 0) {
            container.innerHTML = '<div style="padding: 15px; background: rgba(239, 68, 68, 0.1); border-radius: 8px; color: #fca5a5; font-size: 0.9rem;">⚠️ Tidak ada layanan pengiriman tersedia untuk rute ini atau API Key limit tercapai.</div>';
            $('#shippingResult').show();
            return;
        }

        costs.forEach((service, index) => {
            const costVal = service.cost[0].value;
            const etd = service.cost[0].etd;
            const serviceName = service.service;
            const description = service.description; // e.g., "Yakin Esok Sampai"
            
            // Format ETD usually comes as "1-2" days
            const etdText = etd.includes('HARI') ? etd : `${etd} Hari`;

            const div = document.createElement('div');
            div.className = 'shipping-option';
            div.style.cssText = `
                padding: 14px; 
                margin-bottom: 8px;
                border: 1.5px solid var(--glass-border); 
                border-radius: 12px; 
                cursor: pointer; 
                background: rgba(255,255,255,0.03); 
                display: flex; 
                justify-content: space-between; 
                align-items: center;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            `;
            // Hover effect handled in CSS or here
            div.onmouseover = () => { if(!div.classList.contains('active')) div.style.background = 'rgba(255,255,255,0.08)'; };
            div.onmouseout = () => { if(!div.classList.contains('active')) div.style.background = 'rgba(255,255,255,0.03)'; };

            div.onclick = () => selectShipping(costVal, serviceName, div);
            
            div.innerHTML = `
                <div style="display: flex; gap: 12px; align-items: center;">
                    <div style="background: rgba(139, 92, 246, 0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    </div>
                    <div>
                        <div style="font-weight: 700; font-size: 0.95rem; color: var(--text-main);">${serviceName}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">${description} • Estimasi ${etdText}</div>
                    </div>
                </div>
                <div style="font-weight: 700; color: var(--primary); font-size: 1rem;">Rp ${costVal.toLocaleString('id-ID')}</div>
            `;
            
            container.appendChild(div);
            
            // Auto select first option or cheapest? Let's just select first.
            if (index === 0) selectShipping(costVal, serviceName, div);
        });
        
        $('#shippingResult').fadeIn();
    }

    function selectShipping(cost, serviceName, element) {
        // Reset all
        document.querySelectorAll('.shipping-option').forEach(el => {
            el.style.background = 'rgba(255,255,255,0.03)';
            el.style.borderColor = 'var(--glass-border)';
            el.classList.remove('active');
        });
        
        // Hightlight active
        element.style.background = 'rgba(139, 92, 246, 0.15)';
        element.style.borderColor = 'var(--primary)';
        element.classList.add('active');
        
        // Set values
        selectedShippingCost = cost;
        document.getElementById('shippingCostInput').value = cost;
        document.getElementById('shippingServiceInput').value = serviceName;
        
        calculateTotal();
    }
    
    function toggleDistance(isDelivery) {
        const group = document.getElementById('shippingGroup');
        if(isDelivery) {
            $(group).slideDown();
            selectedShippingCost = 0; 
            if($('#citySelect').val()) checkShipping(); 
        } else {
            $(group).slideUp();
            selectedShippingCost = 0;
            document.getElementById('shippingCostInput').value = 0;
            calculateTotal();
        }
    }

    function calculateTotal() {
        let productTotal = 0;
        const rows = document.querySelectorAll('.item-row');
        
        rows.forEach(row => {
            const select = row.querySelector('select');
            const qtyInput = row.querySelector('input[type="number"]');
            
            if(select && qtyInput) {
                const qty = qtyInput.value;
                const price = select.options[select.selectedIndex].getAttribute('data-price') || 0;
                productTotal += price * qty;
            }
        });
        
        const total = productTotal + selectedShippingCost;
        
        // Animate count up if desired, but simple text replace is fine
        document.getElementById('shippingDisplay').innerText = 'Rp ' + selectedShippingCost.toLocaleString('id-ID');
        document.getElementById('totalDisplay').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }
    
    // Legacy: Keep plain JS for dynamic add item to avoid conflict
    function addItem() {
        const container = document.getElementById('itemsContainer');
        const div = document.createElement('div');
        div.className = 'item-row';
        div.style.cssText = 'display: flex; gap: 12px; margin-bottom: 12px; align-items: center;';
        
        // Need to recreate logic since we are not using blade loop here easily without duplication
        // We will just clone the first select found
        const firstSelect = document.querySelector('.product-select').cloneNode(true);
        firstSelect.name = `items[${itemCount}][id]`;
        firstSelect.value = '';
        firstSelect.selectedIndex = 0;
        
        div.innerHTML = `
            <div style="flex: 1;">${firstSelect.outerHTML}</div>
            <input type="number" name="items[${itemCount}][quantity]" value="1" min="1" style="width: 80px; padding: 14px 12px; background: rgba(255,255,255,0.05); border: 1.5px solid var(--glass-border); border-radius: 12px; color: var(--text-main); text-align: center; font-weight: 600; font-size: 1rem;" onchange="checkShipping(); calculateTotal()" required>
            <button type="button" onclick="this.parentElement.remove(); checkShipping(); calculateTotal()" style="background: #ef4444; color: white; border: none; border-radius: 8px; cursor: pointer; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 1rem; font-weight: bold;">✕</button>
        `;
        
        // Re-attach listener to the new select
        div.querySelector('select').addEventListener('change', function() {
            updatePrice(this);
        });

        container.appendChild(div);
        itemCount++;
    }

    function updatePrice(select) {
        checkShipping();
        calculateTotal();
    }
</script>
@endsection
