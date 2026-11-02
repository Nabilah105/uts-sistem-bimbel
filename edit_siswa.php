<?php
session_start();
if (!isset($_SESSION['session_login'])) {
    header('Location: login.php');
    exit;
}
require 'function.php';

$id = $_GET['id'];
$siswa = query_db("SELECT * FROM siswa WHERE id = $id")[0];

if (isset($_POST['submit'])) {
    if (edit_siswa($_POST) > 0) {
        echo "<script>
            alert('Data siswa berhasil diubah!');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>alert('Gagal merubah data siswa!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Siswa - Bimbel GO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">✏️ Edit Data Siswa</h5>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $siswa['id']; ?>">
                    <input type="hidden" name="gambarLama" value="<?= $siswa['gambar']; ?>">

                    <div class="mb-3">
                        <label class="form-label">NIM / ID Siswa</label>
                        <input type="text" name="nim" class="form-control" value="<?= $siswa['nim']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Siswa</label>
                        <input type="text" name="nama" class="form-control" value="<?= $siswa['nama']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text" name="kelas" class="form-control" value="<?= $siswa['kelas']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Skor</label>
                        <input type="number" name="total_skor" class="form-control" value="<?= $siswa['total_skor']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ganti Foto Siswa (Opsional)</label><br>
                        <img src="img/<?= $siswa['gambar']; ?>" width="70" class="mb-2 rounded">
                        <input type="file" name="gambar" class="form-control">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>