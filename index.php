<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - Toko Suzuka</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 20px; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #af4caf; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .thumb { width: 80px; height: 80px; object-fit: cover; border-radius: 4px; }
        .btn { padding: 8px 12px; text-decoration: none; border-radius: 4px; font-size: 14px; color: white; cursor: pointer; border: none; }
        .btn-add { background-color: #cc2ec1; margin-bottom: 15px; display: inline-block; }
        .btn-edit { background-color: #3498db; }
        .btn-delete { background-color: #e74c3c; }
        .actions { display: flex; gap: 5px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Manajemen Data Produk</h2>
    <a href="form.php" class="btn btn-add">+ Tambah Produk Baru</a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM produk ORDER BY id DESC";
            $result = mysqli_query($conn, $query);
            $no = 1;

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td><img src='uploads/" . $row['foto'] . "' class='thumb' alt='foto'></td>";
                    echo "<td>" . htmlspecialchars($row['nama_produk']) . "</td>";
                    echo "<td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>";
                    echo "<td>" . $row['stok'] . "</td>";
                    echo "<td class='actions'>
                            <a href='form.php?id=" . $row['id'] . "' class='btn btn-edit'>Edit</a>
                            <a href='koneksi.php?hapus=" . $row['id'] . "' class='btn btn-delete' onclick='return konfirmasiHapus()'>Hapus</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center;'>Belum ada data produk.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    function konfirmasiHapus() {
        return confirm("Apakah Anda yakin ingin menghapus data ini?");
    }
</script>

</body>
</html>