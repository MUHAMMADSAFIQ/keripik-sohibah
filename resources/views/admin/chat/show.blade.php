@extends('layouts.admin')

@section('content')
<style>
    /* Chat Container Styles */
    .message-row {
        display: flex;
        gap: 12px;
        margin-bottom: 12px;
        width: 100%;
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .message-row.user { justify-content: flex-start; }
    .message-row.admin { justify-content: flex-end; }
    .message-row.ai { justify-content: flex-start; }

    .message-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 2px solid rgba(255,255,255,0.1);
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        margin-top: 4px;
    }

    .message-bubble {
        max-width: 65%;
        padding: 10px 16px;
        position: relative;
        font-size: 0.95rem;
        line-height: 1.5;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        word-wrap: break-word;
    }

    .message-bubble.user {
        background: rgba(255, 255, 255, 0.08);
        color: #e2e8f0;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 4px 18px 18px 18px; /* Tail top-left */
    }

    .message-bubble.admin {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border-radius: 18px 4px 18px 18px; /* Tail top-right */
        border: none;
    }

    .message-bubble.ai {
        background: rgba(139, 92, 246, 0.1);
        color: #e2e8f0;
        border: 1px solid rgba(139, 92, 246, 0.3);
        border-radius: 4px 18px 18px 18px;
    }

    .message-time {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 0.7rem;
        margin-top: 4px;
        opacity: 0.7;
        justify-content: flex-end;
    }
    
    .message-status-icon { width: 14px; height: 14px; opacity: 0.9; }

    /* Scrollbar */
    #chatMessages::-webkit-scrollbar { width: 6px; }
    #chatMessages::-webkit-scrollbar-track { background: transparent; }
    #chatMessages::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
    #chatMessages::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.3); }
</style>

<div style="padding: 2rem; max-width: 1000px; margin: 0 auto;">
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.chat.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--text-muted); text-decoration: none; font-weight: 500; font-size: 0.9rem; margin-bottom: 1rem; transition: color 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='var(--text-muted)'">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Kembali
        </a>
        
        <div class="glass-panel" style="padding: 1rem; display: flex; align-items: center; gap: 1rem; border-radius: 16px;">
            @php
                $userAvatar = !empty($session->avatar) ? $session->avatar : 'https://ui-avatars.com/api/?name='.urlencode($session->user_name ?? 'User').'&background=random';
            @endphp
            <img src="{{ $userAvatar }}" alt="Profile" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.2);">
            <div>
                <h1 style="font-size: 1.25rem; font-weight: 700; margin: 0; color: white;">{{ $session->user_name ?? 'User' }}</h1>
                <p style="color: var(--text-muted); font-size: 0.85rem; margin: 2px 0 0 0;">📱 {{ $session->user_phone ?? '-' }}</p>
            </div>
            <div style="margin-left: auto;">
                 <!-- Optional: Delete or Archive actions here -->
            </div>
        </div>
    </div>

    <div class="glass-panel" style="padding: 0; height: 600px; display: flex; flex-direction: column; overflow: hidden;">
        <!-- Chat Messages -->
        <div id="chatMessages" style="flex: 1; overflow-y: auto; padding: 1.5rem; display: flex; flex-direction: column;">
            @foreach($messages as $message)
                @if($message->sender_type === 'user')
                    <div class="message-row user">
                        <img src="{{ $userAvatar }}" class="message-avatar" onerror="this.src='https://ui-avatars.com/api/?name=U&background=random'">
                        <div class="message-bubble user">
                            {{ $message->message }}
                            <div class="message-time">
                                {{ $message->created_at->format('H:i') }}
                            </div>
                        </div>
                    </div>
                @elseif($message->sender_type === 'ai')
                    <div class="message-row ai">
                         <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #8b5cf6, #3b82f6); display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.2); margin-top: 4px; flex-shrink: 0;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                        </div>
                        <div class="message-bubble ai">
                            <span style="font-size: 0.75rem; font-weight: 700; color: var(--primary); display: block; margin-bottom: 4px;">AI Bot</span>
                            {{ $message->message }}
                            <div class="message-time">
                                {{ $message->created_at->format('H:i') }}
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Admin Message -->
                    <div class="message-row admin">
                        <div class="message-bubble admin">
                            {{ $message->message }}
                            <div class="message-time" style="justify-content: flex-end; color: rgba(255,255,255,0.8);">
                                {{ $message->created_at->format('H:i') }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="message-status-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Message Input -->
        <div style="padding: 1.25rem; background: rgba(0,0,0,0.25); border-top: 1px solid rgba(255,255,255,0.05);">
            <form id="replyForm" onsubmit="sendReply(event)" style="display: flex; gap: 1rem; align-items: center;">
                @csrf
                <input type="text" 
                       id="messageInput" 
                       placeholder="Ketik pesan balasan..." 
                       required
                       style="flex: 1; padding: 12px 16px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); border-radius: 24px; color: white; font-size: 0.95rem; outline: none; transition: all 0.2s;"
                       onfocus="this.style.borderColor='var(--primary)'; this.style.background='rgba(255,255,255,0.12)';"
                       onblur="this.style.borderColor='rgba(255,255,255,0.1)'; this.style.background='rgba(255,255,255,0.08)';">
                
                <button type="submit" 
                        class="btn" 
                        style="width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 0; background: linear-gradient(135deg, var(--primary), var(--secondary)); border: none; cursor: pointer; transition: transform 0.2s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.3);"
                        onmouseover="this.style.transform='scale(1.1)'"
                        onmouseout="this.style.transform='scale(1)'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 2px;">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
let lastMessageId = {{ $messages->last()->id ?? 0 }};
const sessionId = '{{ $sessionId }}';
const userAvatarUrl = '{{ $userAvatar }}'; // Global Var for JS

// Scroll to bottom
window.addEventListener('DOMContentLoaded', scrollToBottom);

function scrollToBottom() {
    const chatMessages = document.getElementById('chatMessages');
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function sendReply(event) {
    event.preventDefault();
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    const btn = event.target.querySelector('button');
    
    if (!message) return;
    
    const originalContent = btn.innerHTML;
    btn.disabled = true;
    btn.style.opacity = '0.7';
    
    fetch(`/admin/chat/${sessionId}/send`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ message: message })
    })
    .then(r => r.ok ? r.json() : r.text().then(t => { throw new Error(t) }))
    .then(data => {
        if (data.success) {
            input.value = '';
            addMessageToUI(data.message);
            scrollToBottom();
        }
    })
    .catch(err => alert('Error: ' + err.message))
    .finally(() => {
        btn.disabled = false;
        btn.style.opacity = '1';
    });
}

function addMessageToUI(message) {
    const chatMessages = document.getElementById('chatMessages');
    const div = document.createElement('div');
    div.className = 'message-row admin'; // New Class Structure
    const time = new Date(message.created_at).toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
    
    div.innerHTML = `
        <div class="message-bubble admin">
            ${message.message}
            <div class="message-time" style="color: rgba(255,255,255,0.8);">
                ${time}
                <svg xmlns="http://www.w3.org/2000/svg" class="message-status-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
        </div>
    `;
    chatMessages.appendChild(div);
    lastMessageId = message.id;
}

function addUserMessageToUI(message) {
    const chatMessages = document.getElementById('chatMessages');
    const div = document.createElement('div');
    div.className = 'message-row user';
    const time = new Date(message.created_at).toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
    
    div.innerHTML = `
        <img src="${userAvatarUrl}" class="message-avatar" onerror="this.src='https://ui-avatars.com/api/?name=U&background=random'">
        <div class="message-bubble user">
            ${message.message}
            <div class="message-time">
                ${time}
            </div>
        </div>
    `;
    chatMessages.appendChild(div);
}

// Poll logic remains same...
setInterval(() => {
    fetch(`/admin/chat/${sessionId}/messages/${lastMessageId}`)
        .then(r => r.json())
        .then(messages => {
            if(messages.length > 0) {
                messages.forEach(msg => {
                    if (msg.sender_type === 'user') {
                        addUserMessageToUI(msg);
                    }
                    lastMessageId = msg.id;
                });
                scrollToBottom();
            }
        });
}, 3000);
</script>
@endsection
