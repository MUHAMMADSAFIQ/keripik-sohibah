@extends('layouts.app')

@section('content')
<style>
    /* Hide Public Nav on Admin Dashboard */
    nav.glass-panel { display: none !important; }
    main { padding: 0 !important; margin-top: 0 !important; }
    footer { display: none !important; }
    
    /* Hide User Chat Widget on Admin Dashboard */
    .chat-toggle { display: none !important; }
    .chat-widget { display: none !important; }
    #chatWidget { display: none !important; }
    
    /* Admin Layout */
    .admin-layout { 
        display: flex; 
        min-height: 100vh; 
        background: var(--dark); 
        color: var(--text-main); 
        position: relative; 
        overflow-x: hidden;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    
    /* Sidebar */
    .sidebar {
        width: 260px;
        background: #1e293b; /* Force Dark for Admin Contrast */
        border-right: 1px solid rgba(255,255,255,0.1);
        position: fixed;
        height: 100vh;
        z-index: 1000;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        font-family: 'Inter', sans-serif;
    }

    /* Mobile Sidebar State */
    @media (max-width: 1024px) {
        .sidebar { transform: translateX(-100%); }
        .sidebar.active { transform: translateX(0); box-shadow: 20px 0 50px rgba(0,0,0,0.5); }
    }

    /* Main Content */
    .admin-main {
        flex: 1;
        margin-left: 260px;
        padding: 2.5rem;
        transition: margin-left 0.3s ease;
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        font-family: 'Inter', sans-serif;
    }

    @media (max-width: 1024px) {
        .admin-main { margin-left: 0; padding: 1.5rem; padding-top: 5rem; }
    }

    /* SVG Icons */
    .icon { width: 20px; height: 20px; stroke-width: 2px; flex-shrink: 0; }
    .icon-lg { width: 24px; height: 24px; stroke-width: 2px; flex-shrink: 0; }

    /* Nav Links */
    .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: #94a3b8; /* Always bright grey */
        text-decoration: none;
        border-radius: 12px;
        margin: 4px 16px;
        transition: all 0.2s ease;
        font-weight: 600;
        font-size: 0.95rem;
        letter-spacing: 0.01em;
        font-family: 'Inter', sans-serif;
    }
    .nav-link:hover {
        background: rgba(255, 255, 255, 0.05);
        color: white;
        transform: translateX(2px);
    }
    .nav-link.active {
        background: var(--primary); /* Purple */
        color: white !important; /* Force white text */
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
        font-weight: 700;
    }
    .nav-link.active svg {
        stroke: white !important; /* Force white icon */
    }
    
    .nav-section-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #64748b;
        margin: 20px 20px 10px;
        font-weight: 700;
        font-family: 'Inter', sans-serif;
    }

    /* Mobile Header */
    .mobile-header {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0;
        height: 64px;
        background: var(--glass);
        z-index: 900;
        align-items: center;
        padding: 0 1.5rem;
        border-bottom: 1px solid var(--glass-border);
        justify-content: space-between;
        font-family: 'Inter', sans-serif;
    }
    @media (max-width: 1024px) { .mobile-header { display: flex; } }

    /* Grid Layouts */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .content-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    @media (min-width: 1280px) {
        .content-grid { grid-template-columns: 2fr 1fr; }
    }

    /* Table Scroll */
    .table-container { overflow-x: auto; -webkit-overflow-scrolling: touch; border-radius: 12px; }
    
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }

    /* Navigation Targets */
    section[id], div[id] { scroll-margin-top: 100px; }

    /* Override Global Nav for Sidebar */
    .sidebar nav {
        display: flex !important;
        flex-direction: column !important;
        padding: 10px 0 !important;
        position: static !important;
        margin: 0 !important;
        gap: 5px !important;
    }
    
    /* Force Inter font on all headings and important text */
    .admin-layout h1, .admin-layout h2, .admin-layout h3, 
    .admin-layout h4, .admin-layout h5, .admin-layout h6 {
        font-family: 'Inter', sans-serif !important;
        font-weight: 700;
        letter-spacing: -0.02em;
    }
    
    .admin-layout .glass-panel {
        font-family: 'Inter', sans-serif;
    }
</style>

<div class="admin-layout">
    
    <!-- Mobile Header -->
    <div class="mobile-header">
        <button onclick="toggleSidebar()" class="btn" style="background: transparent; padding: 5px; color: var(--text-main);">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
        <span style="font-weight: bold; font-size: 1.1rem; color: var(--primary);">Admin Panel</span>
        <div style="width: 24px;"></div> <!-- Spacer -->
    </div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div style="padding: 2rem; display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--primary); margin: 0;">Sohibah<span style="font-size:0.8rem; opacity:0.7; color: var(--text-muted);">Admin</span></h2>
            <button onclick="toggleSidebar()" class="btn" style="background: transparent; padding: 5px; display: none; color: var(--text-main);" id="closeSidebarBtn">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        
        <nav style="flex: 1; overflow-y: auto;">
            <a href="#dashboard" class="nav-link active" onclick="setActive(this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                Dashboard
            </a>
            <a href="#analytics" class="nav-link" onclick="setActive(this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 3v18h18"/><path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3"/></svg>
                Analitik
            </a>
            <a href="#orders" class="nav-link" onclick="setActive(this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                Pesanan Masuk
                @if($pendingOrders->count() > 0)
                    <span style="margin-left: auto; background: #ef4444; color: white; font-size: 0.75rem; padding: 2px 8px; border-radius: 99px; font-weight: bold;">{{ $pendingOrders->count() }}</span>
                @endif
            </a>
            <a href="#processing" class="nav-link" onclick="setActive(this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                Diproses
                @if($ongoingOrders->count() > 0)
                    <span style="margin-left: auto; background: #3b82f6; color: white; font-size: 0.75rem; padding: 2px 8px; border-radius: 99px; font-weight: bold;">{{ $ongoingOrders->count() }}</span>
                @endif
            </a>
            <a href="#products" class="nav-link" onclick="setActive(this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                Produk
            </a>
            <a href="#testimonials" class="nav-link" onclick="setActive(this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                Testimoni
            </a>

        </nav>


        <div style="padding: 0 2rem 1rem;">
             <div class="theme-switch-wrapper" style="display: flex; align-items: center; justify-content: space-between; background: rgba(255,255,255,0.05); padding: 10px 15px; border-radius: 12px;">
                <span style="font-size: 0.9rem; font-weight: 500; color: var(--text-muted);">Mode Gelap</span>
                <label class="theme-switch" for="adminCheckbox" style="display: inline-block; height: 26px; position: relative; width: 50px; cursor: pointer;">
                    <input type="checkbox" id="adminCheckbox" onchange="toggleAdminTheme()" style="display:none;">
                    <div class="slider" style="background-color: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); bottom: 0; left: 0; position: absolute; right: 0; top: 0; transition: .4s; border-radius: 34px;">
                        <div class="knob" style="bottom: 2px; left: 3px; position: absolute; width: 20px; height: 20px; border-radius: 50%; background: white; transition: 0.4s; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                            <svg class="moon" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#1e293b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                            <svg class="sun" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                        </div>
                    </div>
                </label>
            </div>
        </div>

        <div style="padding: 2rem;">
            <div style="background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 10px; margin-bottom: 1rem;">
                <small style="color: var(--text-muted); display: block; margin-bottom: 5px;">Login sebagai</small>
                <div style="font-weight: bold;">{{ Auth::user()->name }}</div>
                <small style="color: var(--text-muted);">Admin</small>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn" style="width: 100%; background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; color: #ef4444; display: flex; justify-content: center; align-items: center; gap: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebarOverlay" onclick="toggleSidebar()" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; backdrop-filter: blur(2px);"></div>

    <!-- Main Content Area -->
    <main class="admin-main">
        
        <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 10px;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem; letter-spacing: -0.02em;">Dashboard</h1>
                <p style="color: var(--text-muted); font-size: 0.95rem; font-weight: 500;">Overview performa toko hari ini</p>
            </div>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; padding: 5px 10px; border-radius: 8px; font-size: 0.9rem; font-weight: 600;">
                    {{ now()->format('d M Y') }}
                </span>
                

            </div>
        </header>

        <!-- Stats Cards -->
        <div id="dashboard" class="stats-grid reveal">
            <!-- Card 1 -->
            <div class="glass-panel" style="padding: 1.5rem; display: flex; align-items: start; gap: 1rem; border-left: 4px solid #3b82f6;">
                <div style="background: rgba(59, 130, 246, 0.1); padding: 10px; border-radius: 10px; color: #3b82f6;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                </div>
                <div>
                    <h3 style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 8px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Pesanan</h3>
                    <div style="font-size: 2rem; font-weight: 800; letter-spacing: -0.02em;">{{ $allOrders->count() }}</div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="glass-panel" style="padding: 1.5rem; display: flex; align-items: start; gap: 1rem; border-left: 4px solid #f59e0b;">
                <div style="background: rgba(245, 158, 11, 0.1); padding: 10px; border-radius: 10px; color: #f59e0b;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <div>
                    <h3 style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 8px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Menunggu Konfirmasi</h3>
                    <div style="font-size: 2rem; font-weight: 800; letter-spacing: -0.02em;">{{ $pendingOrders->count() }}</div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="glass-panel" style="padding: 1.5rem; display: flex; align-items: start; gap: 1rem; border-left: 4px solid #10b981;">
                <div style="background: rgba(16, 185, 129, 0.1); padding: 10px; border-radius: 10px; color: #10b981;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                </div>
                <div>
                    <h3 style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 8px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Pendapatan</h3>
                    <div style="font-size: 1.5rem; font-weight: 800; margin-bottom: 8px; letter-spacing: -0.02em;">Rp {{ number_format($allOrders->where('status', 'completed')->sum('total_price'), 0, ',', '.') }}</div>
                    
                    @php
                        $revenue = $allOrders->where('status', 'completed')->sum('total_price');
                        $goal = 5000000; // Example Goal: 5 Juta
                        $percent = min(100, ($revenue / $goal) * 100);
                    @endphp
                    
                    <div style="width: 100%; background: rgba(255,255,255,0.1); height: 6px; border-radius: 10px; margin-bottom: 2px;">
                        <div style="width: {{ $percent }}%; background: #10b981; height: 100%; border-radius: 10px;"></div>
                    </div>
                    <small style="color: var(--text-muted); font-size: 0.7rem;">Target: {{ round($percent) }}% (5jt)</small>
                </div>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 2rem;">
            
            <!-- Analytics Chart -->
            <section class="glass-panel reveal" id="analytics" style="padding: 1.5rem; margin-bottom: 0;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; display: flex; align-items: center; gap: 12px;">
                        <div style="background: rgba(244, 63, 94, 0.15); padding: 8px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f43f5e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                            </svg>
                        </div>
                        Analisa Penjualan (7 Hari)
                    </h3>
                </div>
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </section>

             <!-- Pending & Processing Grid -->
             <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                <!-- Pending Orders -->
                <section id="orders" class="glass-panel reveal" style="padding: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 700; display: flex; align-items: center; gap: 12px;">
                            <div style="background: rgba(245, 158, 11, 0.15); padding: 8px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                </svg>
                            </div>
                            Pesanan Masuk
                        </h3>
                        @if($pendingOrders->count() > 0)
                            <span style="font-size: 0.8rem; background: #f59e0b; color: #000; padding: 2px 8px; border-radius: 10px; font-weight: bold;">{{ $pendingOrders->count() }} Baru</span>
                        @endif
                    </div>
                    
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        @forelse($pendingOrders as $order)
                            <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); padding: 1.25rem; border-radius: 12px; position: relative;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; flex-wrap: wrap; gap: 10px;">
                                    <div style="display: flex; align-items: flex-start; gap: 10px;">
                                        <div style="width: 40px; height: 40px; background: rgba(59, 130, 246, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #3b82f6; font-size: 1.1rem; flex-shrink: 0;">
                                            {{ substr($order->customer_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 style="margin: 0; font-size: 1rem;">{{ $order->customer_name }}</h4>
                                            <span style="font-size: 0.75rem; color: var(--text-muted);">#{{ $order->id }} • {{ $order->created_at->format('d/m H:i') }}</span>
                                            
                                            <ul style="margin: 5px 0 0 0; padding-left: 20px; font-size: 0.85rem; color: #e2e8f0;">
                                                @foreach($order->items as $item)
                                                    <li>{{ $item->product ? $item->product->name : 'N/A' }} <span style="color: var(--text-muted);">x{{ $item->quantity }}</span></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div style="text-align: right;">
                                        <div style="font-weight: bold; color: var(--secondary); font-size: 1rem;">Rp {{ number_format($order->total_price, 0) }}</div>
                                        <div style="font-size: 0.75rem; margin-top: 4px;">
                                            <span style="background: {{ $order->payment_method == 'qris' ? 'rgba(14, 165, 233, 0.2)' : 'rgba(255,255,255,0.1)' }}; color: {{ $order->payment_method == 'qris' ? '#0ea5e9' : 'white' }}; padding: 2px 6px; border-radius: 4px;">{{ $order->payment_method }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div style="display: grid; grid-template-columns: auto auto 1fr; gap: 5px; align-items: center; margin-top: 10px;">
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $order->phone) }}" target="_blank" class="btn" style="padding: 6px; background: rgba(37, 211, 102, 0.1); color: #25D366; border: 1px solid #25D366; display: flex; align-items: center; justify-content: center;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg></a>
                                    @if($order->latitude)
                                         <a href="https://www.google.com/maps/search/?api=1&query={{ $order->latitude }},{{ $order->longitude }}" target="_blank" class="btn" style="padding: 6px; background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 1px solid #3b82f6; display: flex; align-items: center; justify-content: center;">📍</a>
                                    @endif
                                    <form action="{{ route('admin.order.update', $order->id) }}" method="POST" style="display: flex; gap: 5px;">
                                        @csrf
                                        <select name="status" style="flex: 1; padding: 6px; background: rgba(0,0,0,0.3); border: 1px solid var(--glass-border); color: white; border-radius: 6px; font-size: 0.85rem;"><option value="confirmed">Terima</option><option value="delivering">Antar</option><option value="completed">Selesai</option><option value="cancelled">Batal</option></select>
                                        <button class="btn" style="padding: 0 10px; font-size: 0.85rem;">OK</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 1rem; color: var(--text-muted); font-size: 0.9rem;">Kosong</div>
                        @endforelse
                    </div>
                </section>

                <!-- Processing Orders -->
                <section id="processing" class="glass-panel reveal" style="padding: 1.5rem;">
                     <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 700; display: flex; align-items: center; gap: 12px;">
                            <div style="background: rgba(59, 130, 246, 0.15); padding: 8px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </div>
                            Diproses
                        </h3>
                         @if($ongoingOrders->count() > 0)
                            <span style="font-size: 0.8rem; background: #3b82f6; color: white; padding: 2px 8px; border-radius: 10px; font-weight: bold;">{{ $ongoingOrders->count() }}</span>
                        @endif
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        @forelse($ongoingOrders as $order)
                             <div style="background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.2); padding: 1.25rem; border-radius: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <div style="font-weight: bold;">{{ $order->customer_name }}</div>
                                    <div style="font-weight: bold; color: var(--secondary);">Rp {{ number_format($order->total_price, 0) }}</div>
                                </div>
                                <div style="font-size: 0.85rem; color: {{ $order->status == 'confirmed' ? '#f59e0b' : '#10b981' }}; margin-bottom: 5px;">
                                    {{ $order->status == 'confirmed' ? 'Dibuat' : 'Diantar' }} • {{ $order->created_at->format('H:i') }}
                                </div>
                                <form action="{{ route('admin.order.update', $order->id) }}" method="POST" style="display: flex; gap: 5px; margin-top: 10px;">
                                    @csrf
                                    <select name="status" style="flex: 1; padding: 6px; background: rgba(0,0,0,0.3); border: 1px solid var(--glass-border); color: white; border-radius: 6px; font-size: 0.85rem;"><option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Dibuat</option><option value="delivering" {{ $order->status == 'delivering' ? 'selected' : '' }}>Diantar</option><option value="completed">Selesai</option></select>
                                    <button class="btn" style="padding: 0 10px; font-size: 0.85rem;">Upd</button>
                                </form>
                            </div>
                        @empty
                             <div style="text-align: center; padding: 1rem; color: var(--text-muted); font-size: 0.9rem;">Kosong</div>
                        @endforelse
                    </div>
                </section>
             </div>

            <!-- Products Table -->
            <section id="products" class="glass-panel reveal" style="padding: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; display: flex; align-items: center; gap: 12px;">
                        <div style="background: rgba(59, 130, 246, 0.15); padding: 8px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                        </div>
                        Stok & Produk
                    </h3>
                    <button onclick="toggleElement('addProductForm')" class="btn" style="padding: 8px 16px; font-size: 0.85rem; display: flex; align-items: center; gap: 5px;">
                        Tambah
                    </button>
                </div>

                <!-- Add Form (Hidden) -->
                <div id="addProductForm" style="display: none; background: var(--glass); padding: 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid var(--glass-border);">
                    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                        @csrf
                        <input type="text" name="name" placeholder="Nama Produk" required>
                        <input type="number" name="price" placeholder="Harga (Rp)" required>
                        <input type="number" name="stock" placeholder="Stok" required>
                        <select name="category">
                            <option value="Keripik">Keripik</option>
                            <option value="Minuman">Minuman</option>
                        </select>
                        <div style="grid-column: 1 / -1;">
                            <label style="display: block; margin-bottom: 5px; color: var(--text-muted); font-size: 0.9rem;">Foto Produk</label>
                            <input type="file" name="image" accept="image/*" style="width: 100%; padding: 10px; background: rgba(255,255,255,0.05); border: 1px dashed var(--glass-border); border-radius: 8px; color: var(--text-muted);">
                        </div>
                        <textarea name="description" placeholder="Deskripsi..." required style="grid-column: 1 / -1; height: 80px;"></textarea>
                        <button class="btn" style="grid-column: 1 / -1; justify-self: start;">Simpan Produk</button>
                    </form>
                </div>

                <div class="table-container">
                    <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                        <thead>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-size: 0.9rem;">
                                <th style="text-align: left; padding: 12px;">Produk</th>
                                <th style="align: left; padding: 12px;">Harga</th>
                                <th style="text-align: center; padding: 12px;">Stok</th>
                                <th style="text-align: right; padding: 12px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <td style="padding: 12px; font-weight: 500;">{{ $product->name }}</td>
                                    <td style="padding: 12px;">Rp {{ number_format($product->price, 0) }}</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <span style="padding: 4px 10px; background: {{ $product->stock > 0 ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)' }}; color: {{ $product->stock > 0 ? '#10b981' : '#ef4444' }}; border-radius: 20px; font-size: 0.8rem; font-weight: bold;">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td style="padding: 12px; text-align: right;">
                                        <button class="btn" style="padding: 6px 12px; font-size: 0.8rem; background: rgba(255,255,255,0.1); border: none;" onclick="toggleElement('editProduct{{ $product->id }}')">Edit</button>
                                    </td>
                                </tr>
                                <tr id="editProduct{{ $product->id }}" style="display: none; background: rgba(0,0,0,0.2);">
                                    <td colspan="4" style="padding: 15px;">
                                        <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                                            @csrf
                                            <input type="text" name="name" value="{{ $product->name }}" style="padding: 8px; width: 150px;">
                                            <input type="number" name="price" value="{{ $product->price }}" style="padding: 8px; width: 100px;">
                                            <input type="number" name="stock" value="{{ $product->stock }}" style="padding: 8px; width: 80px;">
                                            <input type="file" name="image" accept="image/*" style="padding: 5px; width: 180px; font-size: 0.8rem; background: rgba(255,255,255,0.05); border: 1px dashed var(--glass-border); border-radius: 6px; color: var(--text-muted);">
                                            <button class="btn" style="padding: 8px 15px; font-size: 0.8rem;">Simpan</button>
                                            <button type="button" class="btn" style="padding: 8px 15px; background: #ef4444; font-size: 0.8rem; border: 1px solid #ef4444;" onclick="if(confirm('Hapus?')) document.getElementById('del{{ $product->id }}').submit()">Hapus</button>
                                        </form>
                                        <form id="del{{ $product->id }}" action="{{ route('admin.product.delete', $product->id) }}" method="POST">@csrf</form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Testimonials Grid -->
            <section id="testimonials" class="glass-panel reveal" style="padding: 1.5rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; display: flex; align-items: center; gap: 12px; margin-bottom: 1.5rem;">
                    <div style="background: rgba(139, 92, 246, 0.15); padding: 8px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>
                    Testimoni Pelanggan
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                    @forelse($pendingTestimonials as $testi)
                        <div style="background: rgba(255,255,255,0.03); padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <div style="font-weight: bold; font-size: 1.1rem;">{{ $testi->customer_name }}</div>
                                <span style="color: #f59e0b; font-weight: bold;">{{ $testi->rating }} ★</span>
                            </div>
                            <p style="font-size: 0.95rem; color: var(--text-muted); font-style: italic; margin-bottom: 15px; min-height: 40px;">"{{ $testi->content }}"</p>
                            <form action="{{ route('admin.testimonial.approve', $testi->id) }}" method="POST">
                                @csrf
                                <button class="btn" style="width: 100%; font-size: 0.9rem; padding: 10px; background: rgba(16, 185, 129, 0.2); color: #10b981; border: 1px solid #10b981;">
                                    ✅ Setujui & Tampilkan
                                </button>
                            </form>
                        </div>
                    @empty
                        <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 2rem; border: 1px dashed rgba(255,255,255,0.1); border-radius: 12px;">
                            Tidak ada testimoni baru yang perlu disetujui.
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Completed Orders History -->
            <section class="glass-panel reveal" style="padding: 1.5rem;">
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 12px;">
                    <div style="background: rgba(16, 185, 129, 0.15); padding: 8px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </div>
                    Riwayat Pesanan Selesai
                </h3>
                <div class="table-container">
                    <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                        <thead>
                             <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-size: 0.9rem;">
                                <th style="text-align: left; padding: 12px;">Pelanggan</th>
                                <th style="text-align: left; padding: 12px;">Detail Pembayaran</th>
                                <th style="text-align: center; padding: 12px;">Waktu</th>
                                <th style="text-align: right; padding: 12px;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach($allOrders->where('status', 'completed')->take(10) as $order)
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <td style="padding: 12px;">
                                        <div style="font-weight: 500;">{{ $order->customer_name }}</div>
                                        <small style="color: var(--text-muted);">ID: #{{ $order->id }}</small>
                                    </td>
                                    <td style="padding: 12px;">
                                        <span style="background: rgba(255,255,255,0.1); padding: 2px 8px; border-radius: 4px; font-size: 0.85rem;">{{ strtoupper($order->payment_method) }}</span>
                                        @if($order->payment_method == 'qris')
                                            <span style="font-size: 0.85rem; color: var(--text-muted); margin-left: 5px;">({{ $order->sender_name ?? 'N/A' }})</span>
                                        @endif
                                    </td>
                                    <td style="padding: 12px; text-align: center; font-size: 0.9rem; color: var(--text-muted);">
                                        {{ $order->updated_at->format('d M Y, H:i') }}
                                    </td>
                                    <td style="padding: 12px; text-align: right; font-weight: bold; color: #10b981;">
                                        Rp {{ number_format($order->total_price, 0) }}
                                    </td>
                                </tr>
                             @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        // Gradient
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(244, 63, 94, 0.5)'); // Primary color
        gradient.addColorStop(1, 'rgba(244, 63, 94, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: {!! json_encode($chartValues) !!},
                    borderColor: '#f43f5e',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#f43f5e',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.1)' },
                        ticks: { color: '#94a3b8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94a3b8' }
                    }
                }
            }
        });
    });

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const body = document.body;
        
        sidebar.classList.toggle('active');
        
        if (sidebar.classList.contains('active')) {
            overlay.style.display = 'block';
            body.style.overflow = 'hidden'; 
            document.getElementById('closeSidebarBtn').style.display = 'block';
        } else {
            overlay.style.display = 'none';
            body.style.overflow = 'auto';
            if(window.innerWidth <= 1024) document.getElementById('closeSidebarBtn').style.display = 'block';
            else document.getElementById('closeSidebarBtn').style.display = 'none';
        }
    }

    function toggleElement(id) {
        const el = document.getElementById(id);
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
    }

    function setActive(element) {
        document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
        element.classList.add('active');
        if(window.innerWidth <= 1024) toggleSidebar(); 
    }

    window.addEventListener('resize', () => {
        if(window.innerWidth > 1024) {
             document.getElementById('closeSidebarBtn').style.display = 'none';
             document.getElementById('sidebarOverlay').style.display = 'none';
             document.getElementById('sidebar').classList.remove('active');
        } else {
            document.getElementById('closeSidebarBtn').style.display = 'block';
        }
    });
    
    // Admin Theme Logic
    function toggleAdminTheme() {
        const body = document.body;
        const checkbox = document.getElementById('adminCheckbox');
        const sun = document.querySelector('.sun');
        const moon = document.querySelector('.moon');
        const knob = document.querySelector('.knob');
        
        body.classList.toggle('dark-mode');
        const isDark = body.classList.contains('dark-mode');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        
        // Update UI
        if(isDark) {
            if(knob) knob.style.transform = 'translateX(24px)';
            if(moon) moon.style.display = 'none';
            if(sun) sun.style.display = 'block';
        } else {
            if(knob) knob.style.transform = 'translateX(0)';
            if(moon) moon.style.display = 'block';
            if(sun) sun.style.display = 'none';
        }
    }

    // Initialize Admin Theme
    (function initAdminTheme() {
        const savedTheme = localStorage.getItem('theme');
        const checkbox = document.getElementById('adminCheckbox');
        const sun = document.querySelector('.sun');
        const moon = document.querySelector('.moon');
        const knob = document.querySelector('.knob');
        
        if (savedTheme === 'dark') {
            document.body.classList.add('dark-mode');
            if(checkbox) checkbox.checked = true;
            if(knob) knob.style.transform = 'translateX(24px)';
            if(moon) moon.style.display = 'none';
            if(sun) sun.style.display = 'block';
        }
    })();
    
    // Admin Chat Widget Polling
    let adminChatPolling;
    function startAdminChatPolling() {
        adminChatPolling = setInterval(async () => {
            try {
                const unreadCount = await fetch('/api/admin/unread-count').then(r => r.json());
                updateChatBadge(unreadCount.count);
            } catch (e) {
                console.error('Polling error:', e);
            }
        }, 10000); // Every 10 seconds
    }
    
    function updateChatBadge(count) {
        const badge = document.querySelector('.nav-link[href="{{ route('admin.chat.index') }}"] span');
        if (badge) {
            if (count > 0) {
                badge.textContent = count;
                badge.style.display = 'inline';
            } else {
                badge.style.display = 'none';
            }
        }
    }
    
    // Start polling
    startAdminChatPolling();
</script>


@endsection
