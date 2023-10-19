<?php
include_once("koneksi.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, 
    initial-scale=1.0">
    
    <!-- Digunkan untuk menghubungkan ke framework Bootstrap   -->
    <!-- Bootstrap offline -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <!-- Bootstrap Online -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>To Do List</title> <!--Judul Halaman-->
</head>

<body>
    <div class="container mt-3">
        <h3>
            To Do List
            <small class="text-muted">
                Catat semua hal yang akan kamu kerjakan disini.
            </small>
        </h3>
        <hr>

        <!--Form Input Data-->

        <!-- Kode untuk mengambil input pengguna, menampilkan data yang akan diubah, dan menangani simpan perubahan -->
        <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
        
            <!-- Kode php untuk menghubungkan form dengan database -->
            <?php
                // Deklarasi Variabel: digunakan untuk menyimpan data yang diambil dari database. 
                // Awalnya, semuanya diinisialisasi dengan string kosong.
                $isi = '';
                $tgl_awal = '';
                $tgl_akhir = '';

                // Pengecekan Parameter GET: memeriksa apakah parameter id telah diteruskan melalui URL dengan menggunakan metode GET. 
                // Jika id ada dalam URL, blok kode di dalamnya akan dieksekusi.
                if (isset($_GET['id'])) {

                    // Pengambilan Data dari Database: menggunakan fungsi mysqli_query untuk menjalankan query SQL pada database. 
                    // Query ini mengambil semua kolom dari tabel 'kegiatan' di mana nilai kolom 'id' sesuai dengan nilai yang diteruskan melalui parameter GET.
                    $ambil = mysqli_query($mysqli, 
                    "SELECT * FROM kegiatan 
                    WHERE id='" . $_GET['id'] . "'");

                    // Pengisian Variabel dengan Data dari Database:
                    // Dalam loop while, kode ini mengambil setiap baris hasil query satu per satu menggunakan fungsi mysqli_fetch_array. 
                    // Nilai-nilai dari kolom 'isi', 'tgl_awal', dan 'tgl_akhir' kemudian disimpan dalam variabel yang telah dideklarasikan sebelumnya.
                    while ($row = mysqli_fetch_array($ambil)) {
                        $isi = $row['isi'];
                        $tgl_awal = $row['tgl_awal'];
                        $tgl_akhir = $row['tgl_akhir'];
                    }
            ?>

            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"> <?php
            }
            ?>

            <!-- Kode untuk membuat tampilan form input dan tombol submit -->
            <div class="col mb-2">
                <label for="inputIsi" class="form-label fw-bold">
                    Kegiatan
                </label>
                <input type="text" class="form-control" name="isi" id="inputIsi" placeholder="Kegiatan"
                    value="<?php echo $isi ?>">
            </div>
            <div class="col mb-2">
                <label for="inputTanggalAwal" class="form-label fw-bold">
                    Tanggal Awal
                </label>
                <input type="date" class="form-control" name="tgl_awal" id="inputTanggalAwal" placeholder="Tanggal Awal"
                    value="<?php echo $tgl_awal ?>">
            </div>
            <div class="col mb-2">
                <label for="inputTanggalAkhir" class="form-label fw-bold">
                    Tanggal Akhir
                </label>
                <input type="date" class="form-control" name="tgl_akhir" id="inputTanggalAkhir"
                    placeholder="Tanggal Akhir" value="<?php echo $tgl_akhir ?>">
            </div>
            <div class="col mb-2 d-flex">
                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
            </div>
        </form>

    <!-- Table-->
    <table class="table table-hover">

    <!--thead atau baris judul pada tabel-->
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Kegiatan</th>
            <th scope="col">Awal</th>
            <th scope="col">Akhir</th>
            <th scope="col">Status</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>

    <!--tbody berisi isi tabel sesuai dengan judul atau head-->
    <tbody>
        <!-- Kode PHP untuk menampilkan semua isi dari tabel urut berdasarkan status dan tanggal awal-->
        <!-- Kode ini menggunakan fungsi mysqli_query untuk menjalankan query SQL pada database. Query ini mengambil semua kolom dari tabel 'kegiatan' dan mengurutkannya berdasarkan dua kolom: 'status' dan 'tgl_awal'. Data yang diambil akan disimpan dalam variabel $result. -->
        <?php
        $result = mysqli_query(
            $mysqli,"SELECT * FROM kegiatan ORDER BY status,tgl_awal"
            );
        $no = 1;   // inisialisasi Variabel Penomoran
        while ($data = mysqli_fetch_array($result)) {
        ?>

            <tr>
                <th scope="row"><?php echo $no++ ?></th>  <!-- Penomoran Baris -->

                <!-- Menampilkan Data: Menggunakan echo untuk menampilkan data dari array $data -->
                <td><?php echo $data['isi'] ?></td>       
                <td><?php echo $data['tgl_awal'] ?></td>  
                <td><?php echo $data['tgl_akhir'] ?></td>

                <!-- Tombol Status: Tombol ini bergantung pada nilai $data['status']. Jika status sama dengan 1, tombol berwarna hijau dengan label "Sudah", dan jika tidak, tombol berwarna kuning dengan label "Belum" -->
                <td>
                    <?php
                    if ($data['status'] == '1') {
                    ?>
                        <a class="btn btn-success rounded-pill px-3" type="button" 
                        href="index.php?id=<?php echo $data['id'] ?>&aksi=ubah_status&status=0">
                        Sudah
                        </a>
                    <?php
                    } else {
                    ?>
                        <a class="btn btn-warning rounded-pill px-3" type="button" 
                        href="index.php?id=<?php echo $data['id'] ?>&aksi=ubah_status&status=1">
                        Belum</a>
                    <?php
                    }
                    ?>
                </td>

                <!-- Tombol Ubah dan Hapus: Tombol ini memberikan opsi untuk mengubah atau menghapus entri dengan mengarahkan ke fungsi php -->
                <td>
                    <a class="btn btn-info rounded-pill px-3" 
                    href="index.php?id=<?php echo $data['id'] ?>">Ubah
                    </a>
                    <a class="btn btn-danger rounded-pill px-3" 
                    href="index.php?id=<?php echo $data['id'] ?>&aksi=hapus">Hapus
                    </a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
</div>

</body>
<?php
// Simpan dan Update Data:
// Memeriksa apakah data telah disubmit melalui metode POST dan apakah ada data yang dikirim.
if (isset($_POST['simpan'])) {

    // Jika ada, maka kode akan memeriksa apakah ada sebuah "id" yang sudah ada dalam $_POST. 
    if (isset($_POST['id'])) {
        // Jika ada, kode akan menganggap ini sebagai permintaan untuk memperbarui data yang sudah ada dalam database
        $ubah = mysqli_query($mysqli, "UPDATE kegiatan SET 
                                        isi = '" . $_POST['isi'] . "',
                                        tgl_awal = '" . $_POST['tgl_awal'] . "',
                                        tgl_akhir = '" . $_POST['tgl_akhir'] . "'
                                        WHERE
                                        id = '" . $_POST['id'] . "'");
    } else {
        // jika tidak, kode akan menganggap ini sebagai permintaan untuk menambahkan data baru.
        $tambah = mysqli_query($mysqli, "INSERT INTO kegiatan(isi,tgl_awal,tgl_akhir,status) 
                                        VALUES ( 
                                            '" . $_POST['isi'] . "',
                                            '" . $_POST['tgl_awal'] . "',
                                            '" . $_POST['tgl_akhir'] . "',
                                            '0'
                                            )");
    }

    // Setelah melakukan operasi yang diminta, kode akan melakukan pengalihan halaman dengan mengubah lokasi ke "index.php"
    echo "<script> 
            document.location='index.php';
            </script>";
}

// Penghapusan dan Perubahan Status:
//  memeriksa apakah ada parameter "aksi" dalam URL ($_GET['aksi']), yang menunjukkan tindakan yang diminta oleh pengguna (misalnya, "hapus" atau "ubah_status").
if (isset($_GET['aksi'])) {
    
    // Jika permintaan adalah untuk menghapus data, maka kode akan menghapus data dengan id yang sesuai dari database.
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM kegiatan WHERE id = '" . $_GET['id'] . "'");
        
    // Jika permintaan adalah untuk mengubah status data, maka kode akan memperbarui status data dengan id yang sesuai.
    } else if ($_GET['aksi'] == 'ubah_status') {
        $ubah_status = mysqli_query($mysqli, "UPDATE kegiatan SET 
                                        status = '" . $_GET['status'] . "' 
                                        WHERE
                                        id = '" . $_GET['id'] . "'");
    }

    // Setelah melakukan operasi yang diminta, kode akan melakukan pengalihan halaman dengan mengubah lokasi ke "index.php"
    echo "<script> 
            document.location='index.php';
            </script>";
}
?>

</html>
