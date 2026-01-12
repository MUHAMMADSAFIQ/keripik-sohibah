<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keripik Sohibah - Renyah & Nikmat</title>
    
    <!-- Google Fonts - Inter for modern typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <nav class="glass-panel">
        <!-- Theme Toggle (Navbar - Left Side) -->
        <div class="theme-switch-wrapper">
           <label class="theme-switch" title="Ganti Tema">
                <input type="checkbox" id="checkbox" onchange="toggleTheme()">
                <div class="slider">
                     <span class="icon-moon">🌙</span>
                     <span class="icon-sun">☀️</span>
                </div>
           </label>
        </div>

        <!-- Auth Buttons -->
        @auth
            <div class="user-menu" style="margin-left: 15px; position: relative;">
                <div class="user-profile" onclick="toggleUserMenu()" style="cursor: pointer; display: flex; align-items: center; gap: 8px; padding: 5px 10px; background: rgba(255,255,255,0.1); border-radius: 20px; border: 1px solid rgba(255,255,255,0.2);">
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" alt="Profile" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                    @else
                        <div style="width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.9rem;">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                    <span class="user-name" style="font-size: 0.9rem; font-weight: 500; display: none; @media(min-width: 768px){display: block;}">{{ explode(' ', Auth::user()->name)[0] }}</span>
                </div>
                
                <!-- Dropdown -->
                <div id="userDropdown" style="position: absolute; top: 120%; left: 0; background: white; min-width: 150px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); padding: 5px; opacity: 0; transform: translateY(-10px); pointer-events: none; transition: all 0.2s; z-index: 1000;">
                    <div style="padding: 8px 12px; border-bottom: 1px solid #eee;">
                        <span style="display: block; font-size: 0.8rem; color: #888;">Halo,</span>
                        <span style="display: block; font-weight: 600; color: #333;">{{ Auth::user()->name }}</span>
                    </div>
                    @if(Auth::user()->is_admin ?? false)
                        <a href="{{ route('admin.dashboard') }}" style="display: block; padding: 8px 12px; color: #333; text-decoration: none; font-size: 0.9rem; border-radius: 6px; transition: background 0.1s;" onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='transparent'">Dashboard Admin</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" style="display: block; padding: 8px 12px; color: #333; text-decoration: none; font-size: 0.9rem; border-radius: 6px; transition: background 0.1s;" onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='transparent'">Profil Saya</a>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="width: 100%; text-align: left; padding: 8px 12px; color: #ef4444; background: none; border: none; font-size: 0.9rem; cursor: pointer; border-radius: 6px; transition: background 0.1s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'">Keluar</button>
                    </form>
                </div>
                
                <script>
                    function toggleUserMenu() {
                        const dropdown = document.getElementById('userDropdown');
                        if (dropdown.style.opacity === '0') {
                            dropdown.style.opacity = '1';
                            dropdown.style.transform = 'translateY(0)';
                            dropdown.style.pointerEvents = 'auto';
                        } else {
                            dropdown.style.opacity = '0';
                            dropdown.style.transform = 'translateY(-10px)';
                            dropdown.style.pointerEvents = 'none';
                        }
                    }
                    // Close on click outside
                    document.addEventListener('click', function(e) {
                         const profile = document.querySelector('.user-profile');
                         const dropdown = document.getElementById('userDropdown');
                         if (profile && dropdown && !profile.contains(e.target) && !dropdown.contains(e.target)) {
                             dropdown.style.opacity = '0';
                             dropdown.style.transform = 'translateY(-10px)';
                             dropdown.style.pointerEvents = 'none';
                         }
                    });
                </script>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn-login-nav" style="margin-left: 15px; text-decoration: none; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; font-weight: 600; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: inherit; transition: all 0.3s; display: flex; align-items: center; gap: 5px;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                <span>Login</span>
            </a>
        @endauth

        <a href="{{ route('home') }}" class="logo">Keripik Sohibah</a>
        
        <div class="mobile-menu-btn" onclick="toggleMenu()">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>

        <div class="nav-container" id="navMenu">
            <ul>
                <!-- Check if current route is home, otherwise redirect to home/#anchor -->
                @if(request()->routeIs('home'))
                    <li><a href="#home" onclick="closeMenu()">Home</a></li>
                    <li><a href="#menu" onclick="closeMenu()">Daftar Menu</a></li>
                    <li><a href="#testimonials" onclick="closeMenu()">Testimoni</a></li>
                    <li><a href="#mitra" onclick="closeMenu()">Mitra</a></li>
                    <li><a href="#contact" onclick="closeMenu()">Kontak Kami</a></li>
                    <li><a href="{{ route('order.track') }}" onclick="closeMenu()" style="color: var(--secondary);">Cek Status</a></li>
                @else
                    <li><a href="{{ route('home') }}#home">Home</a></li>
                    <li><a href="{{ route('home') }}#menu">Daftar Menu</a></li>
                    <li><a href="{{ route('home') }}#testimonials">Testimoni</a></li>
                    <li><a href="{{ route('home') }}#mitra">Mitra</a></li>
                    <li><a href="{{ route('home') }}#contact">Kontak Kami</a></li>
                    <li><a href="{{ route('order.track') }}" style="color: var(--secondary);">Cek Status</a></li>
                @endif
            </ul>
            <a href="{{ route('order.create') }}" class="btn nav-cta">Pesan Sekarang</a>
        </div>
    </nav>
    
    <div class="overlay" id="overlay" onclick="closeMenu()"></div>

    <main>
        @if(session('success'))
            <div class="container">
                <div class="alert">{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="container" style="color: red;">
                <div class="alert" style="background: rgba(255,0,0,0.1);">{{ session('error') }}</div>
            </div>
        @endif
        
        @if($errors->any())
            <div class="container" style="color: #ef4444; margin-bottom: 1rem;">
                <div class="alert" style="background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2025 Keripik Sohibah. All rights reserved.</p>
        <div style="margin-top: 15px; display: flex; justify-content: center; gap: 20px; align-items: center;">
             <!-- Instagram -->
            <a href="https://instagram.com/sohibah" target="_blank" style="transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="stroke: url(#ig-grad-footer); fill: none;">
                    <defs>
                        <linearGradient id="ig-grad-footer" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#f09433" />
                            <stop offset="25%" style="stop-color:#e6683c" />
                            <stop offset="50%" style="stop-color:#dc2743" />
                            <stop offset="75%" style="stop-color:#cc2366" />
                            <stop offset="100%" style="stop-color:#bc1888" />
                        </linearGradient>
                    </defs>
                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                </svg>
            </a>

            <!-- WhatsApp -->
            <a href="https://wa.me/6285643527635" target="_blank" style="transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#25D366" stroke="none">
                     <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.6 1.967.603 4.607.72 4.664.214.104 1.25.666 4.3 2.197l-1.041 3.013 2.51-.664z"/>
                </svg>
            </a>

            <!-- Facebook -->
            <a href="https://facebook.com/sohibah" target="_blank" style="transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#4267B2" stroke="none">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
            </a>
        </div>
    </footer>

    <!-- Chat System -->
    @include('admin.chat_widget')
    <!-- Enhanced Chat Widget (User) -->
    <div class="chat-toggle" onclick="toggleChat()" style="position: relative;">
        <span style="font-size: 1.5rem;">💬</span>
        <span id="chatBadge" style="position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; border-radius: 50%; width: 20px; height: 20px; font-size: 0.7rem; display: none; align-items: center; justify-content: center; font-weight: 700; animation: pulse 2s infinite;">1</span>
    </div>
    
    <div class="chat-widget" id="chatWidget" style="background: #efeae2; display: flex; flex-direction: column;">
        <!-- Chat Header -->
        <div class="chat-header" style="background: #008069; color: white; padding: 1rem 1.5rem; border-radius: 20px 20px 0 0; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); flex-shrink: 0; z-index: 10;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; overflow: hidden;">
                    <img src="https://ui-avatars.com/api/?name=Admin+Sohibah&background=25D366&color=fff" alt="Admin" style="width: 100%; height: 100%;">
                </div>
                <div>
                    <div style="font-weight: 600; font-size: 1rem; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">Admin Sohibah</div>
                    <div style="font-size: 0.75rem; opacity: 0.9;">Online 24/7</div>
                </div>
            </div>
            <button onclick="toggleChat()" style="background: transparent; border: none; color: white; width: 32px; height: 32px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                ×
            </button>
        </div>
        
        <!-- Chat Body with WhatsApp-like Background -->
        <div class="chat-body" id="chatBody" style="flex: 1; padding: 20px; overflow-y: auto; background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png'); background-repeat: repeat; background-size: 400px;">
            <!-- Welcome Message -->
            <div class="message bot">
                <div style="display: flex; max-width: 80%; background: white; border-radius: 0 12px 12px 12px; padding: 8px 10px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); position: relative; margin-bottom: 2px;">
                    <div style="font-size: 0.95rem; color: #111b21; line-height: 1.4; font-family: 'Segoe UI', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                        Halo Kak! 👋 Selamat datang di Keripik Sohibah.<br><br>
                        Ada yang bisa kami bantu hari ini? Silakan pilih menu di bawah atau tanya langsung ya! 😊
                    </div>
                    <div style="align-self: flex-end; font-size: 0.65rem; color: #667781; margin-left: 10px; min-width: 50px; text-align: right;">
                        <span id="botTime"></span>
                    </div>
                </div>
            </div>

            <!-- Typing Indicator (Hidden by default, moves with chat) -->
            <div id="typingIndicator" style="display: none; animation: slideInLeft 0.3s ease-out;">
                <div style="display: flex; gap: 10px; align-items: center;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                        🤖
                    </div>
                    <div style="background: white; padding: 12px 16px; border-radius: 16px 16px 16px 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid #e2e8f0;">
                        <div class="typing-dots">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Replies - Fixed Position -->
        <div id="quickReplies" style="padding: 1rem 1.5rem; display: flex; gap: 8px; flex-wrap: wrap; background: white; border-top: 1px solid #e2e8f0; flex-shrink: 0;">
            <button onclick="sendQuickReply('Produk apa saja yang tersedia?')" class="quick-reply-btn">
                🛍️ Produk
            </button>
            <button onclick="sendQuickReply('Berapa harga keripik?')" class="quick-reply-btn">
                💰 Harga
            </button>
            <button onclick="sendQuickReply('Bagaimana cara pesan?')" class="quick-reply-btn">
                📦 Cara Pesan
            </button>
            <button onclick="sendQuickReply('Ada promo apa?')" class="quick-reply-btn">
                🎁 Promo
            </button>
        </div>
        
        <!-- Chat Footer - Fixed at Bottom -->
        <div class="chat-footer" style="padding: 1rem 1.5rem; border-top: 1px solid var(--glass-border); background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); flex-shrink: 0;">
            <div style="display: flex; gap: 10px; align-items: center;">
                <input type="text" id="chatInput" placeholder="Ketik pesan Anda..." 
                       style="flex: 1; padding: 12px 16px; border-radius: 25px; border: 2px solid var(--glass-border); background: white; font-size: 0.95rem; transition: all 0.2s;"
                       onfocus="this.style.borderColor='var(--primary)'"
                       onblur="this.style.borderColor='var(--glass-border)'"
                       onkeypress="if(event.key === 'Enter') sendMessage()">
                <button class="btn" onclick="sendMessage()" 
                        style="width: 45px; height: 45px; border-radius: 50%; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: 0 4px 12px rgba(0,174,213,0.3); transition: all 0.2s; flex-shrink: 0;"
                        onmouseover="this.style.transform='scale(1.1) rotate(45deg)'"
                        onmouseout="this.style.transform='scale(1) rotate(0)'">
                    ➤
                </button>
            </div>
            <div style="margin-top: 8px; text-align: center; font-size: 0.7rem; color: #64748b; font-weight: 600;">
                Live Chat Support 💬
            </div>
        </div>
    </div>
    
    <style>
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.7; transform: scale(1.1); }
    }
    
    @keyframes slideInLeft {
        from { transform: translateX(-20px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideInRight {
        from { transform: translateX(20px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    .typing-dots {
        display: flex;
        gap: 4px;
    }
    
    .typing-dots span {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--primary);
        animation: typing 1.4s infinite;
    }
    
    .typing-dots span:nth-child(2) {
        animation-delay: 0.2s;
    }
    
    .typing-dots span:nth-child(3) {
        animation-delay: 0.4s;
    }
    
    @keyframes typing {
        0%, 60%, 100% { transform: translateY(0); opacity: 0.7; }
        30% { transform: translateY(-10px); opacity: 1; }
    }
    
    .quick-reply-btn {
    padding: 8px 16px;
    border-radius: 20px;
    border: 2px solid #cbd5e1;
    background: white; /* Solid white background */
    color: #1e293b; /* Dark text for visibility */
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
    font-weight: 700; /* Bolder font */
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.quick-reply-btn:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,174,213,0.3);
}
    
    .message.user {
        animation: slideInRight 0.3s ease-out;
    }
    
    .message.bot {
        animation: slideInLeft 0.3s ease-out;
    }
    </style>
    
    <script>
        // Mobile Menu Logic
        function toggleMenu() {
            document.getElementById('navMenu').classList.toggle('active');
            document.querySelector('.mobile-menu-btn').classList.toggle('open');
        }

        function closeMenu() {
            document.getElementById('navMenu').classList.remove('active');
            document.querySelector('.mobile-menu-btn').classList.remove('open');
        }

        // Close menu when clicking outside - FIXED to prevent conflicts
        document.addEventListener('click', function(event) {
            const nav = document.getElementById('navMenu');
            const btn = document.querySelector('.mobile-menu-btn');
            
            // Only process if nav exists and is active
            if (nav && btn && nav.classList.contains('active')) {
                if (!nav.contains(event.target) && !btn.contains(event.target)) {
                    closeMenu();
                }
            }

            // Close chat when clicking outside
            const chatWidget = document.getElementById('chatWidget');
            const chatToggle = document.querySelector('.chat-toggle');
            
            // Only process if chat exists and is open
            if (chatWidget && chatToggle && chatWidget.classList.contains('open')) {
                if (!chatWidget.contains(event.target) && !chatToggle.contains(event.target)) {
                    toggleChat();
                }
            }
        }, { passive: true }); // Add passive option for better performance

        function toggleChat() {
            const widget = document.getElementById('chatWidget');
            const badge = document.getElementById('chatBadge');
            widget.classList.toggle('open');
            
            // Manage polling based on open state
            if (widget.classList.contains('open')) {
                badge.style.display = 'none';
                startPolling(); // Start polling when opened
            } else {
                stopPolling(); // Stop polling when closed
            }
            
            // Update bot time on first open
            if (!document.getElementById('botTime').textContent) {
                updateBotTime();
            }
        }
        
        function updateBotTime() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            document.getElementById('botTime').textContent = timeStr;
        }

        function sendQuickReply(message) {
            document.getElementById('chatInput').value = message;
            sendMessage();
            // Hide quick replies after first use
            document.getElementById('quickReplies').style.display = 'none';
        }

        // Session management & User Info
        let chatSessionId;
        let userName = null;
        let userPhone = null;

        @auth
            const isLoggedIn = true;
            // Persistent session for logged in users
            chatSessionId = 'user_{{ Auth::id() }}'; 
            userName = "{{ Auth::user()->name }}";
            userPhone = "{{ Auth::user()->phone ?? '' }}";
            
            // Clean up guest session if exists to avoid confusion
            localStorage.removeItem('chat_session_id');
        @else
            const isLoggedIn = false;
            // Guest session from local storage
            chatSessionId = localStorage.getItem('chat_session_id');
            if (!chatSessionId) {
                chatSessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
                localStorage.setItem('chat_session_id', chatSessionId);
            }
            userName = localStorage.getItem('user_name');
            userPhone = localStorage.getItem('user_phone');
        @endauth

        // Check admin online status
        let adminOnline = false;
        async function checkAdminStatus() {
            try {
                const response = await fetch('/api/admin/online');
                const data = await response.json();
                adminOnline = data.online;
            } catch (e) {
                adminOnline = false;
            }
        }
        
        // Check on load and every 30 seconds
        checkAdminStatus();
        setInterval(checkAdminStatus, 30000);

        // Get checkmark icon based on status
        function getCheckmarkIcon(status) {
            if (status === 'read') {
                return `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline><polyline points="20 6 9 17 4 12" transform="translate(3, 0)"></polyline></svg>`;
            } else if (status === 'delivered') {
                return `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.7;"><polyline points="20 6 9 17 4 12"></polyline><polyline points="20 6 9 17 4 12" transform="translate(3, 0)"></polyline></svg>`;
            } else {
                return `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.7;"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
            }
        }

        async function sendMessage() {
            const input = document.getElementById('chatInput');
            const chatBody = document.getElementById('chatBody');
            const text = input.value.trim();
            
            if(!text) return;

            // Determine read status based on admin online
            const readStatus = adminOnline ? 'delivered' : 'sent';

            // ... (rest of UI logic same) ...

            // Add user message (WhatsApp Style: Green bubble on right)
            const userDiv = document.createElement('div');
            userDiv.className = 'message user';
            userDiv.style.display = 'flex';
            userDiv.style.justifyContent = 'flex-end';
            userDiv.style.marginBottom = '10px';
            userDiv.innerHTML = `
                <div style="background: #d9fdd3; color: #111b21; padding: 6px 7px 8px 9px; border-radius: 7.5px 0 7.5px 7.5px; box-shadow: 0 1px 0.5px rgba(0,0,0,0.13); max-width: 80%; display: flex; flex-direction: column; min-width: 100px;">
                    <div style="font-size: 0.95rem; line-height: 19px; font-family: 'Segoe UI', Helvetica, Arial, sans-serif;">${text}</div>
                    <div style="font-size: 0.68rem; color: #667781; margin-top: 2px; text-align: right; display: flex; align-items: center; justify-content: flex-end; gap: 3px; height: 15px;">
                        <span style="margin-right: 2px;">${new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}</span>
                        <span class="read-status">${getCheckmarkIcon(readStatus)}</span>
                    </div>
                </div>
            `;
            chatBody.appendChild(userDiv);
            
            input.value = '';
            chatBody.scrollTop = chatBody.scrollHeight;
            
            // Show typing indicator
            const typingIndicator = document.getElementById('typingIndicator');
            chatBody.appendChild(typingIndicator); 
            typingIndicator.style.display = 'block';
            chatBody.scrollTop = chatBody.scrollHeight;

            // Call API
            try {
                const response = await fetch('{{ route('chat') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 
                        message: text,
                        session_id: chatSessionId,
                        user_name: userName, // Use resolved variable
                        user_phone: userPhone
                    })
                });
                
                // Handle non-JSON responses (like 500 HTML pages)
                const contentType = response.headers.get("content-type");
                if (!contentType || !contentType.includes("application/json")) {
                    throw new Error("Server Error: Received non-JSON response");
                }

                const data = await response.json();
                
                if (data.error) {
                    throw new Error(data.error);
                }
                
                // Update session if returned (mostly for guest flow)
                if (data.session_id && !isLoggedIn) {
                    chatSessionId = data.session_id;
                    localStorage.setItem('chat_session_id', chatSessionId);
                }

                
                // Update last message ID for polling
                if (data.last_message_id) {
                    lastMessageId = data.last_message_id;
                }
                
                // Update read status if provided
                if (data.read_status && userDiv) {
                    const statusSpan = userDiv.querySelector('.read-status');
                    if (statusSpan) {
                        statusSpan.innerHTML = getCheckmarkIcon(data.read_status);
                    }
                }
                
                // Hide typing indicator
                typingIndicator.style.display = 'none';
                
                // Only show bot message if reply exists
                if (data.reply) {
                    const botDiv = document.createElement('div');
                    botDiv.className = 'message bot';
                    botDiv.style.animation = 'slideInLeft 0.3s ease-out';
                    
                    botDiv.innerHTML = `
                        <div style="display: flex; gap: 10px; align-items: start;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0;">
                                🤖
                            </div>
                            <div style="background: white; padding: 12px 16px; border-radius: 16px 16px 16px 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); max-width: 80%; border: 1px solid #e2e8f0;">
                                <div style="line-height: 1.6; color: #1e293b; font-weight: 500;">${data.reply.replace(/\n/g, '<br>')}</div>
                                <div style="font-size: 0.7rem; color: #64748b; margin-top: 5px; font-weight: 600;">
                                    ${new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}
                                </div>
                            </div>
                        </div>
                    `;
                    
                    chatBody.appendChild(botDiv);
                    
                    // Show WhatsApp button if needed
                    if (data.show_wa) {
                        const waDiv = document.createElement('div');
                        waDiv.className = 'message bot';
                        waDiv.style.marginTop = '10px';
                        waDiv.innerHTML = `
                            <div style="display: flex; gap: 10px;">
                                <div style="width: 32px;"></div>
                                <a href="https://wa.me/6285643527635?text=Halo%20Admin%20Keripik%20Sohibah" target="_blank" 
                                   style="background: #25D366; color: white; padding: 10px 20px; border-radius: 20px; text-decoration: none; font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3); transition: transform 0.2s;">
                                    <span>Chat Admin Manual</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592z"/>
                                    </svg>
                                </a>
                            </div>
                        `;
                        chatBody.appendChild(waDiv);
                    }
                }
                
                chatBody.scrollTop = chatBody.scrollHeight;
                
            } catch (e) {
                console.error(e);
                typingIndicator.style.display = 'none';
                
                const errDiv = document.createElement('div');
                errDiv.className = 'message bot';
                
                // Determine error message
                let errorMsg = e.message;
                if (!errorMsg || errorMsg === 'Failed to fetch') {
                    errorMsg = 'Maaf, terjadi kesalahan koneksi. Silakan coba lagi.';
                }
                
                errDiv.innerHTML = `
                    <div style="display: flex; gap: 10px; align-items: start;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0;">
                            🤖
                        </div>
                        <div style="background: #fee2e2; padding: 12px 16px; border-radius: 16px 16px 16px 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); max-width: 80%; border: 1px solid #fecaca;">
                            <div style="color: #dc2626;">⚠️ ${errorMsg}</div>
                        </div>
                    </div>
                `;
                chatBody.appendChild(errDiv);
                chatBody.scrollTop = chatBody.scrollHeight;
            }
        }

        // Poll for admin replies every 5 seconds
        let lastMessageId = 0;
        let isPolling = false;

        async function pollAdminReplies() {
            if (isPolling || !chatSessionId) return;
            
            isPolling = true;
            try {
                const response = await fetch(`/api/chat/${chatSessionId}/messages/${lastMessageId}`);
                const messages = await response.json();
                
                messages.forEach(msg => {
                    if (msg.sender_type === 'admin') {
                        addAdminMessageToUI(msg);
                        lastMessageId = Math.max(lastMessageId, msg.id);
                    }
                });
                
                if (messages.length > 0) {
                    const chatBody = document.getElementById('chatBody');
                    chatBody.scrollTop = chatBody.scrollHeight;
                }
            } catch (e) {
                console.error('Polling error:', e);
            } finally {
                isPolling = false;
            }
        }

        function addAdminMessageToUI(message) {
            const chatBody = document.getElementById('chatBody');
            const adminDiv = document.createElement('div');
            adminDiv.className = 'message admin';
            adminDiv.style.animation = 'slideInLeft 0.3s ease-out';
            adminDiv.style.marginBottom = '10px';
            adminDiv.style.display = 'flex'; // Ensure flex layout
            
            const time = new Date(message.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            
            // WhatsApp Style: White bubble on left with tail
            adminDiv.innerHTML = `
                <div style="max-width: 80%; background: white; border-radius: 0 12px 12px 12px; padding: 6px 7px 8px 9px; box-shadow: 0 1px 0.5px rgba(0,0,0,0.13); position: relative; display: flex; flex-direction: column; min-width: 100px;">
                    <div style="font-size: 0.8rem; font-weight: 700; color: #d64828; margin-bottom: 2px; font-family: 'Segoe UI', Helvetica, Arial, sans-serif;">Admin Sohibah</div>
                    <div style="font-size: 0.95rem; line-height: 19px; color: #111b21; font-family: 'Segoe UI', Helvetica, Arial, sans-serif;">${message.message}</div>
                    <div style="align-self: flex-end; font-size: 0.68rem; color: #667781; margin-top: 2px; height: 15px;">
                        ${time}
                    </div>
                </div>
            `;
            
            chatBody.appendChild(adminDiv);
        }

        // Start polling when chat is opened
        let pollingInterval;
        function startPolling() {
            if (pollingInterval) return;
            pollingInterval = setInterval(pollAdminReplies, 5000); // Poll every 5 seconds
        }

        function stopPolling() {
            if (pollingInterval) {
                clearInterval(pollingInterval);
                pollingInterval = null;
            }
        }
    // Layout cleaned

        // Scroll Animation Observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));

        // Theme Toggle Logic
        function toggleTheme() {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            
            // Sync checkbox
            const checkbox = document.getElementById('checkbox');
            if(checkbox) checkbox.checked = isDark;
        }

        // Initialize Theme
        document.addEventListener('DOMContentLoaded', () => {
             const savedTheme = localStorage.getItem('theme');
             const checkbox = document.getElementById('checkbox');
             
             if (savedTheme === 'dark') {
                 document.body.classList.add('dark-mode');
                 if(checkbox) checkbox.checked = true;
             }
        });

        // Navbar Scroll Effect & ScrollSpy
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 20) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
            
            // Active Link State
            const sections = document.querySelectorAll('section');
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= (sectionTop - 150)) {
                    current = section.getAttribute('id');
                }
            });
            
            if(current) {
                document.querySelectorAll('nav a').forEach(a => {
                    a.classList.remove('active');
                    if (a.getAttribute('href').includes('#' + current)) {
                        a.classList.add('active');
                    }
                });
            }
        });
        // Initialize Theme Logic...
        // Navbar Scroll Logic...

        // Custom Smooth Scroll for Anchor Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    e.preventDefault();
                    
                    // Close mobile menu if open
                    if(typeof closeMenu === 'function') closeMenu();
                    
                    // Calculate offset position (Header height approx 80px + 20px padding)
                    const headerOffset = 100;
                    const elementPosition = targetElement.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: "smooth"
                    });
                }
            });
        });
    </script>
    
    <!-- Mobile Bottom Navigation -->
    <div class="bottom-nav">
        <a href="{{ route('home') }}" class="bottom-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Home</span>
        </a>
        <a href="{{ route('home') }}#menu" class="bottom-nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <span>Menu</span>
        </a>
        <a href="{{ route('order.track') }}" class="bottom-nav-item {{ request()->routeIs('order.track') ? 'active' : '' }}">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            <span>Pesanan</span>
        </a>
        @auth
            <a href="{{ route('profile.edit') }}" class="bottom-nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Profil</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="bottom-nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                <span>Login</span>
            </a>
        @endauth
    </div>

    <!-- Advanced Animations & Interactions - DISABLED to fix auto-click issue -->
    <!-- <script src="{{ asset('js/animations.js') }}"></script> -->
</body>
</html>
