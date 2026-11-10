# JANJI
Saya Khalifa Nabil Nur mengerjakan evaluasi Tugas Praktikum 7 dalam mata kuliah Desain Pemrograman Berbasis Objek untuk keberkahan-Nya, maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.


## Penjelasan Tema Website
Website ini mengusung tema **Manajemen Liga Basket**, dirancang untuk mengelola data tim basket, daftar pemain, serta jadwal dan hasil pertandingan. Aplikasi ini dibangun menggunakan bahasa pemrograman **PHP Native** berorientasi objek (**OOP**) dengan antarmuka GUI web sederhana yang memisahkan logika antarmuka (*view*), logika bisnis/database (*class*), dan konfigurasi (*config*).

## Penjelasan Database
1. **`teams`** (Entitas Tim):
   - `id` (INT, Primary Key, Auto Increment)
   - `name` (VARCHAR): Nama tim basket.
   - `city` (VARCHAR): Kota asal tim.
2. **`players`** (Entitas Pemain):
   - `id` (INT, Primary Key, Auto Increment)
   - `name` (VARCHAR): Nama pemain.
   - `position` (VARCHAR): Posisi pemain (Point Guard, Center, dll).
   - `team_id` (INT, Foreign Key -> `teams.id`): Relasi ke tim tempat pemain bernaung.
3. **`matches`** (Entitas Pertandingan):
   - `id` (INT, Primary Key, Auto Increment)
   - `match_date` (DATE): Tanggal pertandingan.
   - `home_team_id` (INT, Foreign Key -> `teams.id`): Tim tuan rumah.
   - `away_team_id` (INT, Foreign Key -> `teams.id`): Tim tamu.
   - `score_home` (INT): Skor tim tuan rumah.
   - `score_away` (INT): Skor tim tamu.

## Penjelasan Flow Program & Arsitektur OOP
1. **Titik Masuk (`Index.php`)**:
   - `Index.php` bertindak sebagai *router* utama. Ketika pengguna mengakses aplikasi, `Index.php` membaca parameter `?page=` dari URL untuk menentukan *view* mana yang harus dimuat (misal: `teams.php`, `players.php`, atau `matches.php`).

2. **Lapisan Tampilan (`view/`)**:
   - Setiap file *view* memuat form interaktif (GUI) dan tabel data.
   - Ketika pengguna melakukan aksi CRUD (misal: submit form "Tambah Tim" atau klik tombol "Edit"/"Hapus"), *view* akan menangkap request `$_POST` atau `$_GET` dan memanggil *method* dari class yang sesuai.

3. **Lapisan Logika Data (`class/`)**:
   - Terdapat 3 class utama: `Team.php`, `Player.php`, dan `MatchGame.php`.
   - Seluruh operasi basis data menggunakan **PDO (PHP Data Objects)** dengan **Prepared Statement** (`prepare()` & `execute()`) untuk menjamin keamanan dari SQL Injection.

4. **Koneksi Database (`config/db.php`)**:
   - Mengenkapsulasi koneksi MySQL ke dalam class `Database` yang dipanggil oleh constructor di setiap class entitas.
  
## DOKUM


https://github.com/user-attachments/assets/223268b3-27d4-41dc-b2ea-6e8706a09daa




