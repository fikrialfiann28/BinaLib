# BinaLib

 BinaLib  adalah sistem informasi perpustakaan untuk  SMK Bina Rahayu  yang dirancang untuk membantu proses peminjaman, pengembalian, pengelolaan data buku, data siswa, dan transaksi perpustakaan secara lebih terstruktur.

Project ini dikembangkan sebagai bagian dari kegiatan  Pengabdian kepada Masyarakat (PkM)  dengan fokus pada digitalisasi proses perpustakaan.

## Fitur

### Admin
- Dashboard perpustakaan
- Pengelolaan data siswa
- Pengelolaan data buku
- Registrasi dan pengelolaan RFID siswa
- Pengelolaan transaksi peminjaman
- Pengelolaan pengembalian
- Riwayat transaksi
- Laporan perpustakaan
- Pengaturan sistem

### User / Self-Service
- Identifikasi siswa menggunakan RFID
- Tampilan informasi siswa setelah RFID terdeteksi
- Peminjaman buku secara mandiri
- Pilihan penggunaan:
  -  Kegunaan Kelas  — dapat memilih lebih dari satu buku
  -  Penggunaan Pribadi  — maksimal satu buku
- Konfirmasi transaksi sebelum peminjaman
- Pengembalian buku melalui sistem

## Alur RFID

RFID digunakan untuk  mengidentifikasi siswa , bukan untuk mengidentifikasi buku.

```text
Siswa
  ↓
Scan RFID
  ↓
BinaLib membaca UID RFID
  ↓
Sistem mencari data siswa
  ↓
Identitas siswa ditampilkan
  ↓
Pilih jenis penggunaan
  ↓
Pilih buku
  ↓
Konfirmasi
  ↓
Transaksi tersimpan
```

Reader RFID yang digunakan dapat bekerja sebagai  keyboard emulation , sehingga UID kartu dapat diterima oleh input pada aplikasi tanpa memerlukan mikrokontroler seperti Arduino atau ESP32.

## Jenis Peminjaman

### Kegunaan Kelas

Digunakan ketika buku dipinjam untuk kegiatan pembelajaran di kelas.

Siswa dapat memilih beberapa buku sekaligus dan menentukan jumlah buku yang diperlukan.

### Penggunaan Pribadi

Digunakan ketika siswa meminjam buku untuk kebutuhan pribadi.

Dalam mode ini, siswa hanya dapat memilih  maksimal satu buku .

## Teknologi

-  PHP Native 
-  MySQL 
-  HTML5 
-  CSS3 
-  JavaScript 
-  PDO 
-  RFID USB Reader 

> Struktur aplikasi menggunakan PDO agar lapisan akses database lebih mudah disesuaikan apabila pada deployment sekolah digunakan DBMS yang berbeda.

## Struktur Project

```text
BinaLib/
├── api.php
├── config/
│   └── ...
├── includes/
│   └── ...
├── admin/
│   └── ...
├── user/
│   └── ...
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
└── database/
    └── ...
```

Struktur folder dapat berkembang mengikuti kebutuhan implementasi dan deployment.

## Persyaratan

Untuk menjalankan BinaLib secara lokal, diperlukan:

- PHP 8.x atau versi yang kompatibel
- MySQL / MariaDB
- Apache
- Browser modern
- RFID USB Reader untuk pengujian RFID

Server lokal dapat menggunakan:

- XAMPP
- Laragon
- LAMP
- Apache + PHP + MySQL secara manual

## Instalasi

### 1. Clone repository

```bash
git clone https://github.com/USERNAME/BinaLib.git
cd BinaLib
```

Ganti `USERNAME` dengan username GitHub pemilik repository.

### 2. Letakkan project pada web server

Contoh menggunakan XAMPP:

```text
C:\xampp\htdocs\BinaLib
```

Contoh menggunakan LAMPP di Linux:

```text
/opt/lampp/htdocs/BinaLib
```

### 3. Buat database

Buat database MySQL untuk BinaLib.

Contoh:

```sql
CREATE DATABASE binalib;
```

Kemudian import file database/schema yang tersedia di project.

### 4. Konfigurasi database

Sesuaikan konfigurasi database pada file konfigurasi BinaLib:

```text
config/
```

Contoh parameter yang perlu disesuaikan:

```text
Host
Port
Database
Username
Password
```

Jangan menyimpan password database production secara langsung di repository publik.

## Pengujian RFID

Pastikan RFID reader sudah terhubung ke komputer.

Karena reader menggunakan keyboard emulation, proses pengujian dapat dilakukan dengan:

```text
1. Buka halaman self-service BinaLib
2. Fokuskan cursor pada input RFID
3. Tempelkan kartu RFID
4. Reader mengirimkan UID
5. Sistem mencari siswa berdasarkan UID
6. Siswa dapat melanjutkan proses peminjaman
```

Untuk development tanpa perangkat RFID, UID juga dapat dimasukkan secara manual.

## Konsep Database

Data utama yang digunakan BinaLib meliputi:

```text
Siswa
- ID
- NIS
- Nama
- RFID UID
- Status

Buku
- ID
- Kode Buku
- Judul
- Penulis
- Tahun
- Stok

Transaksi
- ID
- Siswa
- Buku
- Jenis Penggunaan
- Jumlah
- Waktu Peminjaman
- Waktu Pengembalian
- Status
```

RFID UID berfungsi sebagai identitas kartu yang terhubung dengan data siswa.

Jika kartu siswa diganti, UID dapat diperbarui tanpa harus membuat data siswa baru.

## Keamanan

Untuk deployment sebenarnya, beberapa hal perlu diperhatikan:

- Gunakan password yang sudah di-hash.
- Jangan commit password database ke GitHub.
- Gunakan prepared statement untuk query database.
- Validasi input dari user.
- Batasi akses halaman admin.
- Gunakan HTTPS pada server production.
- Pisahkan konfigurasi development dan production.
- Jangan menyimpan credential atau secret di repository publik.

## Status Project

 Development / Prototype 

BinaLib saat ini dikembangkan sebagai sistem perpustakaan untuk kebutuhan SMK Bina Rahayu. Beberapa bagian masih dapat disesuaikan berdasarkan kondisi server, database, autentikasi, dan perangkat RFID yang digunakan oleh sekolah.

## Pengembangan Selanjutnya

Beberapa pengembangan yang dapat dilakukan:

- Integrasi database asli sekolah
- Integrasi akun sekolah / Google Workspace jika diperlukan
- Autentikasi admin dengan 2FA
- Integrasi RFID reader secara penuh
- Penyempurnaan self-service
- Backup dan restore database
- Laporan transaksi yang dapat diekspor
- Deployment pada server sekolah
- Penyesuaian dengan kebijakan dan infrastruktur jaringan sekolah

## Kontribusi

Project ini dikembangkan untuk kebutuhan akademik dan kegiatan Pengabdian kepada Masyarakat.

Perubahan, perbaikan bug, dan pengembangan fitur dapat dilakukan sesuai kebutuhan sistem dan hasil evaluasi penggunaan di lingkungan sekolah.

## Lisensi

Project ini dibuat untuk kebutuhan akademik dan implementasi pada  SMK Bina Rahayu .

Penggunaan kembali, distribusi, atau modifikasi untuk kebutuhan lain sebaiknya mendapatkan persetujuan dari pihak pengembang dan pihak terkait.