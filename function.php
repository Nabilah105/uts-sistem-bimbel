<?php
$conn = mysqli_connect('localhost', 'root', '', 'db_bimbel_go');

function query_db($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

//menu pertama siswa dan leaderboard

function tambah_siswa($data) {
    global $conn;
    $nim = htmlspecialchars($data['nim']);
    $nama = htmlspecialchars($data['nama']);
    $kelas = htmlspecialchars($data['kelas']);
    $total_skor = htmlspecialchars($data['total_skor']);

    $gambar = upload_gambar($nim, $nama);
    if (!$gambar) return false;

    $query = "INSERT INTO siswa (nim, nama, kelas, total_skor, gambar)
              VALUES ('$nim', '$nama', '$kelas', '$total_skor', '$gambar')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function edit_siswa($data) {
    global $conn;
    $id = $data['id'];
    $nim = htmlspecialchars($data['nim']);
    $nama = htmlspecialchars($data['nama']);
    $kelas = htmlspecialchars($data['kelas']);
    $total_skor = htmlspecialchars($data['total_skor']);
    $gambarLama = $data['gambarLama'];

    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload_gambar($nim, $nama);
    }

    $query = "UPDATE siswa SET
              nim = '$nim',
              nama = '$nama',
              kelas = '$kelas',
              total_skor = '$total_skor',
              gambar = '$gambar'
              WHERE id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapus_siswa($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM siswa WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function cari_siswa($keyword) {
    global $conn;
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $query = "SELECT * FROM siswa WHERE
              nim LIKE '%$keyword%' OR
              nama LIKE '%$keyword%' OR
              kelas LIKE '%$keyword%'
              ORDER BY total_skor DESC";
    return query_db($query);
}

// up gambar
function upload_gambar($nim, $nama) {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Upload foto siswa terlebih dahulu!');</script>";
        return false;
    }

    $ekstensiValid = ['jpg', 'jpeg', 'png'];
    $ekstensi = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    if (!in_array($ekstensi, $ekstensiValid)) {
        echo "<script>alert('Format file harus JPG/JPEG/PNG!');</script>";
        return false;
    }

    if ($ukuranFile > 5000000) {
        echo "<script>alert('Ukuran file maksimal 5MB!');</script>";
        return false;
    }

    $namaFileBaru = $nim . "_" . preg_replace('/[^a-zA-Z0-9]/', '_', $nama) . "." . $ekstensi;
    move_uploaded_file($tmpName, "img/" . $namaFileBaru);
    return $namaFileBaru;
}

// fungsi bgian registrasi si admin
function registrasi($data)
{
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $konfirmasi_password = mysqli_real_escape_string($conn, $data["konfirmasi_password"]);

    // cek username kalau udh ada di database
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
        alert('Username sudah terdaftar! Gunakan username lainnya!');
    </script>";
        return false;
    }

    // ngecek konfirmasi password
    if ($password !== $konfirmasi_password) {
        echo "<script>
        alert('Konfirmasi password tidak sesuai!');
    </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Menyebutkan nama kolom secara spesifik agar tidak terbentur id AUTO_INCREMENT
    mysqli_query($conn, "INSERT INTO user (username, password) VALUES ('$username', '$password')");
    return mysqli_affected_rows($conn);
}

// menu kedua riwayat soal/detail pengerjaan 

function tambah_riwayat($data) {
    global $conn;
    $id_siswa = htmlspecialchars($data['id_siswa']);
    $nama_ujian = htmlspecialchars($data['nama_ujian']);
    $nomor_soal = htmlspecialchars($data['nomor_soal']);
    $status = htmlspecialchars($data['status']);
    $skor_diperoleh = htmlspecialchars($data['skor_diperoleh']);

    $query = "INSERT INTO riwayat_soal (id_siswa, nama_ujian, nomor_soal, status, skor_diperoleh)
              VALUES ('$id_siswa', '$nama_ujian', '$nomor_soal', '$status', '$skor_diperoleh')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function edit_riwayat($data) {
    global $conn;
    $id = $data['id'];
    $id_siswa = htmlspecialchars($data['id_siswa']);
    $nama_ujian = htmlspecialchars($data['nama_ujian']);
    $nomor_soal = htmlspecialchars($data['nomor_soal']);
    $status = htmlspecialchars($data['status']);
    $skor_diperoleh = htmlspecialchars($data['skor_diperoleh']);

    $query = "UPDATE riwayat_soal SET
              id_siswa = '$id_siswa',
              nama_ujian = '$nama_ujian',
              nomor_soal = '$nomor_soal',
              status = '$status',
              skor_diperoleh = '$skor_diperoleh'
              WHERE id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapus_riwayat($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM riwayat_soal WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function cari_riwayat($keyword) {
    global $conn;
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $query = "SELECT riwayat_soal.*, siswa.nama FROM riwayat_soal 
              JOIN siswa ON riwayat_soal.id_siswa = siswa.id
              WHERE siswa.nama LIKE '%$keyword%' OR 
                    riwayat_soal.nama_ujian LIKE '%$keyword%' OR 
                    riwayat_soal.status LIKE '%$keyword%'";
    return query_db($query);
}