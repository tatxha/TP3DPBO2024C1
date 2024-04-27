<!-- Saya Tattha Maharany Yasmin Akbar dengan NIM 2201805 mengerjakan soal TP 3
dalam Praktikum mata kuliah Desain dan Pemrograman Berbasis Objek, untuk keberkahan-Nya
maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamin. -->

<?php

class Dokter extends DB
{
    function getDokterJoin()
    {
        $query = "SELECT * FROM dokter JOIN poli ON dokter.id_poli=poli.id_poli ORDER BY dokter.id_dokter";

        return $this->execute($query);
    }

    function getDokter()
    {
        $query = "SELECT * FROM dokter";
        return $this->execute($query);
    }

    function getDokterById($id)
    {
        $query = "SELECT * FROM dokter JOIN poli ON dokter.id_poli=poli.id_poli WHERE id_dokter=$id";
        return $this->execute($query);
    }

    function searchDokter($keyword)
    {
        // ...
    }

    function addDokter($data, $files)
    {
        $nama_dokter = $data['nama_dokter'];
        $id_poli = $data['id_poli'];
        $nama_file = $files['foto_dokter']['name'];
        $tmp_file = $files['foto_dokter']['tmp_name'];
        $direktori = 'assets/images/' . $nama_file;
        
        // Pindahkan file yang diunggah ke direktori tujuan
        $push = move_uploaded_file($tmp_file, $direktori);
        if(!$push){
            $nama_file = 'icon.png';
        }

        // Mendefinisikan query untuk menambahkan data dokter
        $query = "INSERT INTO dokter (nama_dokter, id_poli, foto_dokter) VALUES ('$nama_dokter', '$id_poli', '$nama_file')";

        // Menjalankan query dan mengembalikan hasilnya
        return $this->executeAffected($query);
    }



    function updateDokter($id, $data, $file)
    {
        // Tangkap data yang diterima dari formulir
        $nama_dokter = $data['nama_dokter'];
        $id_poli = $data['id_poli'];

        // Periksa apakah ada file foto yang diunggah
        if ($file['foto_dokter']['name']) {
            // Jika ada file foto yang diunggah, simpan informasi tentang file tersebut
            $nama_file = $file['foto_dokter']['name'];
            $tmp_file = $file['foto_dokter']['tmp_name'];
            $direktori = 'assets/images/' . $nama_file;

            // Pindahkan file yang diunggah ke direktori tujuan
            $push = move_uploaded_file($tmp_file, $direktori);
            if (!$push) {
                // Jika gagal memindahkan file, gunakan foto default
                $nama_file = 'icon.png';
            }

            // Mendefinisikan query untuk memperbarui data dokter beserta foto
            $query = "UPDATE dokter SET nama_dokter='$nama_dokter', id_poli='$id_poli', foto_dokter='$nama_file' WHERE id_dokter=$id";
        } else {
            // Jika tidak ada file foto yang diunggah, hanya perbarui data dokter tanpa foto
            $query = "UPDATE dokter SET nama_dokter='$nama_dokter', id_poli='$id_poli' WHERE id_dokter=$id";
        }

        // Menjalankan query dan mengembalikan hasilnya
        return $this->executeAffected($query);
    }


    function deleteDokter($id)
    {
        // Mendefinisikan query untuk menghapus data dokter berdasarkan ID
        $query = "DELETE FROM dokter WHERE id_dokter=$id";

        // Menjalankan query dan mengembalikan hasilnya
        return $this->executeAffected($query);
    }
}
