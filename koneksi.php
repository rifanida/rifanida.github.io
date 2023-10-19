<?php
// Mendefinisikan variabel-variabel yang digunakan untuk menghubungkan ke database
$databaseHost = 'localhost';  // Alamat server database MySQL
$databaseName = 'kegiatan';   // Nama database yang akan digunakan
$databaseUsername = 'root';   // Nama pengguna (username) database
$databasePassword = '';       // Kata sandi (password) pengguna database

// Membuat koneksi ke database menggunakan mysqli_connect
$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

// Setelah kode ini dijalankan, variabel $mysqli akan berisi koneksi ke database MySQL.
// Koneksi ini dapat digunakan untuk melakukan operasi-operasi database seperti query, insert, update, dan lainnya.
// Pastikan bahwa variabel-variabel yang telah didefinisikan (hostname, nama database, username, dan password) sesuai dengan pengaturan database yang Anda gunakan.

// Jika koneksi berhasil, query SQL dapan dijalankan pada database yang telah dihubungkan.
// Jika koneksi gagal, Anda perlu mengevaluasi kembali pengaturan yang digunakan untuk mengakses database.
?>
