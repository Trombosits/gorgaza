# Patch Payment Menu QRIS GOR GAZA

Isi patch:
- Landing page menampilkan informasi harga sewa lapang, billiard, raket, dan kok.
- Landing page menampilkan menu kafe sebagai informasi, belum masuk sistem booking online.
- Konfirmasi booking menambahkan pilihan metode pembayaran:
  - QRIS / GoPay
  - Cash / Bayar di Tempat
- Halaman pembayaran menampilkan QR jika customer memilih QRIS / GoPay.
- Halaman pembayaran menampilkan instruksi bayar setelah main jika customer memilih cash.
- Laporan keuangan admin bisa filter berdasarkan metode pembayaran.
- Laporan keuangan menampilkan rekap metode pembayaran.
- Detail booking admin memberi instruksi sesuai metode pembayaran.

Cara pasang:
1. Extract patch.
2. Copy semua isi patch ke root project Laravel `C:\src\gorgaza`.
3. Jika muncul replace, pilih Yes to All.
4. Jalankan:

```bat
composer dump-autoload
php artisan optimize:clear
php artisan serve
```

Catatan:
- Patch ini tidak menambah migration baru.
- QR berada di `public/images/payment/qris-gorgaza.jpeg`.
- QR yang dipakai masih QR GoPay sementara. Ganti file ini jika sudah ada QR resmi mitra/GOR.
