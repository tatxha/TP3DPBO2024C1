<!-- Saya Tattha Maharany Yasmin Akbar dengan NIM 2201805 mengerjakan soal TP 3
dalam Praktikum mata kuliah Desain dan Pemrograman Berbasis Objek, untuk keberkahan-Nya
maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamin. -->

<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Poli.php');
include('classes/Template.php');

// buat instance poli
$listPoli = new Poli($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$listPoli->open();
// tampilkan data Poli
$listPoli->getPoli();

// cari Poli
if (isset($_POST['btn-cari'])) {
    // methode mencari data Poli
    $listPoli->searchPoli($_POST['cari']);
} else {
    // method menampilkan data Poli
    $listPoli->getPoli();
}

// add poli
if (isset($_POST['btn-add'])) {
    // methode menadd data Poli
    if ($listPoli->addPoli($_POST, $_FILES) > 0) {
        echo "<script>
            alert('Data berhasil ditambah!');
            document.location.href = 'poli.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambah!');
            document.location.href = 'poli.php';
        </script>";
    }
  }



$data = null;

    $data .= 
    '<br><form method="post">
    <div class="form-group">
      <label for="inputNamaPoli">Nama Poli</label>
      <input type="text" class="form-control" id="inputNamaPoli" placeholder="Masukkan Nama Poli" name="nama_poli">
    </div><br>

    <button type="submit" class="btn btn-primary" name="btn-add">Tambah</button>
    </form>'
    ;

// tutup koneksi
$listPoli->close();

// buat instance template
$home = new Template('templates/form.html');

// simpan data ke template
$home->replace('TAMBAH_ALL_DATA', $data);
$home->write();
