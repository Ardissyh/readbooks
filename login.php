<?php
session_start();
include "loginSystem/connect.php";
if (isset($_POST['nisn']) && isset($_POST['nama'])) {
    // Get user input
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];

    // Query to check user credentials
    $query = "SELECT * FROM member WHERE nisn='$nisn' AND nama='$nama'";
    $result = $connect->query($query);

    if ($result->num_rows == 1) {
        // Login successful
        $_SESSION['nama'] = $nama;
        $_SESSION['nisn'] = $nisn;
        header("Location: member/dashboard.php"); // Redirect to dashboard or any other page
    } else {
        // Login failed
        echo "<script>alert('nis atau nama Anda salah. Silahkan coba lagi!')</script>";
    }
}
$connect->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>Readbooks.com</title>
    <link rel="icon" href="assets/iconblack.png" type="image/png">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-image: url(assets/perpus.jpg);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
        }

        .container {
            max-width: 400px;
            margin-top: 0 none;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-radius: 15px 15px 0 0;
            padding: 20px;
            text-align: center;
        }

        .card-header h3 {
            margin: 0;
        }


        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .bg-black {
            color: #000000;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="">Login Siswa</h3>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="number" class="form-control" id="nisn" name="nisn" required>
                    </div>
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="signIp" class="btn btn-primary mt-2" style="width:200px; height:50px;">Login</button>
                        <p class="mt-2">Belum punya akun? <a href="daftar.php" class="btn-link text-black">Daftar</a></p>
                        <p class="mt-2">Anda admin? <a href="login_admin.php" class="btn-link text-black">Login Admin</a></p>
                        <p class="mt-2"><a href="index.php" class="btn-link text-black">Kembali</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>