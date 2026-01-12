@extends('layouts.admin')

@section('content')
<div style="padding: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">💬 Customer Chat</h1>
            <p style="color: var(--text-muted); font-size: 0.95rem;">Kelola percakapan dengan pelanggan</p>
        </div>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1rem; background: rgba(139, 92, 246, 0.1); border-radius: 12px; border: 1.5px solid rgba(139, 92, 246, 0.3);">
                <input type="checkbox" id="adminOnlineToggle" onchange="toggleOnlineStatus(this)" style="width: 18px; height: 18px; cursor: pointer;">
                <span style="font-weight: 600; font-size: 0.95rem;">
                    <span id="statusText">Offline</span>
                    <span id="statusDot" style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #ef4444; margin-left: 8px;"></span>
                </span>
            </label>
        </div>
    </div>

    @if($sessions->count() > 0)
        <div style="display: grid; gap: 1.5rem;">
            @foreach($sessions as $session)
                <a href="{{ route('admin.chat.show', $session->session_id) }}" 
                   class="glass-panel" 
                   style="padding: 1.5rem; text-decoration: none; color: inherit; transition: all 0.3s ease; display: block;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 40px rgba(139, 92, 246, 0.15)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
                    
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                                @if(!empty($session->avatar))
                                    <img src="{{ $session->avatar }}" alt="Avatar" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.1);" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($session->user_name) }}&background=random';">
                                @else
                                    <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; font-weight: 700;">
                                        {{ substr($session->user_name ?? 'U', 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.25rem;">
                                        {{ $session->user_name ?? 'User' }}
                                    </h3>
                                    <p style="font-size: 0.85rem; color: var(--text-muted);">
                                        📱 {{ $session->user_phone ?? 'No phone' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div style="text-align: right;">
                            @if($session->unread_count > 0)
                                <div style="background: #ef4444; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem; display: inline-block;">
                                    {{ $session->unread_count }} baru
                                </div>
                            @endif
                            <p style="font-size: 0.8rem; color: var(--text-muted);">
                                {{ \Carbon\Carbon::parse($session->last_message_at)->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="glass-panel" style="padding: 3rem; text-align: center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 1rem; opacity: 0.5;">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
            <h3 style="font-size: 1.2rem; margin-bottom: 0.5rem; opacity: 0.7;">Belum Ada Chat</h3>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Percakapan dengan pelanggan akan muncul di sini</p>
        </div>
    @endif
</div>

<script>
// Check current online status on load
window.addEventListener('DOMContentLoaded', function() {
    fetch('/api/admin/online')
        .then(r => r.json())
        .then(data => {
            updateOnlineUI(data.online);
        });
});

function toggleOnlineStatus(checkbox) {
    const isOnline = checkbox.checked;
    
    fetch('/admin/chat/online-status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ online: isOnline })
    })
    .then(r => r.json())
    .then(data => {
        updateOnlineUI(data.online);
    });
}

function updateOnlineUI(isOnline) {
    const checkbox = document.getElementById('adminOnlineToggle');
    const statusText = document.getElementById('statusText');
    const statusDot = document.getElementById('statusDot');
    
    checkbox.checked = isOnline;
    statusText.textContent = isOnline ? 'Online' : 'Offline';
    statusDot.style.background = isOnline ? '#10b981' : '#ef4444';
}

// Auto refresh every 10 seconds
setInterval(() => {
    location.reload();
}, 10000);
</script>
@endsection
