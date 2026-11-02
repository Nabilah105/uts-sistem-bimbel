<?php
require 'function.php';

if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo "<script>
                alert('Admin baru berhasil terdaftar! Silakan login.');
                document.location.href = 'login.php';
            </script>";
    } else {
        echo mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Admin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .page-register {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }
        .page-register .container {
            width: 100%;
            max-width: 520px;
            margin: 0;
        }
        .page-register .form-card {
            padding: 40px 45px;
        }
    </style>
</head>

<body class="page-register">

    <div class="container">
        <div class="form-card">
            <h3 style="text-align: center;">Registrasi Admin Bimbel</h3>

            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" placeholder="Masukkan username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Masukkan password" required>
                </div>

                <div class="form-group">
                    <label for="konfirmasi_password">Konfirmasi Password</label>
                    <input type="password" name="konfirmasi_password" placeholder="Masukkan kembali password" required>
                </div>

                <div class="button-group">
                    <button type="submit" name="register" class="btn btn-edit">Registrasi</button>
                    <a href="login.php" class="btn btn-kembali">Batal / Login</a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>