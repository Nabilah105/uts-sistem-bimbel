<?php
session_start();

if (!isset($_SESSION['session_login'])) {
    header('Location: login.php');
    exit;
}

require 'function.php';

// fetch data siswa diurutkan berdasarkan skor tertinggi (leaderboard)
$siswa = query_db("SELECT * FROM siswa ORDER BY total_skor DESC");

// fitur buat nyari data siswa
if (isset($_POST["cari"])) {
    $keyword = $_POST["keyword"];
    $siswa = cari_siswa($keyword);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Leaderboard Bimbel GO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { min-height: 100vh; background: linear-gradient(180deg, #4e73df 10%, #224abe 100%); color: white; }
        .sidebar .nav-link { color: rgba(255,255,255,.8); font-weight: 600; padding: 12px 20px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,.15); border-radius: 5px; }
        .card-header { background-color: #f8f9fc; border-bottom: 1px solid #e3e6f0; }
        .table img { width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #4e73df; }
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
                        <a href="index.php" class="nav-link active">
                            <i class="fa-solid fa-trophy me-2"></i> Leaderboard & Siswa
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="riwayat_soal.php" class="nav-link">
                            <i class="fa-solid fa-list-check me-2"></i> Detail Pengerjaan Soal
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="px-2">
                    <a href="logout.php" class="btn btn-danger w-100 fw-bold">
                        <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                    </a>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h3 fw-bold text-gray-800">Dashboard Leaderboard Siswa</h1>
                    <div class="text-muted">
                        Selamat datang, Kak <strong><?php echo $_SESSION['username']; ?></strong> 👋
                    </div>
                </div>

        
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-ranking-star me-2"></i>Peringkat & Data Siswa</h6>
                        <a href="tambah_siswa.php" class="btn btn-sm btn-primary shadow-sm">
                            <i class="fa-solid fa-user-plus me-1"></i> Tambah Siswa Baru
                        </a>
                    </div>
                    <div class="card-body">

                    <form action="" method="post" class="row g-2 mb-3">
                            <div class="col-md-4">
                                <input type="text" name="keyword" class="form-control" placeholder="Cari nama, NIM, atau kelas...">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" name="cari" class="btn btn-secondary w-100">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i> Cari
                                </button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 80px;">Rank</th>
                                        <th class="text-center" style="width: 80px;">Foto</th>
                                        <th>NIM</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Total Skor</th>
                                        <th class="text-center" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $rank = 1; ?>
                                    <?php foreach ($siswa as $data): ?>
                                        <tr>
                                            <td class="text-center fw-bold">
                                                <span class="badge bg-warning text-dark fs-6">#<?php echo $rank; ?></span>
                                            </td>
                                            <td class="text-center">
                                                <img src="img/<?= $data["gambar"]; ?>" alt="<?= $data["nama"]; ?>">
                                            </td>
                                            <td><?php echo $data["nim"]; ?></td>
                                            <td><strong><?php echo $data["nama"]; ?></strong></td>
                                            <td><?php echo $data["kelas"]; ?></td>
                                            <td><span class="badge bg-success fs-6"><?php echo $data["total_skor"]; ?> pts</span></td>
                                            <td class="text-center">
                                                <a href="edit_siswa.php?id=<?php echo $data["id"]; ?>" class="btn btn-sm btn-info text-white me-1">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <a href="hapus_siswa.php?id=<?php echo $data["id"]; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data siswa ini?');">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php $rank++; ?>
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