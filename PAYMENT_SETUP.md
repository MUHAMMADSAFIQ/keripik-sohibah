# 💳 Setup Payment Gateway Midtrans

## 📋 Fitur Payment System

✅ **Multiple Payment Methods:**
- E-Wallet: GoPay, OVO, DANA, ShopeePay, QRIS
- Bank Transfer: BCA, BNI, BRI, Permata, dan bank lainnya
- Credit Card: Visa, Mastercard, JCB

✅ **Real-time Payment Notification**
✅ **Automatic Payment Status Update**
✅ **Admin Dashboard Integration**

---

## 🚀 Cara Setup Midtrans

### Step 1: Daftar Akun Midtrans

1. Buka https://dashboard.midtrans.com/register
2. Daftar akun baru (gratis)
3. Verifikasi email Anda

### Step 2: Dapatkan API Keys

1. Login ke Dashboard Midtrans
2. Pilih environment **Sandbox** (untuk testing)
3. Pergi ke **Settings** → **Access Keys**
4. Copy:
   - **Server Key**
   - **Client Key**

### Step 3: Konfigurasi di Laravel

1. Buka file `.env`
2. Tambahkan konfigurasi berikut:

```env
# Midtrans Configuration
MIDTRANS_SERVER_KEY=your-server-key-here
MIDTRANS_CLIENT_KEY=your-client-key-here
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

3. Ganti `your-server-key-here` dan `your-client-key-here` dengan key yang Anda dapatkan dari dashboard Midtrans

### Step 4: Setup Webhook URL (PENTING!)

Webhook digunakan agar Midtrans bisa memberitahu aplikasi Anda saat pembayaran berhasil/gagal.

1. Di Dashboard Midtrans, pergi ke **Settings** → **Configuration**
2. Scroll ke bagian **Payment Notification URL**
3. Masukkan URL: `https://your-domain.com/payment/notification`
   
   **Untuk Testing Lokal:**
   - Install ngrok: https://ngrok.com/download
   - Jalankan: `ngrok http 8000`
   - Copy URL yang diberikan (contoh: `https://abc123.ngrok.io`)
   - Masukkan di Midtrans: `https://abc123.ngrok.io/payment/notification`

4. Klik **Update**

---

## 🧪 Testing Payment

### Menggunakan Sandbox (Testing Mode)

Midtrans Sandbox menyediakan nomor kartu kredit dan e-wallet dummy untuk testing:

#### Credit Card Testing:
- **Card Number**: 4811 1111 1111 1114
- **CVV**: 123
- **Exp Date**: 01/25

#### GoPay Testing:
1. Pilih GoPay saat checkout
2. Akan muncul QR Code dummy
3. Klik "Simulate Payment" di dashboard Midtrans

#### Bank Transfer Testing:
1. Pilih bank (misal BCA VA)
2. Akan dapat nomor VA dummy
3. Klik "Simulate Payment" di dashboard Midtrans

---

## 📊 Melihat Status Pembayaran di Admin Dashboard

Setelah pembayaran berhasil:

1. Login ke Admin Dashboard
2. Pergi ke halaman **Orders**
3. Anda akan melihat:
   - ✅ Status pembayaran: **PAID**
   - 💳 Metode pembayaran (GoPay, Bank Transfer, dll)
   - 👤 Nama pembayar
   - ⏰ Waktu pembayaran
   - 💰 Jumlah yang dibayar

---

## 🔄 Flow Pembayaran

```
1. Customer membuat pesanan
   ↓
2. Redirect ke halaman pembayaran
   ↓
3. Customer memilih metode pembayaran (GoPay/Bank/Credit Card)
   ↓
4. Customer menyelesaikan pembayaran
   ↓
5. Midtrans mengirim notifikasi ke webhook
   ↓
6. Status order otomatis update ke "PAID"
   ↓
7. Admin melihat notifikasi di dashboard
```

---

## 🌐 Production Mode

Setelah testing selesai dan siap go-live:

1. Lengkapi verifikasi bisnis di Midtrans
2. Dapatkan **Production API Keys**
3. Update `.env`:
   ```env
   MIDTRANS_SERVER_KEY=your-production-server-key
   MIDTRANS_CLIENT_KEY=your-production-client-key
   MIDTRANS_IS_PRODUCTION=true
   ```
4. Update webhook URL dengan domain production Anda
5. Update Snap.js URL di `checkout.blade.php`:
   ```html
   <!-- Ganti dari sandbox ke production -->
   <script src="https://app.midtrans.com/snap/snap.js" ...></script>
   ```

---

## 🛠️ Troubleshooting

### Payment tidak update otomatis?
- Pastikan webhook URL sudah benar
- Cek apakah ngrok masih running (untuk local testing)
- Lihat log di Dashboard Midtrans → Notifications

### Error "Snap token not available"?
- Pastikan Midtrans package sudah terinstall: `composer require midtrans/midtrans-php`
- Cek API keys di `.env` sudah benar
- Clear config cache: `php artisan config:clear`

### Payment berhasil tapi status masih pending?
- Cek webhook notification di Dashboard Midtrans
- Pastikan URL webhook accessible dari internet
- Lihat Laravel log: `storage/logs/laravel.log`

---

## 📞 Support

Butuh bantuan?
- Dokumentasi Midtrans: https://docs.midtrans.com
- Midtrans Support: support@midtrans.com
- WhatsApp Admin: 085643527635

---

**Selamat! Payment Gateway Anda sudah siap digunakan! 🎉**
