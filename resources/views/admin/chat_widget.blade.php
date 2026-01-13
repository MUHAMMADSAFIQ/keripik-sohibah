@if(Auth::guard('admin')->check() && request()->is('admin/*'))
<!-- Admin Chat Widget Component -->
@if(request()->is('admin/*'))
<style>
    /* Force Hide User Widget elements on Admin pages */
    .chat-toggle, .chat-widget, #chatWidget { display: none !important; }
</style>
@endif

<div id="adminChatWidget" style="position: fixed; bottom: 90px; right: 20px; z-index: 999999; display: none; opacity: 0; transform: translateY(20px); transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
    <div style="width: 380px; height: 500px; max-height: 70vh; background: #ffffff; border-radius: 18px; box-shadow: 0 5px 40px rgba(0,0,0,0.16); display: flex; flex-direction: column; overflow: hidden; border: 1px solid rgba(0,0,0,0.08);">
        
        <!-- View: Session List -->
        <div id="aw-view-sessions" style="display: flex; flex-direction: column; height: 100%;">
            <!-- Header -->
            <div style="padding: 16px; background: linear-gradient(135deg, #4f46e5, #9333ea); color: white; flex-shrink: 0;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700;">Customer Chats</h3>
                    <button id="aw-close-btn" style="background: rgba(255,255,255,0.2); border: none; color: white; width: 30px; height: 30px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">✕</button>
                </div>
            </div>
            
            <!-- List -->
            <div id="aw-session-list" style="flex: 1; overflow-y: auto;">
                <div style="padding: 2rem; text-align: center; color: #64748b;">
                    Memuat percakapan...
                </div>
            </div>
        </div>

        <!-- View: Chat Room -->
        <div id="aw-view-chat" style="display: none; flex-direction: column; height: 100%; position: relative;">
            <!-- Header -->
            <div style="padding: 10px 16px; background: #f0f2f5; border-bottom: 1px solid rgba(0,0,0,0.05); display: flex; align-items: center; gap: 12px; height: 60px; flex-shrink: 0;">
                <button id="aw-back-btn" style="border: none; background: transparent; cursor: pointer; padding: 5px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#54656f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                </button>
                <img id="aw-chat-avatar" src="" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
                <div style="flex: 1; overflow: hidden;">
                    <h4 id="aw-chat-name" style="margin: 0; font-size: 0.95rem; color: #111b21; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">User</h4>
                    <span style="font-size: 0.75rem; color: #54656f;">Online</span>
                </div>
            </div>
            
            <!-- Messages Area -->
            <div id="aw-chat-scroller" style="flex: 1; overflow-y: auto; padding: 16px; background-color: #f8fafc;">
                <!-- Msgs injected here -->
            </div>

            <!-- Input Area -->
            <div style="padding: 10px; background: #f0f2f5; display: flex; align-items: center; gap: 8px;">
                <input type="text" id="aw-msg-input" placeholder="Ketik pesan..." style="flex: 1; padding: 10px 16px; border-radius: 20px; border: 1px solid transparent; outline: none; font-size: 0.95rem; color: #000000; background: #ffffff;">
                <button id="aw-send-btn" style="width: 40px; height: 40px; border-radius: 50%; border: none; background: linear-gradient(135deg, #4f46e5, #9333ea); color: white; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Floating Button -->
<button id="adminChatBtn" 
    style="position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #4f46e5, #9333ea); color: white; border: none; box-shadow: 0 4px 20px rgba(79, 70, 229, 0.4); z-index: 999990; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: transform 0.2s;">
    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
    <span id="aw-badge" style="position: absolute; top: 0; right: 0; background: #ef4444; width: 22px; height: 22px; border-radius: 50%; font-size: 0.75rem; display: none; align-items: center; justify-content: center; font-weight: 700; border: 2px solid var(--dark);">0</span>
</button>

<script>
(function() {
    // Scoped Admin Widget Logic
    const state = {
        isOpen: false,
        sessionId: null,
        timer: null,
        lastId: 0
    };

    const els = {
        widget: document.getElementById('adminChatWidget'),
        btn: document.getElementById('adminChatBtn'),
        viewSessions: document.getElementById('aw-view-sessions'),
        viewChat: document.getElementById('aw-view-chat'),
        list: document.getElementById('aw-session-list'),
        scroller: document.getElementById('aw-chat-scroller'),
        input: document.getElementById('aw-msg-input'),
        avatar: document.getElementById('aw-chat-avatar'),
        name: document.getElementById('aw-chat-name'),
        badge: document.getElementById('aw-badge')
    };

    // Event Listeners
    if(els.btn) els.btn.onclick = toggleWidget;
    if(document.getElementById('aw-close-btn')) document.getElementById('aw-close-btn').onclick = toggleWidget;
    if(document.getElementById('aw-back-btn')) document.getElementById('aw-back-btn').onclick = () => switchView('sessions');
    if(document.getElementById('aw-send-btn')) document.getElementById('aw-send-btn').onclick = sendMessage;
    if(document.getElementById('aw-send-btn')) document.getElementById('aw-send-btn').onclick = sendMessage;
    if(els.input) els.input.onkeypress = (e) => { if(e.key === 'Enter') sendMessage(); };

    // Click Outside to Close Logic
    document.addEventListener('click', function(e) {
        if (state.isOpen && !els.widget.contains(e.target) && !els.btn.contains(e.target)) {
            toggleWidget();
        }
    });

    function toggleWidget() {
        state.isOpen = !state.isOpen;
        if (state.isOpen) {
            els.widget.style.display = 'block';
            setTimeout(() => { els.widget.style.opacity = '1'; els.widget.style.transform = 'translateY(0)'; }, 10);
            els.btn.style.transform = 'scale(0.8)';
            els.btn.style.opacity = '0';
            setTimeout(() => els.btn.style.display = 'none', 200);
            loadList();
            startPoll(true);
        } else {
            els.widget.style.opacity = '0';
            els.widget.style.transform = 'translateY(20px)';
            setTimeout(() => els.widget.style.display = 'none', 300);
            els.btn.style.display = 'flex';
            setTimeout(() => { els.btn.style.opacity = '1'; els.btn.style.transform = 'scale(1)'; }, 10);
            state.sessionId = null;
            startPoll(false);
        }
    }

    function switchView(view) {
        els.viewSessions.style.display = view === 'sessions' ? 'flex' : 'none';
        els.viewChat.style.display = view === 'chat' ? 'flex' : 'none';
        if(view === 'sessions') {
            state.sessionId = null;
            loadList();
        }
    }

    async function loadList() {
        try {
            const res = await fetch('{{ route("admin.chat.index") }}', { 
                headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'} 
            });
            const data = await res.json();
            renderList(data);
            updateBadge(data);
        } catch(e) {
            console.error(e);
            els.list.innerHTML = '<div style="padding:1rem; text-align:center; color:red">Error loading chats</div>';
        }
    }

    function renderList(sessions) {
        if(!sessions || !sessions.length) {
            els.list.innerHTML = '<div style="padding:2rem; text-align:center; color:#888;">Belum ada percakapan</div>';
            return;
        }
        
        let html = '';
        sessions.forEach(s => {
            const isUnread = s.unread_count > 0;
            const preview = s.last_message ? (s.last_message.length > 25 ? s.last_message.substring(0,25)+'...' : s.last_message) : 'File';
            const safeName = s.user_name.replace(/'/g, "\\'");
            const avatar = `https://ui-avatars.com/api/?name=${encodeURIComponent(s.user_name)}&background=random`;
            
            html += `
            <div data-id="${s.session_id}" data-name="${s.user_name}" data-avatar="${avatar}" class="aw-chat-item"
                 style="display: flex; gap: 12px; padding: 12px 16px; cursor: pointer; border-bottom: 1px solid rgba(0,0,0,0.05);">
                <img src="${avatar}" style="width: 48px; height: 48px; border-radius: 50%;">
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-weight: 600;">${s.user_name}</span>
                        <span style="font-size: 0.75rem; color: #888;">${s.time_ago || ''}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.85rem; color: #666;">${preview}</span>
                        ${isUnread ? `<span style="background: #10b981; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.7rem;">${s.unread_count}</span>` : ''}
                    </div>
                </div>
            </div>`;
        });
        
        els.list.innerHTML = html;
        
        els.list.querySelectorAll('.aw-chat-item').forEach(el => {
            el.onclick = () => openChat(el.dataset.id, el.dataset.name, el.dataset.avatar);
        });
    }

    function updateBadge(sessions) {
        let count = 0;
        if(sessions) sessions.forEach(s => count += parseInt(s.unread_count||0));
        if(count > 0) {
            els.badge.innerText = count;
            els.badge.style.display = 'flex';
        } else {
            els.badge.style.display = 'none';
        }
    }

    async function openChat(id, name, avatar) {
        state.sessionId = id;
        state.lastId = 0;
        els.name.innerText = name;
        els.avatar.src = avatar;
        els.scroller.innerHTML = '<div style="text-align:center; padding:1rem; color:#888;">Load...</div>';
        
        switchView('chat');
        await loadMessages();
        
        // Mark read
        fetch(`/admin/chat/${id}?json=true`, { headers: {'Accept': 'application/json'} });
    }

    async function loadMessages() {
        if(!state.sessionId) return;
        try {
            const res = await fetch(`/admin/chat/${state.sessionId}/messages/0`);
            const msgs = await res.json();
            renderMessages(msgs, true);
        } catch(e) { console.error(e); }
    }

    function renderMessages(msgs, replace = false) {
        if(replace) els.scroller.innerHTML = '';
        if(!msgs.length) return;
        
        state.lastId = msgs[msgs.length - 1].id;
        
        msgs.forEach(m => {
            const isMe = m.sender_type !== 'user'; 
            const div = document.createElement('div');
            div.style.cssText = `display: flex; margin-bottom: 8px; justify-content: ${isMe ? 'flex-end' : 'flex-start'}`;
            
            const content = `
            <div style="max-width: 80%; padding: 6px 10px; background: ${isMe ? '#d9fdd3' : '#f3f4f6'}; color: #000000; border-radius: 8px; box-shadow: 0 1px 1px rgba(0,0,0,0.1);">
                ${!isMe ? `<div style="font-size: 0.75rem; font-weight: bold; color: #d64828; margin-bottom: 4px;">${els.name.innerText}</div>` : ''}
                <div style="word-wrap: break-word; font-size: 0.9rem;">${m.message}</div>
                <div style="text-align: right; font-size: 0.65rem; color: #888;">
                    ${new Date(m.created_at).toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit'})}
                </div>
            </div>`;
            div.innerHTML = content;
            els.scroller.appendChild(div);
        });
        els.scroller.scrollTop = els.scroller.scrollHeight;
    }

    async function sendMessage() {
        const text = els.input.value.trim();
        if(!text || !state.sessionId) return;
        els.input.value = '';
        
        renderMessages([{
            id: state.lastId + 1,
            sender_type: 'admin',
            message: text,
            created_at: new Date().toISOString()
        }]);
        
        try {
            const token = document.querySelector('meta[name="csrf-token"]').content;
            await fetch(`/admin/chat/${state.sessionId}/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ message: text })
            });
        } catch(e) { console.error(e); }
    }

    function startPoll(fast) {
        if(state.timer) clearInterval(state.timer);
        state.timer = setInterval(() => {
            if(!state.isOpen) {
               // Only badge
               fetch('{{ route("admin.chat.index") }}', 
                   { headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'} })
                   .then(r=>r.json()).then(d=>updateBadge(d)).catch(()=>{});
            } else {
                if(state.sessionId && els.viewChat.style.display !== 'none') {
                    // Poll messages
                    fetch(`/admin/chat/${state.sessionId}/messages/${state.lastId}`)
                        .then(r=>r.json()).then(d=>renderMessages(d));
                }
            }
        }, fast ? 3000 : 10000);
    }
    
    // Auto start polling
    startPoll(false); 

})();
</script>
@endif
