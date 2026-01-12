# 🐛 DEBUG - Admin Reply ke User

## Test Step-by-Step

### 1️⃣ **Test Admin Kirim Pesan**

#### A. Buka Admin Dashboard
```
1. Login: http://localhost:8000/admin/login
2. Klik button 💬 pojok kanan bawah
3. Widget harus terbuka
```

#### B. Check Console (F12)
```javascript
// Pastikan tidak ada error
// Cek apakah fungsi ada:
typeof toggleAdminChat
// Harus return: "function"

typeof loadAdminChatSessions
// Harus return: "function"
```

#### C. Load Sessions
```
1. Widget terbuka otomatis load sessions
2. Check console untuk error
3. Check network tab:
   - Request: /api/admin/chat-sessions
   - Status: 200 OK
   - Response: Array of sessions
```

#### D. Klik Session
```
1. Klik salah satu session
2. Check console untuk error
3. Check network tab:
   - Request: /admin/chat/{sessionId}/messages/0
   - Status: 200 OK (jika authenticated)
   - Status: 401/403 (jika tidak authenticated)
```

#### E. Kirim Pesan
```
1. Ketik: "Test dari admin"
2. Klik Send
3. Check console untuk error
4. Check network tab:
   - Request: POST /admin/chat/{sessionId}/send
   - Status: 200 OK
   - Response: { success: true, message: {...} }
```

---

### 2️⃣ **Test Database**

#### Check Pesan Tersimpan
```sql
-- Buka MySQL/phpMyAdmin
SELECT * FROM chat_messages 
WHERE sender_type = 'admin' 
ORDER BY created_at DESC 
LIMIT 5;

-- Harus ada pesan dari admin
-- Check:
-- - session_id
-- - message
-- - created_at
```

---

### 3️⃣ **Test User Polling**

#### A. Buka User Chat (Browser Berbeda)
```
1. Buka: http://localhost:8000
2. Klik chat widget 💬
3. Kirim pesan: "Test dari user"
4. JANGAN TUTUP CHAT
```

#### B. Check Console User (F12)
```javascript
// Check session ID
localStorage.getItem('chat_session_id')
// Harus ada value

// Check polling berjalan
pollingInterval
// Harus return number (bukan null)

// Check lastMessageId
lastMessageId
// Harus return number > 0

// Manual trigger polling
pollAdminReplies()
// Check network tab untuk request
```

#### C. Check Network Tab
```
1. Filter: /api/chat/
2. Harus ada request setiap 5 detik:
   GET /api/chat/{sessionId}/messages/{lastId}
3. Check response:
   - Status: 200 OK
   - Response: Array (bisa kosong atau ada messages)
```

---

### 4️⃣ **Test End-to-End**

#### Setup
```
Browser 1 (Incognito): User
Browser 2 (Normal): Admin
```

#### Flow
```
1. User: Kirim "Halo"
   ↓
2. Admin: Buka widget, lihat session
   ↓
3. Admin: Klik session user
   ↓
4. Admin: Ketik "Halo juga", Send
   ↓
5. Check Database:
   SELECT * FROM chat_messages 
   WHERE session_id = 'xxx' 
   ORDER BY created_at;
   
   Harus ada:
   - User message
   - AI message
   - Admin message
   ↓
6. User: Tunggu 5 detik
   ↓
7. User: Check console network tab
   Request: /api/chat/{sessionId}/messages/{lastId}
   Response: Harus include admin message
   ↓
8. User: Lihat chat widget
   Admin message harus muncul
```

---

## 🔍 Common Issues

### Issue 1: Admin tidak bisa load sessions
**Symptom:**
- Widget terbuka tapi loading terus
- Console error: 401/403

**Debug:**
```javascript
// Check API
fetch('/api/admin/chat-sessions')
  .then(r => r.json())
  .then(console.log)
  .catch(console.error)
```

**Solution:**
- Route harus public (tidak perlu auth)
- Check routes/web.php

---

### Issue 2: Admin tidak bisa kirim pesan
**Symptom:**
- Klik Send tidak ada response
- Console error

**Debug:**
```javascript
// Check CSRF token
document.querySelector('meta[name="csrf-token"]').content
// Harus ada value

// Manual test send
fetch('/admin/chat/session_xxx/send', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
  },
  body: JSON.stringify({ message: 'Test' })
})
.then(r => r.json())
.then(console.log)
.catch(console.error)
```

**Solution:**
- Pastikan authenticated
- Check CSRF token
- Check route exists

---

### Issue 3: User tidak polling
**Symptom:**
- Admin kirim tapi user tidak terima
- Tidak ada request di network tab

**Debug:**
```javascript
// Check polling status
pollingInterval
// Harus return number

// Check chat visibility
document.getElementById('chatWidget').style.display
// Harus 'block' atau ''

// Manual start polling
startPolling()
```

**Solution:**
```javascript
// Restart polling
stopPolling()
startPolling()
```

---

### Issue 4: Polling berjalan tapi tidak muncul
**Symptom:**
- Request berhasil (200 OK)
- Response ada admin message
- Tapi tidak muncul di UI

**Debug:**
```javascript
// Check response
fetch('/api/chat/session_xxx/messages/0')
  .then(r => r.json())
  .then(data => {
    console.log('Messages:', data)
    // Harus ada admin message
  })

// Check lastMessageId
console.log('Last ID:', lastMessageId)

// Manual add message
addAdminMessageToUI({
  id: 999,
  sender_type: 'admin',
  message: 'Test manual',
  created_at: new Date().toISOString()
})
```

**Solution:**
- Check filter `msg.sender_type === 'admin'`
- Check lastMessageId update
- Check addAdminMessageToUI function

---

### Issue 5: Session ID tidak match
**Symptom:**
- Admin dan user punya session berbeda

**Debug:**
```sql
-- Check all sessions
SELECT DISTINCT session_id, user_name, user_phone 
FROM chat_messages;

-- Check messages per session
SELECT session_id, sender_type, message, created_at 
FROM chat_messages 
WHERE session_id = 'xxx' 
ORDER BY created_at;
```

**Solution:**
- Pastikan user dan admin menggunakan session_id yang sama
- User session_id dari localStorage
- Admin session_id dari database

---

## ✅ Success Checklist

- [ ] Admin widget terbuka
- [ ] Sessions list muncul
- [ ] Bisa klik session
- [ ] Chat history muncul
- [ ] Bisa ketik reply
- [ ] Send berhasil (200 OK)
- [ ] Pesan tersimpan di database
- [ ] User polling berjalan
- [ ] Request polling berhasil (200 OK)
- [ ] Response include admin message
- [ ] Admin message muncul di user chat
- [ ] Styling benar (hijau, label "Admin")
- [ ] Auto-scroll ke bawah

---

## 🚨 Quick Fix

Jika masih belum bisa, coba:

### 1. Clear Everything
```javascript
// User browser
localStorage.clear()
location.reload()
```

### 2. Fresh Test
```
1. User kirim pesan baru
2. Admin refresh dashboard
3. Admin buka widget
4. Admin balas
5. User tunggu 10 detik
```

### 3. Check Logs
```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Look for errors
```

### 4. Manual Database Check
```sql
-- Get latest session
SELECT session_id FROM chat_messages 
ORDER BY created_at DESC LIMIT 1;

-- Check all messages in that session
SELECT * FROM chat_messages 
WHERE session_id = 'xxx' 
ORDER BY created_at;
```

---

## 📞 Report Format

Jika masih error, berikan info:

```
1. Admin widget status:
   - Buka: [ ] Ya [ ] Tidak
   - Sessions muncul: [ ] Ya [ ] Tidak
   - Bisa kirim: [ ] Ya [ ] Tidak

2. Database:
   - Admin message ada: [ ] Ya [ ] Tidak
   - Session ID: ___________

3. User polling:
   - Polling berjalan: [ ] Ya [ ] Tidak
   - Request berhasil: [ ] Ya [ ] Tidak
   - Response ada admin msg: [ ] Ya [ ] Tidak

4. Console errors:
   [Paste error here]

5. Network errors:
   [Paste failed request]
```

---

**Ikuti langkah debug di atas untuk menemukan masalahnya!** 🔍
