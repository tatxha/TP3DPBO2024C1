<!-- Saya Tattha Maharany Yasmin Akbar dengan NIM 2201805 mengerjakan soal TP 3
dalam Praktikum mata kuliah Desain dan Pemrograman Berbasis Objek, untuk keberkahan-Nya
maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamin. -->

<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Poli.php');
include('classes/Dokter.php');
include('classes/Template.php');

// buat instance dokter
$listDokter = new Dokter($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
// Buat instance dokter untuk data poli
$poli = new Poli($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Buka koneksi untuk data poli
$poli->open();

// Ambil data poli dari database
$poli->getPoli();

$dataPoli = null;
while($data = $poli->getResult()){
  $dataPoli .= '<option value="'.$data['id_poli'].'">'.$data['nama_poli'].'</option>';
}

$data = null;

// buka koneksi
$listDokter->open();
// tampilkan data Dokter
$listDokter->getDokterJoin();

// cari Dokter
if (isset($_POST['btn-cari'])) {
    // methode mencari data Dokter
    $listDokter->searchDokter($_POST['cari']);
} else {
    // method menampilkan data Dokter
    $listDokter->getDokterJoin();
}

// cari Dokter
if (isset($_POST['btn-add'])) {
    // methode menadd data Dokter
    if ($listDokter->addDokter($_POST, $_FILES) > 0) {
        echo "<script>
            alert('Data berhasil ditambah!');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambah!');
            document.location.href = 'index.php';
        </script>";
    }
}

  $data .= 
  '<br><form method="post" action="" enctype="multipart/form-data">
      <div class="form-group">
          <label for="inputNamaDokter">Nama Dokter</label>
          <input type="text" class="form-control" id="inputNamaDokter" name="nama_dokter" placeholder="Masukkan Nama Dokter">
      </div><br>
      <div class="form-group">
          <label for="inputPoli">Pilih Poli</label>
          <select id="inputPoli" name="id_poli" class="form-control">
              <option value="">Pilih</option>
              '. $dataPoli.'
          </select>
      </div><br>
      <div class="form-group">
          <label for="inputFotoDokter">Upload Foto Dokter</label><br>
          <input type="file" id="inputFotoDokter" name="foto_dokter">
      </div><br>
  
      <button type="submit" class="btn btn-primary" name="btn-add">Tambah</button>
  </form>';


// tutup koneksi
$listDokter->close();

// buat instance template
$home = new Template('templates/form.html');

// simpan data ke template
$home->replace('TAMBAH_ALL_DATA', $data);
$home->write();
