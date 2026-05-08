<?php
include 'koneksi.php';

// Folder penyimpanan foto
$target_dir = "uploads/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// 1. PROSES TAMBAH & EDIT DATA
if (isset($_POST['simpan'])) {
    $id          = $_POST['id'];
    $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga       = $_POST['harga'];
    $stok        = $_POST['stok'];
    $foto_lama   = $_POST['foto_lama'];
    
    $nama_file_final = $foto_lama;

    // Cek apakah user mengunggah foto baru
    if ($_FILES['foto']['name'] != "") {
        $nama_file   = $_FILES['foto']['name'];
        $ukuran_file = $_FILES['foto']['size'];
        $error       = $_FILES['foto']['error'];
        $tmp_name    = $_FILES['foto']['tmp_name'];

        // Ekstensi file
        $ekstensi_gambar = explode('.', $nama_file);
        $ekstensi_gambar = strtolower(end($ekstensi_gambar));
        
        // Generate nama file unik
        $nama_file_baru = uniqid() . '.' . $ekstensi_gambar;

        // Pindahkan file
        if (move_uploaded_file($tmp_name, $target_dir . $nama_file_baru)) {
            // Hapus foto lama jika sedang edit
            if ($id != "" && $foto_lama != "" && file_exists($target_dir . $foto_lama)) {
                unlink($target_dir . $foto_lama);
            }
            $nama_file_final = $nama_file_baru;
        }
    }

    if ($id == "") {
        // Mode Tambah
        $query = "INSERT INTO produk (nama_produk, harga, stok, foto) VALUES ('$nama_produk', '$harga', '$stok', '$nama_file_final')";
        $msg = "Data berhasil ditambahkan!";
    } else {
        // Mode Edit
        $query = "UPDATE produk SET nama_produk='$nama_produk', harga='$harga', stok='$stok', foto='$nama_file_final' WHERE id='$id'";
        $msg = "Data berhasil diperbarui!";
    }

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('$msg'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// 2. PROSES HAPUS DATA
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // Ambil info foto dulu untuk dihapus dari folder
    $query_foto = "SELECT foto FROM produk WHERE id='$id'";
    $res_foto = mysqli_query($conn, $query_foto);
    $data_foto = mysqli_fetch_assoc($res_foto);

    if ($data_foto) {
        if (file_exists($target_dir . $data_foto['foto'])) {
            unlink($target_dir . $data_foto['foto']);
        }

        $query_del = "DELETE FROM produk WHERE id='$id'";
        if (mysqli_query($conn, $query_del)) {
            echo "<script>alert('Data berhasil dihapus!'); window.location='index.php';</script>";
        }
    }
}
?>