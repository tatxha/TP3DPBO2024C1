<!-- Saya Tattha Maharany Yasmin Akbar dengan NIM 2201805 mengerjakan soal TP 3
dalam Praktikum mata kuliah Desain dan Pemrograman Berbasis Objek, untuk keberkahan-Nya
maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamin. -->

<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Poli.php');
include('classes/Dokter.php');
include('classes/Template.php');

$dokter = new Dokter($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$dokter->open();

$data = nulL;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $dokter->getDokterById($id);
        $row = $dokter->getResult();

        $data .= '<div class="card-header text-center">
        <h3 class="my-0">Detail ' . $row['nama_dokter'] . '</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['foto_dokter'] . '" class="img-thumbnail" alt="' . $row['foto_dokter'] . '" width="60">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>ID</td>
                                    <td>:</td>
                                    <td>' . $row['id_dokter'] . '</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>' . $row['nama_dokter'] . '</td>
                                </tr>
                                <tr>
                                    <td>Poli</td>
                                    <td>:</td>
                                    <td>' . $row['nama_poli'] . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="update_dokter.php?id='. $row['id_dokter'] .'"><button type="button" class="btn btn-success text-white">Ubah Data</button></a>
                <a href="detail_dokter.php?hapus='. $row['id_dokter'] . '"><button type="button" class="btn btn-danger">Hapus Data</button></a>
            </div>';
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($dokter->deleteDokter($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'index.php';
            </script>";
        }
    }
}

$dokter->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL_DOKTER', $data);
$detail->write();
