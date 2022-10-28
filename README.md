# TUGAS Tugas Besar 1 IF3110

## Milestone 1 -  Monolithic PHP & Vanilla Web Application
Website Binotify merupakan aplikasi musik berbasis web pada BNMO. BNMO adalah mesin yang kuno sehingga hanya kuat untuk menjalankan sebuah DBMS (PostgreSQL/MariaDB/MySQL) dan PHP murni beserta HTML, CSS, dan Javascript vanilla.

## Daftar Requirement
- XAMPP
- MySQL
- PHP
- Apache
- Docker

## Cara intalasi

1. instal [XAMPP](https://www.apachefriends.org/download.html)
2. install [Docker](https://www.apachefriends.org/download.html)
3. Ikuti perintah yang terdapat pada website untuk menginstal aplikasi tersebut

### Docker
lakukan build image dengan menjalankan file ```build-image.sh``` yang terdapat pada folder ```script```, atau jalankan perintah ```docker build -t tubes-1:latest .``` pada terminal

## Cara Menjalankan Aplikasi

### Menggunakan XAMPP
1. Jalankan Apache dan MySQL pada aplikasi XAMPP
2. pada file ```config.php``` pada folder src uncomment config bagian atas, dan comment pada bagian bawah, uncomment bagian berikut ini
```
'db_host' => 'localhost',
'db_database' => 'binotify',
'db_user' => 'root',
'db_password' => '',
'db_pdo_connect' => "mysql:host=localhost;dbname=binotify",
```
3. Buka ```localhost/phpmyadmin``` pada browser
4. Buat Database dengan nama ```binotify```
5. import file ```binotify.sql``` (yang terdapat pada folder sql) ke dalam database yang telah dibuat sebelumnya
6. ketikan URL ```localhost/home``` pada browser 

### Menggunakan Docker
1. pada file ```config.php``` pada folder src uncomment config bagian bawah, dan comment pada bagian atas, uncomment bagian berikut ini
```
'db_host' => 'db',
'db_database' => 'binotify',
'db_user' => 'root',
'db_password' => 'MYSQL_ROOT_PASSWORD',
'db_pdo_connect' => "mysql:host=db;dbname=binotify",
```
2. jalankan perintah ```docker compose up``` pada root folder
3. Buka ```localhost:8080``` untuk mengakses phpmyadmin
4. pada phpmyadmin masukan 
```
user = root
password = MYSQL_ROOT_PASSWORD
```
5. Buat Database dengan nama ```binotify```
6. import file ```binotify.sql``` (yang terdapat pada folder sql) ke dalam database yang telah dibuat sebelumnya
7. aplikasi akan berjalan pada ```localhost:8008/home```

## Tampilan Website

Berikut merupakan tampilan dari website yang kami buat

1. Halaman Login
![Login](img/login.png)

2. Halaman Register
![Register](img/Register.png)

3. Halaman Home
![Home](img/home.png)

4. Halaman Daftar Album
![DaftarAlbum](img/albumlist.png)

5. Halaman Search, Sort, and Filter
![Search](img/search.png)

6. Halaman Detail Lagu
![Detail Lagu](img/detailLagu.png)

7. Halaman Detail Album
![Detail Album](img/detailAlbum.png)

8. Halaman Tambah Album/Lagu
![Add Album](img/addAlbum.png)
![Add Song](img/addSong.png)

9. Halaman Daftar User
![AUser List](img/userlist.png)

## Pembagian Tugas

1. Server-side
```
Login : 13520149
Register : 13520149
Home : 13520149, 13520116
Daftar Album: 13520116
Search, Sort, and Filter : 13520146
Detail Lagu : 13520146
Detail Album : 13520146
Tambah Album/Lagu : 13520116
Daftar User : 13520149
```
2. Client-side
```
Login : 13520149
Register : 13520149
Home : 13520149, 13520116
Daftar Album: 13520116
Search, Sort, and Filter : 13520146
Detail Lagu : 13520146
Detail Album : 13520146
Tambah Album/Lagu : 13520116
Daftar User : 13520149
```
## Panduan Pengerjaan
Berikut adalah hal yang harus diperhatikan untuk pengumpulan tugas ini:
1. Buatlah grup pada Gitlab dengan format "IF3110-2022-KXX-01-YY", dengan XX adalah nomor kelas dan YY adalah nomor kelompok.
2. Tambahkan anggota tim pada grup anda.
3. **Fork** pada repository ini dengan organisasi yang telah dibuat.
4. Ubah hak akses repository hasil Fork anda menjadi **private**.
5. Hal-hal yang harus diperhatikan.
    * Silakan commit pada repository anda (hasil fork)
    * Lakukan beberapa commit dengan pesan yang bermakna, contoh: “add register form”, “fix logout bug”, jangan seperti “final”, “benerin dikit”, “fix bug”.
    * Disarankan untuk tidak melakukan commit dengan perubahan yang besar karena akan mempengaruhi penilaian (contoh: hanya melakukan satu commit kemudian dikumpulkan).
    * Sebaiknya commit dilakukan setiap ada penambahan fitur.
    * Commit dari setiap anggota tim akan mempengaruhi penilaian.
    * Jadi, setiap anggota tim harus melakukan commit yang berpengaruh terhadap proses pembuatan aplikasi.
    * Sebagai panduan bisa mengikuti [semantic commit](https://gist.github.com/joshbuchea/6f47e86d2510bce28f8e7f42ae84c716).
6. Buatlah file README yang berisi:
    * Deskripsi aplikasi web
    * Daftar requirement
    * Cara instalasi
    * Cara menjalankan server
    * Screenshot tampilan aplikasi (tidak perlu semua kasus, minimal 1 per halaman), dan 
    * Penjelasan mengenai pembagian tugas masing-masing anggota (lihat formatnya pada bagian pembagian tugas).
