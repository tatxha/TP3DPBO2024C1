<!-- Saya Tattha Maharany Yasmin Akbar dengan NIM 2201805 mengerjakan soal TP 3
dalam Praktikum mata kuliah Desain dan Pemrograman Berbasis Objek, untuk keberkahan-Nya
maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamin. -->

<?php

class Obat extends DB
{

    function getObat()
    {
        $query = "SELECT * FROM obat";
        return $this->execute($query);
    }

    function getObatById($id)
    {
        $query = "SELECT * FROM obat WHERE id_obat=$id";
        return $this->execute($query);
    }

    function searchObat($keyword)
    {
        // Membuat query untuk melakukan pencarian obat berdasarkan nama obat
        $query = "SELECT * FROM obat WHERE nama_obat LIKE '%$keyword%'";

        // Menjalankan query dan mengembalikan hasilnya
        return $this->execute($query);
    }

    function addObat($data)
    {
        $nama_obat = $data['nama_obat'];
        $query = "INSERT INTO obat VALUES('', '$nama_obat')";
        return $this->executeAffected($query);
    }

    function updateObat($id, $data)
    {
        // Mendapatkan data yang ingin diperbarui
        $nama_obat = $data['nama_obat'];

        // Mendefinisikan query untuk melakukan pembaruan data obat
        $query = "UPDATE obat SET nama_obat='$nama_obat' WHERE id_obat=$id";

        // Menjalankan query dan mengembalikan hasilnya
        return $this->executeAffected($query);
    }

    function deleteObat($id)
    {
        // Mendefinisikan query untuk menghapus data obat berdasarkan ID
        $query = "DELETE FROM obat WHERE id_obat=$id";

        // Menjalankan query dan mengembalikan hasilnya
        return $this->executeAffected($query);
    }

    function sortObat($sortBy, $sortOrder)
    {
        // Mendefinisikan kriteria pengurutan dan arahnya
        $orderBy = "";
        if ($sortBy == "nama_obat") {
            $orderBy = "ORDER BY nama_obat";
        } else {
            // Default sorting jika tidak ada kriteria yang valid
            $orderBy = "ORDER BY id_obat";
        }

        // Mendefinisikan arah pengurutan
        $orderDirection = "";
        if ($sortOrder == "desc") {
            $orderDirection = "DESC";
        } else {
            $orderDirection = "ASC";
        }

        // Membuat query untuk mengambil data obat dengan kriteria pengurutan
        $query = "SELECT * FROM obat $orderBy $orderDirection";

        // Menjalankan query dan mengembalikan hasilnya
        return $this->execute($query);
    }

}
