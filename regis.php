<?php
session_start();
include "loginSystem/connect.php";

if (isset($_SESSION['sebagai'])) {
  if ($_SESSION['sebagai'] == 'petugas') {
    header("Location: petugas/index.php");
    exit;
  } elseif ($_SESSION['sebagai'] == 'admin') {
    header("Location: admin/index.php");
    exit;
  }
}


if (isset($_POST['btn-login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];


  // Query to check user credentials
  $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
  $result = $connect->query($query);

  if (mysqli_num_rows($result) === 1) {
    $_SESSION['username'] = true;
    $rows = mysqli_fetch_assoc($result);
    if ($rows['sebagai'] == 'petugas') {
      $_SESSION['sebagai'] = $rows['sebagai'];
      $_SESSION['username'] = $rows['username'];
      $_SESSION['nama'] = $rows['nama'];
      // $_SESSION['id'] = $rows['password'];
      return header("Location: petugas/index.php");

      if (isset($_SESSION['username'])) {
        header("Location: petugas/index.php");
        exit;
      }
    } elseif ($rows['sebagai'] == 'admin') {
      $_SESSION['sebagai'] = $rows['sebagai'];
      $_SESSION['username'] = $rows['username'];
      $_SESSION['nama'] = $rows['nama'];
      // $_SESSION['id'] = $rows['password'];
      return header("Location: admin/index.php");


      if (isset($_SESSION['username'])) {
        header("Location: admin/index.php");
        exit;
      }
    }
  } else {
    // Login failed
    echo "Invalid username or password";
  }
}
$connect->close();
?>
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                    <div class="text-center">
                    <button type="submit" name="btn-login" class="btn btn-primary mt-2" style="width:200px; height:50px;">Login</button>
                    <p class="mt-2">Belum punya akun? <a href="daftar.php" class="btn-link text-black">Daftar</a></p>
                    <p class="mt-2">Anda admin? <a href="login.php" class="btn-link text-black">Login Admin</a></p>
                    <p class="mt-2"><a href="index.php" class="btn-link text-black">Kembali</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>