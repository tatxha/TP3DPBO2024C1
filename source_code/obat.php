<!-- Saya Tattha Maharany Yasmin Akbar dengan NIM 2201805 mengerjakan soal TP 3
dalam Praktikum mata kuliah Desain dan Pemrograman Berbasis Objek, untuk keberkahan-Nya
maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamin. -->

<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Obat.php');
include('classes/Template.php');

$obat = new Obat($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$obat->open();
$obat->getObat();

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($obat->addObat($_POST) > 0) {
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

    $btn = 'Tambah';
    $title = 'Tambah';
}

// cari Obat
if (isset($_POST['btn-cari'])) {
    // methode mencari data Obat
    $obat->searchObat($_POST['cari']);
} else {
    // method menampilkan data Obat
    $obat->getObat();
}


$view = new Template('templates/skintabel.html');

$mainTitle = 'Obat';
$sortOption = '';
// Mengecek apakah ada parameter sort dan order pada URL
if (isset($_GET['sort']) && isset($_GET['order'])) {
    $sort = $_GET['sort'];
    $order = $_GET['order'];
    $obat->sortObat($sort, $order);
    // Membuat link untuk mengurutkan berdasarkan nama obat dengan arah ascending atau descending
}
$sortOption = "
<div>
    <a href='obat.php?sort=nama_obat&order=asc'>Ascending</a> | 
    <a href='obat.php?sort=nama_obat&order=desc'>Descending</a>
</div>";
$header = '
<tr>
<th scope="row">No.</th>
<th scope="row">Nama Obat</th>
<th scope="row">Aksi</th>
</tr>
';
$data = null;
$no = 1;
$formLabel = 'obat';

while ($div = $obat->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['nama_obat'] . '</td>
    <td style="font-size: 22px;">
        <a href="update_obat.php?id=' . $div['id_obat'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;
        <a href="obat.php?hapus=' . $div['id_obat'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($obat->deleteObat($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'obat.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'obat.php';
            </script>";
        }
    }
}


$obat->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->replace('DATA_LINK', "add_obat.php");
$view->replace('SORT', $sortOption);
$view->write();
