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

// buka koneksi
$listDokter->open();
// tampilkan data Dokter
$listDokter->getDokterJoin();

$data = null;

// ambil data Dokter
// gabungkan dgn tag html
// untuk di passing ke skin/template
while ($row = $listDokter->getResult()) {
    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 dokter-thumbnail">
        <a href="detail_dokter.php?id=' . $row['id_dokter'] . '">
            <div class="row justify-content-center">
                <img src="assets/images/' . $row['foto_dokter'] . '" class="card-img-top" alt="' . $row['foto_dokter'] . '">
            </div>
            <div class="card-body">
                <p class="card-text nama-dokter my-0">' . $row['nama_dokter'] . '</p>
                <p class="card-text nama-poli"> Sp. ' . $row['nama_poli'] . '</p>
            </div>
        </a>
    </div>    
    </div>';
}

// tutup koneksi
$listDokter->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('ALL_DATA', $data);
$home->write();
