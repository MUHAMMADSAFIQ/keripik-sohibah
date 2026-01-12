# 💬 Customer Support Chat System - Dokumentasi Lengkap

## 🎯 Fitur Utama

### 1. **AI Chatbot Cerdas**
- ✅ Menggunakan Google Gemini AI untuk respons natural
- ✅ Fallback AI lokal yang sangat cerdas jika API gagal
- ✅ Konteks produk real-time dari database
- ✅ Rekomendasi produk otomatis
- ✅ Multi-bahasa support (Indonesia)

### 2. **Admin Chat Management**
- ✅ Dashboard untuk melihat semua percakapan
- ✅ Notifikasi pesan belum dibaca
- ✅ Balas pesan pelanggan secara real-time
- ✅ Status online/offline admin
- ✅ Auto-refresh setiap 10 detik

### 3. **Read Status (Centang)**
- ✅ **Centang 1 (✓)** - Admin offline, pesan terkirim
- ✅ **Centang 2 (✓✓)** - Admin online, pesan terkirim
- ✅ **Centang Biru (✓✓)** - Admin sudah membaca pesan

### 4. **Session Tracking**
- ✅ Setiap user memiliki session ID unik
- ✅ Riwayat chat tersimpan per session
- ✅ Admin dapat melihat history lengkap

---

## 📁 Struktur File

### **Database**
```
database/migrations/
└── 2026_01_10_093859_create_chat_messages_table.php
```

### **Models**
```
app/Models/
└── ChatMessage.php
```

### **Controllers**
```
app/Http/Controllers/
├── HomeController.php (updated)
└── AdminChatController.php
```

### **Views**
```
resources/views/
├── admin/
│   └── chat/
│       ├── index.blade.php (List semua chat)
│       └── show.blade.php (Detail chat & reply)
├── layouts/
│   ├── admin.blade.php (Layout admin)
│   └── app.blade.php (updated - chat widget)
└── admin/
    └── dashboard.blade.php (updated - link chat)
```

### **Routes**
```
routes/
└── web.php (updated)
```

---

## 🚀 Cara Menggunakan

### **Untuk Admin:**

#### 1. **Login ke Admin Panel**
```
URL: /admin/login
```

#### 2. **Akses Customer Chat**
- Klik menu **"Customer Chat"** di sidebar
- Badge merah menunjukkan jumlah pesan belum dibaca

#### 3. **Set Status Online**
- Toggle switch "Online/Offline" di halaman chat
- Saat online: User melihat centang 2 (✓✓)
- Saat offline: User melihat centang 1 (✓)

#### 4. **Balas Chat**
- Klik session chat yang ingin dibalas
- Ketik pesan di input box
- Klik "Kirim" atau tekan Enter
- Pesan otomatis tersimpan dan user akan melihatnya

#### 5. **Monitor Chat Real-time**
- Halaman auto-refresh setiap 3 detik
- Pesan baru muncul otomatis
- Status "read" otomatis update

---

### **Untuk User/Pelanggan:**

#### 1. **Buka Chat Widget**
- Klik icon chat di pojok kanan bawah
- Widget chat akan terbuka

#### 2. **Kirim Pesan**
- Ketik pertanyaan di input box
- Tekan Enter atau klik tombol kirim
- AI akan merespons otomatis

#### 3. **Lihat Status Pesan**
- **✓** = Terkirim (admin offline)
- **✓✓** = Terkirim (admin online)
- **✓✓ Biru** = Sudah dibaca admin

#### 4. **Chat dengan Admin**
- Jika AI tidak bisa membantu, akan muncul tombol WhatsApp
- Atau admin bisa langsung membalas di dashboard

---

## 🔧 Konfigurasi

### **Environment Variables**
Pastikan `.env` sudah diset:
```env
GEMINI_API_KEY=your_gemini_api_key_here
```

### **Database Migration**
Jalankan migration:
```bash
php artisan migrate
```

### **Cache Configuration**
Sistem menggunakan Laravel Cache untuk admin online status:
```php
Cache::put('admin_online', true, now()->addHours(1));
```

---

## 📊 Database Schema

### **Table: chat_messages**
```sql
- id (bigint, primary key)
- session_id (string, indexed)
- sender_type (string: 'user', 'ai', 'admin')
- message (text)
- is_read (boolean, default: false)
- admin_online (boolean, default: false)
- read_at (timestamp, nullable)
- user_name (string, nullable)
- user_phone (string, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

---

## 🎨 Fitur AI

### **Kemampuan AI:**
1. **Greeting** - Menyapa dengan waktu yang tepat
2. **Menu/Produk** - Menampilkan daftar produk dengan harga
3. **Harga** - Memberikan range harga dan rata-rata
4. **Rekomendasi** - Menyarankan best seller
5. **Cara Pesan** - Panduan step-by-step
6. **Lokasi/Delivery** - Info pengiriman dan ongkir
7. **Promo** - Informasi promo terkini
8. **Layanan Lain** - Pulsa, galon, gas LPG
9. **Kontak Admin** - Redirect ke WhatsApp
10. **Product Match** - Pencarian produk fuzzy

### **Fallback Mode:**
Jika Gemini API gagal, sistem otomatis menggunakan AI lokal yang:
- Lebih cepat (no API call)
- Tetap cerdas dengan pattern matching
- Sentiment analysis
- Intent detection
- Fuzzy search produk

---

## 🔐 Security

### **CSRF Protection**
Semua request menggunakan CSRF token:
```javascript
'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
```

### **Authentication**
Admin routes dilindungi middleware `auth`:
```php
Route::middleware(['auth'])->group(function () {
    // Admin chat routes
});
```

### **Session Security**
- Session ID unik per user
- Disimpan di localStorage browser
- Tidak bisa diakses cross-domain

---

## 📈 Performance

### **Optimizations:**
1. **Polling Interval**
   - Admin status: 30 detik
   - New messages: 3 detik
   - Chat list refresh: 10 detik

2. **Database Indexing**
   - `session_id` indexed untuk query cepat
   - `is_read` + `sender_type` untuk unread count

3. **Caching**
   - Admin online status di cache (1 jam)
   - Mengurangi database hits

---

## 🐛 Troubleshooting

### **Chat tidak muncul?**
- Clear browser cache (Ctrl+Shift+R)
- Check console untuk error
- Pastikan JavaScript enabled

### **AI tidak merespons?**
- Check GEMINI_API_KEY di .env
- Fallback AI akan aktif otomatis
- Check network tab untuk error

### **Admin tidak bisa balas?**
- Pastikan sudah login
- Check CSRF token
- Refresh halaman

### **Status centang tidak update?**
- Check admin online status
- Refresh chat widget
- Clear localStorage

---

## 🎯 Best Practices

### **Untuk Admin:**
1. Set status "Online" saat aktif monitoring
2. Balas chat dalam 5 menit untuk kepuasan pelanggan
3. Gunakan bahasa yang ramah dan profesional
4. Jika perlu eskalasi, arahkan ke WhatsApp

### **Untuk Developer:**
1. Monitor error logs di `storage/logs/laravel.log`
2. Backup database secara berkala
3. Update AI prompts sesuai kebutuhan bisnis
4. Test chat di berbagai browser

---

## 📞 Support

Jika ada pertanyaan atau issue:
1. Check dokumentasi ini terlebih dahulu
2. Review code di file terkait
3. Check Laravel logs
4. Contact developer

---

## 🚀 Future Enhancements

### **Planned Features:**
- [ ] File upload (gambar produk)
- [ ] Voice message
- [ ] Chat history export
- [ ] Analytics dashboard
- [ ] Multi-admin support
- [ ] Push notifications
- [ ] Mobile app integration
- [ ] Chatbot training interface

---

## 📝 Changelog

### **Version 1.2.0** (2026-01-11)
- ✅ **Simplified Admin UI**: Penghapusan menu sidebar "Customer Chat" untuk tampilan yang lebih bersih.
- ✅ **Admin Floating Widget**: Implementasi widget chat mengambang all-in-one di dashboard.
- ✅ **Better UX**: Admin dapat memonitor dan membalas pesan pelanggan langsung dari dashboard tanpa berpindah halaman.
- ✅ **Performance**: JSON API optimization untuk loading chat list yang lebih cepat.

### **Version 1.1.0** (2026-01-11)
- ✅ **Avatar Support**: Tampilan foto profil user di admin chat (WhatsApp Style)
- ✅ **Database Enhancements**: Kolom `user_name`, `user_phone` di chat messages
- ✅ **Optimized Grouping**: Fix duplikasi room chat untuk user yang sama
- ✅ **Enhanced UI**: Profile Edit Form dengan desain premium
- ✅ **Bug Fixes**: Resolve "Connection Error" akibat schema mismatch

### **Version 1.0.0** (2026-01-10)
- ✅ Initial release
- ✅ AI chatbot integration
- ✅ Admin chat management
- ✅ Read status (checkmarks)
- ✅ Session tracking
- ✅ Real-time polling
- ✅ Online/offline status

---

## 📄 License

Proprietary - Keripik Sohibah
All rights reserved.

---

**Dibuat dengan ❤️ untuk Keripik Sohibah**
