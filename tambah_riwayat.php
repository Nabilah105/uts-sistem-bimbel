<?php
session_start();
if (!isset($_SESSION['session_login'])) {
    header('Location: login.php');
    exit;
}
require 'function.php';

$siswa = query_db("SELECT * FROM siswa");

if (isset($_POST['submit'])) {
    if (tambah_riwayat($_POST) > 0) {
        echo "<script>alert('Hasil pengerjaan soal berhasil disimpan!'); document.location.href = 'riwayat_soal.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Input Hasil Soal - Bimbel GO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-primary text-white"><h5>➕ Input Pengerjaan Soal Siswa</h5></div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label class="form-label">Pilih Siswa</label>
                        <select name="id_siswa" class="form-select" required>
                            <option value="">Pilih Siswa</option>
                            <?php foreach ($siswa as $s): ?>
                                <option value="<?= $s['id']; ?>"><?= $s['nama']; ?> (<?= $s['nim']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Ujian / Tryout</label>
                        <input type="text" name="nama_ujian" class="form-control" placeholder="Contoh: Tryout UTBK 1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Soal</label>
                        <input type="number" name="nomor_soal" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Jawaban</label>
                        <select name="status" class="form-select" required>
                            <option value="Benar">Benar</option>
                            <option value="Salah">Salah</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Skor / Poin Diperoleh</label>
                        <input type="number" name="skor_diperoleh" class="form-control" placeholder="Contoh: 100" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan Hasil</button>
                    <a href="riwayat_soal.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>