# 📚 Sistem Manajemen Perpustakaan Digital (Taman Buku)

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql)

Aplikasi web Manajemen Perpustakaan modern yang dibangun menggunakan Framework **Laravel**. Aplikasi ini dirancang untuk mempermudah sirkulasi peminjaman buku, pengelolaan denda otomatis, dan katalog buku digital.

## 🌟 Fitur Utama

### 1. Halaman Publik (Guest & Mahasiswa)
* **Homepage Modern:** Menampilkan buku terbaru dan buku terpopuler (berdasarkan rating).
* **Katalog Buku:** Pencarian buku (judul/penulis), filter kategori, dan pengurutan (sorting).
* **Detail Buku:** Informasi lengkap, status stok real-time, dan ulasan pembaca.

### 2. Panel Mahasiswa
* **Peminjaman Buku:** Mengajukan peminjaman (Maksimal 3 buku).
* **Sistem Blokir Otomatis:** Tidak bisa meminjam jika memiliki denda tertunggak.
* **Perpanjangan:** Dapat memperpanjang buku jika belum lewat jatuh tempo (Maksimal 1x).
* **Riwayat & Denda:** Melihat status peminjaman dan kalkulasi denda keterlambatan secara otomatis.
* **Ulasan & Rating:** Memberikan ulasan pada buku yang sudah dikembalikan.
* **Profil Pengguna:** Pengaturan akun dan edit profil.

### 3. Panel Pegawai & Admin
* **Manajemen Buku:** CRUD Buku lengkap dengan **Upload Sampul Buku** dan Deskripsi.
* **Transaksi Sirkulasi:** Memproses peminjaman dan pengembalian buku.
* **Kalkulasi Denda Cerdas:** Sistem otomatis menghitung hari keterlambatan (menggunakan logika `startOfDay` dan `abs` untuk akurasi) dan total denda.
* **Pelunasan Denda:** Menandai denda sebagai lunas agar mahasiswa bisa meminjam kembali.
* **Dashboard Statistik:** Ringkasan total buku, stok, peminjaman aktif, dan buku terlambat.

---

## 📸 Tampilan Aplikasi (Screenshots)

*(Silakan ganti link gambar di bawah ini dengan screenshot aplikasi Anda nanti)*

| Homepage | Katalog Buku |
| :---: | :---: |
| ![Homepage](path/to/homepage.png) | ![Katalog](path/to/katalog.png) |

| Dashboard Pegawai | Detail Peminjaman |
| :---: | :---: |
| ![Dashboard](path/to/dashboard.png) | ![Detail](path/to/detail.png) |

---
