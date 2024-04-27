<!-- Saya Tattha Maharany Yasmin Akbar dengan NIM 2201805 mengerjakan soal TP 3
dalam Praktikum mata kuliah Desain dan Pemrograman Berbasis Objek, untuk keberkahan-Nya
maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamin. -->

<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Poli.php');
include('classes/Template.php');

$poli = new Poli($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$poli->open();
$poli->getPoli();

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($poli->addPoli($_POST) > 0) {
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

    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Poli';
$header = '
<tr>
<th scope="row">No.</th>
<th scope="row">Nama Poli</th>
<th scope="row">Aksi</th>
</tr>
';
$data = null;
$no = 1;
$formLabel = 'poli';

while ($div = $poli->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['nama_poli'] . '</td>
    <td style="font-size: 22px;">
        <a href="update_poli.php?id=' . $div['id_poli'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;
        <a href="poli.php?hapus=' . $div['id_poli'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($poli->updatePoli($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'poli.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'poli.php';
            </script>";
            }
        }

        $poli->getPoliById($id);
        $row = $poli->getResult();

        $dataUpdate = $row['nama_poli'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($poli->deletePoli($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'poli.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'poli.php';
            </script>";
        }
    }
}

$poli->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->replace('DATA_LINK', "add_poli.php");
$view->replace('SORT', '');
$view->write();