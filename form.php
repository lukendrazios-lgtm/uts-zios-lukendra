<?php 
include 'koneksi.php'; 

$id = "";
$nama = "";
$harga = "";
$stok = "";
$foto_lama = "";
$title = "Tambah Produk";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $title = "Edit Produk";
    $query = "SELECT * FROM produk WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        $nama = $data['nama_produk'];
        $harga = $data['harga'];
        $stok = $data['stok'];
        $foto_lama = $data['foto'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .form-card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 400px; }
        h2 { margin-top: 0; color: #333; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], input[type="file"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { background-color: #ac4caf; color: white; padding: 12px; width: 100%; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; margin-top: 10px; }
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #777; text-decoration: none; font-size: 14px; }
        .preview-img { width: 100px; margin-top: 10px; border-radius: 4px; }
    </style>
</head>
<body>

<div class="form-card">
    <h2><?php echo $title; ?></h2>
    <form id="productForm" action="logika.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="foto_lama" value="<?php echo $foto_lama; ?>">

        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" value="<?php echo $nama; ?>">
        </div>

        <div class="form-group">
            <label>Harga (Rupiah)</label>
            <input type="number" name="harga" id="harga" value="<?php echo $harga; ?>">
        </div>

        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" id="stok" value="<?php echo $stok; ?>">
        </div>

        <div class="form-group">
            <label>Foto Produk (Maks 2MB, JPG/PNG)</label>
            <?php if ($foto_lama) { ?>
                <img src="uploads/<?php echo $foto_lama; ?>" class="preview-img" alt="Lama"><br>
            <?php } ?>
            <input type="file" name="foto" id="foto">
        </div>

        <button type="submit" name="simpan" class="btn-submit">Simpan Data</button>
        <a href="index.php" class="btn-back">Kembali ke Daftar</a>
    </form>
</div>

<script>
    document.getElementById('productForm').onsubmit = function(e) {
        const nama = document.getElementById('nama_produk').value.trim();
        const harga = document.getElementById('harga').value.trim();
        const stok = document.getElementById('stok').value.trim();
        const foto = document.getElementById('foto');
        const id = "<?php echo $id; ?>";

        // Validasi field kosong
        if (!nama || !harga || !stok) {
            alert("Semua field wajib diisi!");
            return false;
        }

        // Validasi foto (hanya jika tambah data baru atau pilih foto baru saat edit)
        if (foto.files.length > 0) {
            const file = foto.files[0];
            const fileType = file.type;
            const fileSize = file.size / 1024 / 1024; // Convert ke MB

            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!validTypes.includes(fileType)) {
                alert("Hanya file JPG, JPEG, atau PNG yang diperbolehkan!");
                return false;
            }

            if (fileSize > 2) {
                alert("Ukuran file maksimal adalah 2 MB!");
                return false;
            }
        } else if (!id) {
            alert("Silakan pilih foto produk!");
            return false;
        }

        return true;
    };
</script>

</body>
</html>