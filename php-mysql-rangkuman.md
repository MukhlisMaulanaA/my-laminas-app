# Penjelasan Detail PHP dan MySQL: Dasar hingga Intermediate

## I. PHP (Hypertext Preprocessor)

### A. Dasar PHP

1. Pengenalan PHP
   - PHP adalah bahasa scripting server-side yang dirancang khusus untuk pengembangan web.
   - Diciptakan oleh Rasmus Lerdorf pada tahun 1994.
   - Kelebihan PHP:
     - Mudah dipelajari dan digunakan
     - Gratis dan open-source
     - Cross-platform (berjalan di berbagai sistem operasi)
     - Memiliki dukungan luas untuk berbagai database

2. Sintaks dasar
   - Tag PHP: Kode PHP dimulai dengan `<?php` dan diakhiri dengan `?>`.
   - Komentar:
     - Single-line: `// Ini komentar` atau `# Ini juga komentar`
     - Multi-line: `/* Ini komentar multi-line */`
   - Variabel:
     - Dimulai dengan tanda `$`, contoh: `$nama = "John";`
   - Tipe data:
     - Integer: Bilangan bulat
     - Float: Bilangan desimal
     - String: Teks
     - Boolean: Nilai true atau false
     - Array: Kumpulan data
     - Object: Instance dari class

3. Operator
   - Aritmatika: `+` (penjumlahan), `-` (pengurangan), `*` (perkalian), `/` (pembagian), `%` (modulus)
   - Perbandingan: `==` (sama dengan), `!=` (tidak sama dengan), `<` (kurang dari), `>` (lebih dari), `<=` (kurang dari atau sama dengan), `>=` (lebih dari atau sama dengan)
   - Logika: `&&` (AND), `||` (OR), `!` (NOT)

4. Struktur kontrol
   - Percabangan:
     ```php
     if (kondisi) {
         // kode jika kondisi benar
     } elseif (kondisi_lain) {
         // kode jika kondisi_lain benar
     } else {
         // kode jika semua kondisi salah
     }

     switch ($variable) {
         case nilai1:
             // kode jika $variable == nilai1
             break;
         case nilai2:
             // kode jika $variable == nilai2
             break;
         default:
             // kode jika tidak ada case yang cocok
     }
     ```
   - Perulangan:
     ```php
     for ($i = 0; $i < 10; $i++) {
         // kode yang akan diulang
     }

     while (kondisi) {
         // kode yang akan diulang selama kondisi benar
     }

     do {
         // kode yang akan diulang minimal sekali
     } while (kondisi);
     ```

5. Fungsi
   - Fungsi bawaan PHP: `strlen()`, `str_replace()`, `date()`, dll.
   - Membuat fungsi sendiri:
     ```php
     function namaFungsi($parameter1, $parameter2) {
         // kode fungsi
         return $hasil;
     }
     ```

6. Array
   - Array satu dimensi: `$buah = array("apel", "jeruk", "mangga");`
   - Array multidimensi: 
     ```php
     $siswa = array(
         array("John", "Doe", 15),
         array("Jane", "Smith", 16)
     );
     ```
   - Array asosiatif: 
     ```php
     $biodata = array(
         "nama" => "John Doe",
         "umur" => 30,
         "pekerjaan" => "Programmer"
     );
     ```

### B. PHP Intermediate

1. Penanganan form
   - GET: Data dikirim melalui URL
   - POST: Data dikirim secara tersembunyi
   - Validasi input:
     ```php
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
         $nama = test_input($_POST["nama"]);
     }

     function test_input($data) {
         $data = trim($data);
         $data = stripslashes($data);
         $data = htmlspecialchars($data);
         return $data;
     }
     ```

2. Manipulasi string
   - Fungsi-fungsi seperti `substr()`, `strpos()`, `str_replace()`, dll.

3. Penanganan file dan direktori
   - Membaca file: `file_get_contents()`, `fopen()`, `fread()`, `fclose()`
   - Menulis file: `file_put_contents()`, `fwrite()`
   - Operasi direktori: `mkdir()`, `rmdir()`, `scandir()`

4. Penggunaan session dan cookie
   - Session: 
     ```php
     session_start();
     $_SESSION["user"] = "John";
     ```
   - Cookie:
     ```php
     setcookie("user", "John", time() + (86400 * 30), "/");
     ```

5. Object-Oriented Programming (OOP) di PHP
   - Class dan objek:
     ```php
     class Mobil {
         public $merk;
         public function klakson() {
             echo "Beep!";
         }
     }
     $mobilSaya = new Mobil();
     ```
   - Inheritance: 
     ```php
     class MobilSport extends Mobil {
         public function turbo() {
             echo "Wuush!";
         }
     }
     ```
   - Encapsulation: Menggunakan private, protected, dan public
   - Polymorphism: Overriding method dari parent class

6. Penanganan error dan exception
   - Try-catch:
     ```php
     try {
         // kode yang mungkin menghasilkan exception
     } catch (Exception $e) {
         echo "Caught exception: " . $e->getMessage();
     }
     ```

7. Koneksi database menggunakan PHP
   - Menggunakan MySQLi atau PDO

## II. MySQL

### A. Dasar MySQL

1. Pengenalan database dan MySQL
   - MySQL adalah sistem manajemen database relasional (RDBMS) open-source

2. Instalasi dan konfigurasi MySQL
   - Dapat diinstal sebagai bagian dari paket seperti XAMPP atau WAMP

3. Tipe data dalam MySQL
   - Numerik: INT, FLOAT, DECIMAL
   - String: VARCHAR, TEXT
   - Tanggal dan Waktu: DATE, TIME, DATETIME
   - Boolean: BOOLEAN

4. Membuat dan menghapus database
   ```sql
   CREATE DATABASE nama_database;
   DROP DATABASE nama_database;
   ```

5. Membuat, mengubah, dan menghapus tabel
   ```sql
   CREATE TABLE nama_tabel (
       id INT PRIMARY KEY AUTO_INCREMENT,
       nama VARCHAR(50),
       umur INT
   );

   ALTER TABLE nama_tabel ADD COLUMN email VARCHAR(100);

   DROP TABLE nama_tabel;
   ```

6. Operasi CRUD
   - INSERT: `INSERT INTO nama_tabel (nama, umur) VALUES ('John', 25);`
   - SELECT: `SELECT * FROM nama_tabel;`
   - UPDATE: `UPDATE nama_tabel SET umur = 26 WHERE nama = 'John';`
   - DELETE: `DELETE FROM nama_tabel WHERE nama = 'John';`

7. Klausa WHERE
   - Digunakan untuk memfilter data: `SELECT * FROM nama_tabel WHERE umur > 18;`

8. Pengurutan data
   - `SELECT * FROM nama_tabel ORDER BY nama ASC;`

### B. MySQL Intermediate

1. Fungsi agregat
   - COUNT: Menghitung jumlah baris
   - SUM: Menjumlahkan nilai
   - AVG: Menghitung rata-rata
   - MAX: Mencari nilai tertinggi
   - MIN: Mencari nilai terendah

2. Pengelompokan data
   - `SELECT department, AVG(salary) FROM employees GROUP BY department;`

3. Subquery
   - Query di dalam query: 
     ```sql
     SELECT nama FROM siswa WHERE nilai > (SELECT AVG(nilai) FROM siswa);
     ```

4. JOIN
   - INNER JOIN: Menggabungkan baris dari dua tabel berdasarkan kondisi yang cocok
   - LEFT JOIN: Mengambil semua data dari tabel kiri dan data yang cocok dari tabel kanan
   - RIGHT JOIN: Kebalikan dari LEFT JOIN
   - FULL JOIN: Mengambil semua data dari kedua tabel

5. Indeks dan optimasi query
   - Membuat indeks untuk mempercepat pencarian: 
     ```sql
     CREATE INDEX idx_nama ON nama_tabel (nama);
     ```

6. Transaksi database
   - Memastikan integritas data dalam operasi yang kompleks:
     ```sql
     START TRANSACTION;
     -- operasi database
     COMMIT; -- atau ROLLBACK jika ada kesalahan
     ```

7. Prosedur tersimpan
   - Fungsi yang disimpan di database:
     ```sql
     DELIMITER //
     CREATE PROCEDURE getNama(IN id INT)
     BEGIN
         SELECT nama FROM siswa WHERE siswa_id = id;
     END //
     DELIMITER ;
     ```

8. Trigger
   - Aksi otomatis yang dijalankan saat event tertentu terjadi:
     ```sql
     CREATE TRIGGER before_insert_siswa
     BEFORE INSERT ON siswa
     FOR EACH ROW
     SET NEW.tanggal_daftar = NOW();
     ```

9. View
   - Tabel virtual berdasarkan hasil query:
     ```sql
     CREATE VIEW siswa_aktif AS
     SELECT * FROM siswa WHERE status = 'aktif';
     ```

## III. Integrasi PHP dan MySQL

1. Koneksi PHP ke MySQL
   ```php
   $conn = mysqli_connect("localhost", "username", "password", "database");
   ```

2. Menjalankan query MySQL melalui PHP
   ```php
   $result = mysqli_query($conn, "SELECT * FROM siswa");
   ```

3. Menampilkan data dari MySQL ke halaman web
   ```php
   while ($row = mysqli_fetch_assoc($result)) {
       echo $row['nama'] . "<br>";
   }
   ```

4. Implementasi CRUD menggunakan PHP dan MySQL
   - Create: Menggunakan form HTML dan INSERT query
   - Read: Menggunakan SELECT query dan menampilkan hasilnya
   - Update: Menggunakan form HTML dengan data yang sudah ada dan UPDATE query
   - Delete: Menggunakan link atau form dengan DELETE query

5. Keamanan database
   - Prepared statements:
     ```php
     $stmt = $conn->prepare("INSERT INTO siswa (nama, umur) VALUES (?, ?)");
     $stmt->bind_param("si", $nama, $umur);
     $stmt->execute();
     ```
   - Escaping: `mysqli_real_escape_string($conn, $input)`

## IV. Proyek Praktis

1. Sistem login sederhana
2. Aplikasi CRUD sederhana
3. Sistem pencarian

Ketiga proyek ini menggabungkan semua konsep yang telah dipelajari.

## V. Best Practices dan Keamanan

1. Penanganan password
   - Menggunakan fungsi `password_hash()` dan `password_verify()`

2. Pencegahan SQL Injection
   - Menggunakan prepared statements atau escaping input

3. Cross-Site Scripting (XSS) prevention
   - Menggunakan `htmlspecialchars()` untuk output

4. Error handling dan logging
   - Menggunakan try-catch dan fungsi logging PHP

5. Penggunaan framework PHP
   - Laravel, CodeIgniter, Symfony adalah beberapa framework populer

