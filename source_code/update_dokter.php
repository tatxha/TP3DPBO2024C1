<!-- Saya Tattha Maharany Yasmin Akbar dengan NIM 2201805 mengerjakan soal TP 3
dalam Praktikum mata kuliah Desain dan Pemrograman Berbasis Objek, untuk keberkahan-Nya
maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamin. -->

<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Poli.php');
include('classes/Dokter.php');
include('classes/Template.php');

// Buat instance dokter untuk data poli
$poli = new Poli($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Buka koneksi untuk data poli
$poli->open();

$row = null;
// Ambil data poli dari database
$poli->getPoli();

// buat instance dokter
$listDokter = new Dokter($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$listDokter->open();
// tampilkan data Dokter
$listDokter->getDokter();

$data = null;

if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    // update Dokter
    if (isset($_POST['btn-update'])) {
        // methode menadd data Dokter
        if ($listDokter->updateDokter($id, $_POST, $_FILES) > 0) {
            echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'detail_dokter.php?id=$id';
            </script>";
        } else {
            echo "<script>
            alert('Data gagal diubah!');
                document.location.href = 'detail_dokter.php?id=$id';
            </script>";
        }
    }

    if($id > 0){
        $listDokter->getDokterById($id);
        $row = $listDokter->getResult();

        // Bagian select
        $dataPoliOptions = null;
        $poli->getPoli(); // Ambil data poli lagi untuk menghindari penutupan koneksi yang dilakukan sebelumnya
        while($poliData = $poli->getResult()){
          $selected = ($poliData['id_poli'] == $row['id_poli']) ? 'selected' : ''; // menambahkan atribut selected jika nilai sama dengan yang dipilih sebelumnya
          $dataPoliOptions .= '<option value="'.$poliData['id_poli'].'" '.$selected.'>'.$poliData['nama_poli'].'</option>';
        }

        // Form untuk update
        $data .= 
        '<br>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="inputNamaDokter">Nama Dokter</label>
                <input type="text" class="form-control" id="inputNamaDokter" name="nama_dokter" placeholder="Masukkan Nama Dokter" value="'. $row['nama_dokter'] .'">
            </div><br>
            <div class="form-group">
                <label for="inputPoli">Pilih Poli</label>
                <select id="inputPoli" name="id_poli" class="form-control">
                    <option value="">Pilih</option>
                    '. $dataPoliOptions.'
                </select>
            </div><br>
            <div class="form-group">
                <label for="inputFotoDokter">Upload Foto Dokter</label><br>
                <img src="assets/images/'.$row['foto_dokter'].'" style="width: 150px; height: 200px; object-fit: cover;"><br>
                <input type="file" id="inputFotoDokter" name="foto_dokter">
            </div><br>
        
            <button type="submit" class="btn btn-primary" name="btn-update">Ubah</button>
        </form>';
    }
}
// }

// tutup koneksi
$listDokter->close();

// buat instance template
$home = new Template('templates/form.html');

// simpan data ke template
$home->replace('TAMBAH_ALL_DATA', $data);
$home->write();
