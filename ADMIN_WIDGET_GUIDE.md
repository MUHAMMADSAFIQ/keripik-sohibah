# 💬 Admin Chat Widget - Panduan Penggunaan

## 🎯 Lokasi Widget

**Admin Chat Widget** adalah floating pop-up yang muncul di **pojok kanan bawah** dashboard admin, mirip seperti chat widget user.

---

## 📍 Cara Mengakses

### 1. **Login ke Admin Dashboard**
```
URL: http://localhost:8000/admin/login
```

### 2. **Lihat Floating Button**
- Di pojok kanan bawah, ada button bulat 💬
- Warna: Gradient ungu-biru
- Ukuran: 60x60px
- Hover: Membesar sedikit

### 3. **Klik Button**
- Widget pop-up akan terbuka
- Button akan hilang
- Widget menampilkan list chat sessions

---

## 🎨 Tampilan Widget

### **Header**
```
┌─────────────────────────────┐
│ Quick Chat                  │
│ Select a session         [✕]│
└─────────────────────────────┘
```

### **Sessions List**
```
┌─────────────────────────────┐
│ ┌─────────────────────────┐ │
│ │ John Doe           [2]  │ │ ← Unread badge
│ │ 081234567890            │ │
│ └─────────────────────────┘ │
│                             │
│ ┌─────────────────────────┐ │
│ │ Jane Smith              │ │
│ │ 089876543210            │ │
│ └─────────────────────────┘ │
└─────────────────────────────┘
```

### **Chat View (setelah klik session)**
```
┌─────────────────────────────┐
│ Quick Chat                  │
│ John Doe                 [✕]│
├─────────────────────────────┤
│                             │
│ [User] Halo, saya butuh...  │
│ [AI] Halo! Selamat datang...│
│ [You] Halo! Ada yang bisa...│
│                             │
├─────────────────────────────┤
│ [Type reply...]      [Send] │
│ ← Back to sessions          │
└─────────────────────────────┘
```

---

## ⚡ Fitur Widget

### 1. **List Sessions**
- ✅ Tampilkan 10 session terbaru
- ✅ Urutkan berdasarkan pesan terakhir
- ✅ Badge unread count (merah)
- ✅ Nama & nomor telepon user
- ✅ Click to open chat

### 2. **Chat View**
- ✅ History lengkap (user, AI, admin)
- ✅ Styling berbeda per sender:
  - **User**: Grey background
  - **AI**: Blue background
  - **You (Admin)**: Purple gradient
- ✅ Timestamp setiap pesan
- ✅ Auto-scroll ke bawah

### 3. **Quick Reply**
- ✅ Input box di bawah
- ✅ Send button
- ✅ Enter to send (coming soon)
- ✅ Pesan langsung terkirim
- ✅ Muncul di user chat dalam 5 detik

### 4. **Real-time Polling**
- ✅ Auto-refresh user messages (3 detik)
- ✅ Notifikasi badge update (10 detik)
- ✅ Hanya saat widget terbuka

### 5. **Navigation**
- ✅ Back button ke sessions list
- ✅ Close button (✕) tutup widget
- ✅ Smooth transitions

---

## 🔄 Workflow

```
1. Admin klik button 💬
   ↓
2. Widget terbuka, load sessions
   ↓
3. Admin klik session user
   ↓
4. Chat history muncul
   ↓
5. Admin ketik reply
   ↓
6. Klik Send
   ↓
7. Pesan terkirim ke database
   ↓
8. User polling (5 detik)
   ↓
9. Reply muncul di user chat
   ↓
10. ✅ DONE!
```

---

## 🎯 Keunggulan vs Halaman Chat

| Fitur | Halaman Chat | Widget Pop-up |
|-------|--------------|---------------|
| **Akses** | Harus klik menu | Floating button |
| **Posisi** | Full page | Pop-up overlay |
| **Multitasking** | Tidak bisa | ✅ Bisa sambil lihat dashboard |
| **Quick Reply** | Harus scroll | ✅ Langsung terlihat |
| **Real-time** | Manual refresh | ✅ Auto-polling |
| **UX** | Tradisional | ✅ Modern & smooth |

---

## 🐛 Troubleshooting

### **Issue 1: Button tidak terlihat**
**Solution:**
```
1. Refresh halaman (Ctrl+R)
2. Check console untuk error
3. Pastikan sudah login sebagai admin
4. Clear cache browser
```

### **Issue 2: Widget tidak terbuka**
**Solution:**
```javascript
// Buka console (F12)
toggleAdminChat()
// Harus membuka widget
```

### **Issue 3: Sessions tidak muncul**
**Solution:**
```
1. Pastikan ada user yang sudah chat
2. Check API: /api/admin/chat-sessions
3. Check database: SELECT * FROM chat_messages
```

### **Issue 4: Reply tidak terkirim**
**Solution:**
```
1. Check console untuk error
2. Pastikan input tidak kosong
3. Check CSRF token
4. Refresh halaman
```

---

## 💡 Tips Penggunaan

### **Best Practices:**
1. ✅ Buka widget saat monitoring chat
2. ✅ Tutup widget saat tidak digunakan (hemat resource)
3. ✅ Gunakan untuk quick reply
4. ✅ Untuk chat panjang, gunakan halaman chat

### **Keyboard Shortcuts (Coming Soon):**
- `Ctrl + K` - Toggle widget
- `Enter` - Send message
- `Esc` - Close widget

---

## 🎨 Customization

### **Ubah Posisi:**
```html
<!-- Di dashboard.blade.php -->
<div id="adminChatWidget" style="
    bottom: 20px;  ← Ubah ini
    right: 20px;   ← Ubah ini
">
```

### **Ubah Ukuran:**
```html
<div style="
    width: 380px;  ← Ubah ini
    height: 550px; ← Ubah ini
">
```

### **Ubah Warna:**
```html
<button style="
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    ← Ubah gradient
">
```

---

## 📊 Monitoring

### **Check Widget Status:**
```javascript
// Di console
document.getElementById('adminChatWidget').style.display
// 'none' = tertutup
// 'block' = terbuka
```

### **Check Polling:**
```javascript
adminMsgPolling
// null = tidak polling
// number = sedang polling
```

### **Check Current Session:**
```javascript
currentAdminSession
// null = tidak ada session terbuka
// 'session_xxx' = ada session aktif
```

---

## ✅ Checklist Fitur

- [x] Floating button pojok kanan bawah
- [x] Pop-up widget modern
- [x] List chat sessions
- [x] Unread badge
- [x] Chat history view
- [x] Quick reply input
- [x] Send message
- [x] Real-time polling
- [x] Back navigation
- [x] Close widget
- [x] Smooth animations
- [x] Responsive design

---

## 🚀 Next Steps

Setelah widget berfungsi:
1. ✅ Test kirim-balas chat
2. ✅ Monitor real-time updates
3. ✅ Cek notifikasi badge
4. ✅ Verify user menerima reply

---

**Widget siap digunakan! Klik button 💬 di pojok kanan bawah dashboard!** 🎉
