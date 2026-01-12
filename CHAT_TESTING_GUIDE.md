# 🧪 Quick Test Guide - Customer Support Chat System

## ✅ Checklist Testing

### **1. Database Check**
```bash
# Pastikan migration sudah jalan
php artisan migrate:status

# Seharusnya ada:
# ✓ 2026_01_10_093859_create_chat_messages_table
```

### **2. Test User Chat Widget**

#### **A. Buka Homepage**
```
URL: http://localhost:8000
```

#### **B. Buka Chat Widget**
- Klik icon chat di pojok kanan bawah
- Widget harus terbuka dengan smooth animation

#### **C. Test AI Chat**
Coba kirim pesan berikut:
```
1. "Halo" → Harus dapat greeting
2. "Menu apa saja?" → Harus tampil daftar produk
3. "Berapa harga?" → Harus tampil range harga
4. "Cara pesan?" → Harus dapat panduan
5. "Hubungi admin" → Harus muncul tombol WhatsApp
```

#### **D. Check Status Centang**
- Pesan pertama harus ada centang ✓ (admin offline)
- Jika admin online, harus centang ✓✓

---

### **3. Test Admin Dashboard**

#### **A. Login Admin**
```
URL: http://localhost:8000/admin/login
Email: admin@sohibah.com (atau sesuai seeder)
Password: password
```

#### **B. Akses Chat Menu**
- Klik "Customer Chat" di sidebar
- Harus muncul list chat sessions
- Badge merah menunjukkan unread count

#### **C. Test Online Status**
- Toggle switch "Online/Offline"
- Status harus tersimpan
- User chat widget harus update centang

#### **D. Test Reply Chat**
- Klik salah satu session
- Ketik pesan: "Halo, ada yang bisa saya bantu?"
- Klik "Kirim"
- Pesan harus muncul di chat

#### **E. Check Real-time**
- Buka 2 tab browser:
  - Tab 1: User chat widget
  - Tab 2: Admin chat detail
- Kirim pesan dari user
- Pesan harus muncul di admin dalam 3 detik
- Balas dari admin
- Pesan harus muncul di user (refresh widget)

---

### **4. Test Read Status**

#### **Scenario 1: Admin Offline**
```
1. Set admin status = Offline
2. User kirim pesan
3. Check centang: Harus ✓ (single grey)
```

#### **Scenario 2: Admin Online**
```
1. Set admin status = Online
2. User kirim pesan
3. Check centang: Harus ✓✓ (double grey)
```

#### **Scenario 3: Admin Read**
```
1. Admin buka chat detail
2. Check centang di user: Harus ✓✓ (double blue)
```

---

### **5. Test Session Persistence**

#### **A. Check LocalStorage**
```javascript
// Buka Console (F12)
localStorage.getItem('chat_session_id')
// Harus ada value seperti: "session_1736507234_abc123"
```

#### **B. Test Session Continuity**
```
1. User kirim pesan "Test 1"
2. Refresh halaman
3. Buka chat widget lagi
4. Kirim pesan "Test 2"
5. Admin harus lihat kedua pesan dalam 1 session
```

---

### **6. Test Error Handling**

#### **A. Network Error**
```
1. Matikan internet
2. Kirim pesan dari user
3. Harus muncul error message merah
4. Nyalakan internet
5. Kirim lagi, harus berhasil
```

#### **B. Invalid Session**
```
1. Clear localStorage
2. Kirim pesan
3. Harus auto-create session baru
```

---

### **7. Test Performance**

#### **A. Load Time**
```
- Homepage load: < 2 detik
- Chat widget open: < 500ms
- AI response: < 3 detik
- Admin dashboard: < 2 detik
```

#### **B. Concurrent Users**
```
1. Buka 3 tab berbeda (incognito)
2. Kirim pesan dari masing-masing
3. Semua harus punya session berbeda
4. Admin harus lihat 3 session terpisah
```

---

### **8. Test Database**

#### **A. Check Data**
```sql
-- Lihat semua chat messages
SELECT * FROM chat_messages ORDER BY created_at DESC LIMIT 10;

-- Count unread
SELECT COUNT(*) FROM chat_messages 
WHERE sender_type = 'user' AND is_read = 0;

-- Sessions
SELECT DISTINCT session_id, user_name, user_phone 
FROM chat_messages;
```

#### **B. Check Indexes**
```sql
SHOW INDEXES FROM chat_messages;
-- Harus ada index pada session_id
```

---

## 🐛 Common Issues & Solutions

### **Issue 1: Chat widget tidak muncul**
**Solution:**
```bash
# Clear cache
php artisan cache:clear
php artisan view:clear

# Hard refresh browser
Ctrl + Shift + R
```

### **Issue 2: AI tidak merespons**
**Solution:**
```bash
# Check .env
cat .env | grep GEMINI_API_KEY

# Test fallback
# Kirim pesan "menu" → harus tetap dapat respons
```

### **Issue 3: Admin tidak bisa login**
**Solution:**
```bash
# Create admin user
php artisan tinker
>>> User::create(['name'=>'Admin','email'=>'admin@test.com','password'=>bcrypt('password')]);
```

### **Issue 4: Centang tidak update**
**Solution:**
```javascript
// Clear localStorage
localStorage.clear();

// Refresh halaman
location.reload();
```

### **Issue 5: Session hilang**
**Solution:**
```bash
# Check session driver di .env
SESSION_DRIVER=file

# Clear session
php artisan session:clear
```

---

## ✅ Expected Results

### **User Side:**
- ✅ Chat widget smooth & responsive
- ✅ AI merespons < 3 detik
- ✅ Centang status update otomatis
- ✅ Session persistent setelah refresh
- ✅ Error handling graceful

### **Admin Side:**
- ✅ List chat sessions dengan unread badge
- ✅ Real-time message polling
- ✅ Reply terkirim instant
- ✅ Online status toggle works
- ✅ Read status auto-update

### **Database:**
- ✅ Semua pesan tersimpan
- ✅ Session tracking akurat
- ✅ Read status correct
- ✅ Timestamps accurate

---

## 📊 Test Report Template

```
=== CHAT SYSTEM TEST REPORT ===
Date: [DATE]
Tester: [NAME]

1. User Chat Widget: [ ] PASS [ ] FAIL
   - Open widget: [ ] OK
   - Send message: [ ] OK
   - AI response: [ ] OK
   - Checkmarks: [ ] OK

2. Admin Dashboard: [ ] PASS [ ] FAIL
   - Login: [ ] OK
   - View sessions: [ ] OK
   - Reply chat: [ ] OK
   - Online status: [ ] OK

3. Read Status: [ ] PASS [ ] FAIL
   - Single check: [ ] OK
   - Double check: [ ] OK
   - Blue check: [ ] OK

4. Session Tracking: [ ] PASS [ ] FAIL
   - Create session: [ ] OK
   - Persist session: [ ] OK
   - Multiple sessions: [ ] OK

5. Performance: [ ] PASS [ ] FAIL
   - Load time: [ ] OK
   - Response time: [ ] OK
   - Real-time update: [ ] OK

Overall Status: [ ] PASS [ ] FAIL

Notes:
[Add any issues or observations]
```

---

## 🚀 Next Steps After Testing

1. **If All Tests Pass:**
   - Deploy to production
   - Monitor logs for 24 hours
   - Collect user feedback

2. **If Tests Fail:**
   - Document errors
   - Check logs: `storage/logs/laravel.log`
   - Fix issues
   - Re-test

3. **Production Checklist:**
   - [ ] Set proper GEMINI_API_KEY
   - [ ] Configure cache driver (Redis recommended)
   - [ ] Set up queue for async tasks
   - [ ] Enable error monitoring (Sentry)
   - [ ] Backup database
   - [ ] Test on mobile devices

---

**Happy Testing! 🎉**
