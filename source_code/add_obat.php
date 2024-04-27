<!-- Saya Tattha Maharany Yasmin Akbar dengan NIM 2201805 mengerjakan soal TP 3
dalam Praktikum mata kuliah Desain dan Pemrograman Berbasis Objek, untuk keberkahan-Nya
maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamin. -->

<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Obat.php');
include('classes/Template.php');

// buat instance obat
$listObat = new Obat($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$listObat->open();
// tampilkan data Obat
$listObat->getObat();

// cari Obat
if (isset($_POST['btn-cari'])) {
    // methode mencari data Obat
    $listObat->searchObat($_POST['cari']);
} else {
    // method menampilkan data Obat
    $listObat->getObat();
}

// add obat
if (isset($_POST['btn-add'])) {
  // methode menadd data Obat
  if ($listObat->addObat($_POST, $_FILES) > 0) {
      echo "<script>
          alert('Data berhasil ditambah!');
          document.location.href = 'obat.php';
      </script>";
  } else {
      echo "<script>
          alert('Data gagal ditambah!');
          document.location.href = 'obat.php';
      </script>";
  }
}

$data = null;

    $data .= 
    '<br><form method="post">
    <div class="form-group">
      <label for="inputNamaObat">Nama Obat</label>
      <input type="text" class="form-control" id="inputNamaObat" placeholder="Masukkan Nama Obat" name="nama_obat">
    </div><br>

    <button type="submit" class="btn btn-primary" name="btn-add">Tambah</button>
    </form>'
    ;
    
// tutup koneksi
$listObat->close();

// buat instance template
$home = new Template('templates/form.html');

// simpan data ke template
$home->replace('TAMBAH_ALL_DATA', $data);
$home->write();
