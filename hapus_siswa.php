<?php
session_start();
if (!isset($_SESSION['session_login'])) {
    header('Location: login.php');
    exit;
}
require 'function.php';

$id = $_GET['id'];
if (hapus_siswa($id) > 0) {
    echo "<script>
        alert('Data siswa berhasil dihapus!');
        document.location.href = 'index.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menghapus data!');
        document.location.href = 'index.php';
    </script>";
}
?>