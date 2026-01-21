# Sistem E-Voting Ketua Himaprodi Berbasis Web

## Tim Pengembang

| No | Nama Anggota | NIM | Username GitHub |
|:--:|:-------------|:---:|:----------------|
| 1. | **Ni Made Dwipayanti Oktaviani** | 240030360 | mellow-o  |
| 2. | **I Nengah Arya Prayoga** | 240030304 | aryaprayoga-oss  |
| 3. | **Ni Putu Wina Askarini** | 240030364 | askariniwina |
| 4. | **I Gede Oka Julian Krishnarya** | 240030312 | OkaJulian |

## Deskripsi Singkat Sistem
Ini adalah aplikasi voting online untuk pemilihan Ketua Himpunan Mahasiswa Program Studi (Himaprodi). Sistem ini dirancang untuk memfasilitasi proses pemilihan kandidat secara digital yang aman, transparan, dan efisien.

##  Fitur Utama

###  Keamanan (Security)
* **Login**: Menggunakan sistem token (JWT). Jadi kalau tokennya habis, user harus login ulang.
* **Middleware Proteksi**: Setiap endpoint dilindungi oleh `auth/middleware.php` untuk memvalidasi token sebelum memberikan akses.
* **Role-Based Access**: Pemisahan hak akses antara **Admin** dan **User**.
* **Password Terenkripsi**: Password user dan admin tidak bisa dibaca manusia karena diacak (hashing).

### Admin (Panitia)
* **Kelola Kandidat**:  Admin memiliki akses penuh (CRUD) untuk menambah, mengubah, dan menghapus data kandidat ketua Himaprodi.
* **Pantau Hasil**: Admin bisa melihat perolehan suara secara langsung (real-time).

### User (Mahasiswa)
* **Lihat Kandidat**: User bisa melihat daftar kandidat beserta visi dan misinya
* **Voting**: Sistem memvalidasi agar setiap user hanya bisa memberikan satu suara dan sistem akan menolak jika ada user yang mencoba memilih dua kali.
  
## Teknologi yang Digunakan

* **Bahasa Pemrograman**: PHP (Minimal versi 8.0)
* **Database**: MySQL
* **Library Utama**: `firebase/php-jwt` v7.0
* **Tools**: VS Code, Composer, **Thunder Client** 

## Struktur Folder
```
project_voting
├── admin/               // folder untuk fitur' yang bisa diakses admin
│   ├── candidates.php   // file untuk Admin CRUD data kandidat.
│   └── results.php      // file untuk Admin liat hasil voting secara real-time
│
├── auth/                // folder untuk menangani keamanan
│   ├── login.php        // file untuk memproses username & password saat login.
│   └── middleware.php   // file ini untuk mengecek apakah user punya Token JWT yang sah
│
├── config/              // folder untuk untuk pusat pengaturan sistem
│   ├── database.php     // untuk mengatur koneksi ke database MySQL 
│   └── jwt.php          // untuk nyimpan "Kunci Rahasia" token
│
├── controllers/         // otak logika yang menghubungkan permintaan user dengan data
│   ├── CandidateController.php  // file ini untuk mengatur logika data kandidat
│   └── VoteController.php       // untuk mengatur logika saat user melakukan voting
│
├── helpers/             // folder untuk bantu kodingan
│   └── response.php     // biar format jawaban (JSON) seragam dan rapi
│
├── models/              // untuk berinteraksi langsung dengan tabel database (SQL)
│   ├── Candidate.php    // untuk menjalankan perintah SQL ke tabel candidates
│   └── Vote.php         // untuk menjalankan perintah SQL ke tabel votes
│
├── project_voting/      // folder untuk alat tambahan
│   ├── hash admin.php   // untuk membuat password acak (hash) khusus akun Admin
│   └── hash user.php    // untuk membuat password acak (hash) khusus akun User
│
├── user/                // folder untuk fitur-fitur yang diakses oleh User
│   ├── candidates.php   // file ini untuk User melihat kandidat dan daftar visi & misi
│   └── vote.php         // file ini untuk User melakukan voting
│
├── vendor/               // untuk menyimpan library pihak ketiga  (otomatis muncul dari Composer)
├── composer.json        
├── composer.lock       
├── db_voting.txt        // SQL untuk buat Database
├── gitattributes.txt   
└── README.md            // dokumentasi project
```
## Prasyarat Instalasi

1.  **XAMPP / Laragon** 
2.  **Composer** (Untuk download library JWT)
3.  **VS Code** dengan ekstensi **Thunder Client**

## Langkah Instalasi 

### 1. Menyiapkan Project
* Download repository ini atau git clone
* Pindahkan folder project ke dalam direktori server lokal
   * Kalau pakai XAMPP: Simpan di C:/xampp/htdocs/
   * Kalau pakai Laragon: Simpan di C:/laragon/www/
cd nama-repository
### 2. Install Library
Supaya fitur login (JWT) bisa berjalan, perlu yang namanya menginstall library dan 
karena file `composer.json` sudah ada, jadi tidak perlu setting manual

1.  Buka **Terminal** atau **Command Prompt (CMD)**
2.  Arahkan ke folder project ini
    kalau di VS Code klik menu **Terminal** kemudian **New Terminal**
3.  Ketik perintah ini kemudian Enter:
    ```
    composer install
    ```
4.  Tunggu sampai proses selesai dan folder `vendor` muncul
### 3. Siapkan Database
* Buka phpMyAdmin, buat database baru bernama db_voting
* Buka file db_voting.txt yang ada di project ini. Copy semua isinya, lalu paste di menu SQL pada phpMyAdmin untuk membuat tabel users, candidates, dan votes secara otomatis
### 4.  Cek Koneksi Database
* Buka file `config/database.php`
* Cek pada bagian ini:
    ```
    php
    "mysql:host=localhost;dbname=db_voting;charset=utf8",
    "root",  // Username database (default XAMPP: root)
    "",      // Password database (default XAMPP: kosong)
    ```
* Kalau user pakai password di XAMPP/MySQL maka isikan di bagian tanda kutip kosongnya `""` 

## Tahap Testing dengan Thunder Client

### Login (untuk mendapatkan token)
1. Buka Thunder Client, buat New Request
2. Set method ke POST, masukkan URL: http://localhost/folder-project/auth/login.php
3. Di tab Body pada bagian JSON, masukkan:
  ```
JSON
  {
  "username": "admin",
  "password": "admin123"
  }
  ```
4. Klik Send. Kalau sukses, akan dapat balasan berupa "token": "ey...xxx".
5. Copy token itu karena itu dapat digunakan sebagai hak akses kamu

### Akses Fitur (Pakai Token)
Contohnya ketika mau nambah kandidat (Admin):
1. Buat Request baru, method POST, URL: http://localhost/folder-project/admin/candidates.php
2. Masuk ke tab Auth kemudian pilih Bearer Token.
3. Paste token yang tadi kamu copy di kolom Token.
4. Isi data kandidat di tab Body (JSON):
```
JSON
{
  "name": "Calon Ketua 1",
  "vision": "Mewujudkan himpunan mahasiswa yang berkualitas dan bertanggung jawab",
  "mission": "Menjadi wadah kegiatan, penyalur aspirasi, minat, bakat dan tempat tukar pikiran"
}
```
5. Klik Send. kemudian muncul message Berhasil! dan data masuk ke database

Note : langkah "Auth Bearer Token" ini diulangi untuk setiap request yang butuh login, seperti Voting atau Lihat Hasil

