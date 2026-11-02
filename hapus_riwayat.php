<?php
session_start();
if (!isset($_SESSION['session_login'])) {
    header('Location: login.php');
    exit;
}
require 'function.php';

$id = $_GET['id'];
if (hapus_riwayat($id) > 0) {
    echo "<script>alert('Data pengerjaan berhasil dihapus!'); document.location.href = 'riwayat_soal.php';</script>";
}
?>