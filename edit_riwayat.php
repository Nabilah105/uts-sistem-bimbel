<?php
session_start();
if (!isset($_SESSION['session_login'])) {
    header('Location: login.php');
    exit;
}
require 'function.php';

$id = $_GET['id'];
$riwayat = query_db("SELECT * FROM riwayat_soal WHERE id = $id")[0];
$siswa = query_db("SELECT * FROM siswa");

if (isset($_POST['submit'])) {
    if (edit_riwayat($_POST) > 0) {
        echo "<script>alert('Hasil pengerjaan soal berhasil diperbarui!'); document.location.href = 'riwayat_soal.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Hasil Soal - Bimbel GO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-info text-white"><h5>✏️ Edit Pengerjaan Soal Siswa</h5></div>
            <div class="card-body">
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?= $riwayat['id']; ?>">
                    <div class="mb-3">
                        <label class="form-label">Pilih Siswa</label>
                        <select name="id_siswa" class="form-select" required>
                            <?php foreach ($siswa as $s): ?>
                                <option value="<?= $s['id']; ?>" <?= ($s['id'] == $riwayat['id_siswa']) ? 'selected' : ''; ?>>
                                    <?= $s['nama']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Ujian</label>
                        <input type="text" name="nama_ujian" class="form-control" value="<?= $riwayat['nama_ujian']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Soal</label>
                        <input type="number" name="nomor_soal" class="form-control" value="<?= $riwayat['nomor_soal']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Jawaban</label>
                        <select name="status" class="form-select" required>
                            <option value="Benar" <?= ($riwayat['status'] == 'Benar') ? 'selected' : ''; ?>>Benar</option>
                            <option value="Salah" <?= ($riwayat['status'] == 'Salah') ? 'selected' : ''; ?>>Salah</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Skor Diperoleh</label>
                        <input type="number" name="skor_diperoleh" class="form-control" value="<?= $riwayat['skor_diperoleh']; ?>" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Update Hasil</button>
                    <a href="riwayat_soal.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>