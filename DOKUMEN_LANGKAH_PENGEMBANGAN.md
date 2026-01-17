# Langkah-Langkah Pengembangan Sistem E-Commerce "Keripik Sohibah"

Berikut adalah tahapan teknis dan manajerial yang dilakukan dalam membangun platform E-Commerce Keripik Sohibah, mulai dari konsep awal hingga siap digunakan (deployment).

## 1. Analisis Kebutuhan & Perencanaan (Requirement Analysis)
Tahap pertama berfokus pada pemetaan masalah dan solusi digital yang tepat:
*   **Identifikasi Masalah:** Menemukan titik penghambat ("bottleneck") pada proses penjualan manual, seperti lambatnya respon admin dan perhitungan ongkir yang tidak akurat.
*   **Pemilihan Teknologi (Tech Stack):** Memutuskan penggunaan Framework **Laravel (PHP)** karena keandalan, keamanan, dan kemudahannya dalam pengelolaan data yang kompleks.
*   **Spesifikasi Fitur:** Menentukan fitur wajib yang harus ada:
    *   Halaman Katalog Produk yang menarik.
    *   Keranjang Belanja (Cart) & Checkout.
    *   Integrasi API Pihak Ketiga (RajaOngkir untuk logistik, Midtrans untuk pembayaran, Gemini AI untuk chatbot).

## 2. Perancangan Sistem & Desain (System & UI/UX Design)
Sebelum kode ditulis, struktur sistem dirancang agar rapi dan terukur:
*   **Desain Basis Data (ERD):** Merancang struktur tabel database yang saling berelasi, meliputi tabel `users` (pelanggan/admin), `products` (barang), `orders` (transaksi), dan `chats` (riwayat percakapan).
*   **Perancangan Antarmuka (UI/UX):**
    *   Mengusung konsep **"Modern Glassmorphism"** dengan sentuhan warna gradasi premium (ungu/biru) untuk memberikan kesan elegan dan profesional.
    *   Merancang pengalaman pengguna (UX) yang **Mobile-First**, memastikan tampilan tetap rapi dan mudah digunakan di layar HP kecil sekalipun, mengingat mayoritas pengguna mengakses lewat smartphone.

## 3. Tahap Pengembangan (Development Phase)
Ini adalah inti dari proses pembuatan sistem, dimana rancangan diubah menjadi kode program yang berfungsi:

### A. Pengembangan Backend (Sisi Server)
*   **Setup Framework:** Instalasi Laravel dan konfigurasi lingkungan kerja.
*   **Manajemen Logika Bisnis:** Pembuatan Controller untuk menangani alur data, seperti `OrderController` untuk memproses pesanan masuk dan `ProductController` untuk manajemen stok barang.
*   **Integrasi API:**
    *   Menghubungkan sistem dengan **RajaOngkir** untuk menarik data provinsi/kota dan menghitung biaya kirim secara real-time.
    *   Mengintegrasikan **Midtrans** agar sistem bisa menerbitkan Payment Link atau Kode QRIS otomatis untuk setiap transaksi.
    *   Menanamkan logika **Gemini AI** pada fitur Live Chat untuk respon otomatis yang cerdas.

### B. Pengembangan Frontend (Sisi Tampilan)
*   **Coding Tampilan (Blade Template):** Mengkonversi desain UI menjadi kode HTML/CSS yang dinamis.
*   **Styling Custom:** Menulis CSS manual (`style.css`) untuk mendapatkan detail visual yang spesifik (efek kaca, animasi halus, transisi mode gelap/terang) yang mungkin sulit dicapai jika hanya mengandalkan template bawaan.
*   **Interaktivitas (JavaScript):** Menambahkan skrip agar elemen website terasa hidup, seperti menu hamburger yang responsif, animasi loading, dan perpindahan tema (Dark/Light Mode).

## 4. Pengujian & Perbaikan (Testing & Debugging)
Sistem yang sudah jadi diuji secara ketat untuk memastikan tidak ada kesalahan (bug) fatal:
*   **Uji Fungsionalitas:** Memastikan tombol "Beli", perhitungan total harga, dan proses checkout berjalan lancar tanpa error.
*   **Uji Responsivitas (Mobile Test):** Mengecek tampilan di berbagai ukuran layar. Tahap ini krusial untuk memperbaiki isu seperti tombol yang tertutup (overlay blocking), susunan menu yang berantakan, atau kontras warna yang kurang jelas di mode terang.
*   **Perbaikan Bug (Bug Fixing):** Melakukan revisi cepat berdasarkan temuan error, seperti memperbaiki Z-Index menu yang menutupi layar atau menyesuaikan ukuran kartu produk agar pas di layar HP (2 kolom).

## 5. Implementasi & Deployment
Tahap akhir untuk meluncurkan website agar bisa diakses publik:
*   **Konfigurasi Server:** Menyiapkan hosting (menggunakan layanan seperti Railway) yang mendukung PHP dan Database MySQL.
*   **Setup Environment Production:** Mengatur variabel keamanan (.env) di server produksi agar kunci API (API Keys) tetap aman.
*   **Peluncuran (Go Live):** Mengunggah kode sumber ke server dan memastikan domain bisa diakses oleh pelanggan umum.

## 6. Pemeliharaan (Maintenance)
Setelah rilis, sistem tetap dipantau untuk:
*   Memastikan stok produk selalu terupdate oleh admin.
*   Memonitor kelancaran API pihak ketiga (Midtrans/RajaOngkir).
*   Menerima masukan pelanggan untuk update fitur di masa depan.
