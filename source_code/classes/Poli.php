<!-- Saya Tattha Maharany Yasmin Akbar dengan NIM 2201805 mengerjakan soal TP 3
dalam Praktikum mata kuliah Desain dan Pemrograman Berbasis Objek, untuk keberkahan-Nya
maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamin. -->

<?php

class Poli extends DB
{
    function getPoli()
    {
        $query = "SELECT * FROM poli";
        return $this->execute($query);
    }

    function getPoliById($id)
    {
        $query = "SELECT * FROM poli WHERE id_poli=$id";
        return $this->execute($query);
    }

    function addPoli($data)
    {
        $nama_poli = $data['nama_poli'];
        $query = "INSERT INTO poli VALUES('', '$nama_poli')";
        return $this->executeAffected($query);
    }

    function updatePoli($id, $data)
    {
        // Mendapatkan data yang ingin diperbarui
        $nama_poli = $data['nama_poli'];

        // Mendefinisikan query untuk melakukan pembaruan data poli
        $query = "UPDATE poli SET nama_poli='$nama_poli' WHERE id_poli=$id";

        // Menjalankan query dan mengembalikan hasilnya
        return $this->executeAffected($query);
    }

    function deletePoli($id)
    {
        // Mendefinisikan query untuk menghapus data poli berdasarkan ID
        $query = "DELETE FROM poli WHERE id_poli=$id";

        // Menjalankan query dan mengembalikan hasilnya
        return $this->executeAffected($query);
    }
}
