# GOR GAZA - Booking & Payment Polish Patch

Isi patch:
- Polish halaman pilih kategori booking.
- Polish halaman konfirmasi booking.
- Polish halaman pembayaran.
- Metode pembayaran di detail booking otomatis berubah sesuai pilihan QRIS/Cash.
- Tombol konfirmasi booking dibuat lebih modern.
- Semua teks GoPay di source utama dihapus/diganti QRIS.
- Payment page memperbaiki URL WhatsApp confirmation.
- Finance/admin display menormalisasi metode lama QRIS / GoPay menjadi QRIS.
- Validasi slot yang sudah lewat tetap aman di backend.

Cara pasang:
1. Copy isi patch ke root project C:\src\gorgaza.
2. Replace semua file yang sama.
3. Jalankan:
   php artisan view:clear
   php artisan optimize:clear

Catatan:
Jika data lama di database masih berisi "QRIS / GoPay", tampilan view sudah dinormalisasi menjadi "QRIS".
