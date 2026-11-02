<?php
session_start();
if (!isset($_SESSION['session_login'])) {
    header('Location: login.php');
    exit;
}
require 'function.php';

// fetch data pengerjaan soal digabung dengan nama siswa
$riwayat = query_db("SELECT riwayat_soal.*, siswa.nama FROM riwayat_soal 
                      JOIN siswa ON riwayat_soal.id_siswa = siswa.id");

if (isset($_POST["cari"])) {
    $keyword = $_POST["keyword"];
    $riwayat = cari_riwayat($keyword);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pengerjaan Soal - Bimbel GO Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { min-height: 100vh; background: linear-gradient(180deg, #4e73df 10%, #224abe 100%); color: white; }
        .sidebar .nav-link { color: rgba(255,255,255,.8); font-weight: 600; padding: 12px 20px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,.15); border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3">
                <div class="d-flex align-items-center mb-4 text-white text-decoration-none px-2">
                    <i class="fa-solid fa-graduation-cap fa-2x me-2"></i>
                    <span class="fs-5 fw-bold">Bimbel GO Admin</span>
                </div>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item mb-1">
                        <a href="index.php" class="nav-link">
                            <i class="fa-solid fa-trophy me-2"></i> Leaderboard & Siswa
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="riwayat_soal.php" class="nav-link active">
                            <i class="fa-solid fa-list-check me-2"></i> Detail Pengerjaan Soal
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="px-2">
                    <a href="logout.php" class="btn btn-danger w-100 fw-bold"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h3 fw-bold text-gray-800">Detail Pengerjaan Soal Siswa</h1>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-clipboard-question me-2"></i>Riwayat Jawaban & Hasil Soal</h6>
                        <a href="tambah_riwayat.php" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus me-1"></i> Input Hasil Soal Baru</a>
                    </div>
                    <div class="card-body">

                    <form action="" method="post" class="row g-2 mb-3">
                            <div class="col-md-4">
                                <input type="text" name="keyword" class="form-control" placeholder="Cari nama siswa, uji, atau status...">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" name="cari" class="btn btn-secondary w-100"><i class="fa-solid fa-magnifying-glass me-1"></i> Cari</button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Nama Ujian / Tryout</th>
                                        <th>No. Soal</th>
                                        <th>Status Jawaban</th>
                                        <th>Poin Diperoleh</th>
                                        <th class="text-center" style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($riwayat as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><strong><?= $row['nama']; ?></strong></td>
                                        <td><?= $row['nama_ujian']; ?></td>
                                        <td>Soal #<?= $row['nomor_soal']; ?></td>
                                        <td>
                                            <?php if ($row['status'] == 'Benar'): ?>
                                                <span class="badge bg-success">Benar</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Salah</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><strong>+<?= $row['skor_diperoleh']; ?></strong></td>
                                        <td class="text-center">
                                            <a href="edit_riwayat.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-info text-white me-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="hapus_riwayat.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus record ini?');"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>