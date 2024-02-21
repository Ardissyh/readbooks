<?php
session_start();
if (isset($_SESSION['sebagai'])) {
    if ($_SESSION['sebagai'] == 'petugas') {
        header("Location: petugas/index.php");
        exit;
    }
}

include "../config/config.php";
$kategori = queryReadData("SELECT * FROM kategori_buku");
$databuku = queryReadData("SELECT * FROM buku");

if (isset($_POST["tambah"])) {

    if (tambahBuku($_POST) > 0) {
        echo "<script>
      alert('Data buku berhasil ditambahkan!');
      window.location='data-buku.php';
      </script>";
    } else {
        echo "<script>
      alert('Data buku gagal ditambahkan!');
      window.location='data-buku.php';
      </script>";
    }
}


//search buku
if (isset($_POST["search"])) {
    $databuku = search($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>Readbooks.com</title>
    <link rel="icon" href="../assets/iconblack.png" type="image/png">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        #sidebar {
            background-color: #212529;
            color: #fff;
        }

        #content {
            transition: margin-left 0.5s;
            padding: 15px;
        }

        #sidebarCollapse {
            background-color: #343a40;
            border: none;
            color: #fff;
        }

        #sidebarCollapse:hover {
            background-color: #212529;
        }

        .navbar {
            background-color: #212529;
        }

        .navbar-brand {
            color: #fff;
        }

        .navbar-toggler-icon {
            background-color: #fff;
        }

        .nav-link:hover {
            color: #f8f9fa;
        }

        /* Tombol pada Sidebar */
        .nav-link {
            padding: 10px;
            /* Padding untuk memberikan ruang di sekitar teks tombol */
            text-decoration: none;
            /* Menghilangkan garis bawah default */
            color: #dee2e6;
            /* Warna teks tombol */
            transition: background-color 0.3s, color 0.3s;
            /* Efek transisi hover */
        }

        /* Efek Hover pada Tombol */
        .nav-link:hover {
            background-color: #3d4852;
            /* Warna latar belakang saat dihover */
            color: #fff;
            /* Warna teks saat dihover */
        }

        /* Tombol Aktif pada Sidebar */
        .nav-link.active {
            background-color: #3d4852;
            /* Warna latar belakang tombol aktif */
            color: #fff;
            /* Warna teks tombol aktif */
        }

        .center-text {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
    </style>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .scrollable-card {
            max-height: 460px;
            /* Atur tinggi maksimum sesuai kebutuhan */
            overflow-y: auto;
            /* Aktifkan scrolling vertikal jika kontennya melebihi tinggi maksimum */
        }
    </style>


</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><img src="../assets/readbook.png" width="150px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="navbar-brand text-center">Data Buku</span>
                    </li>
                    <li class="nav-item">
                        <i id="profile-icon" class="bi bi-person-circle text-light" data-bs-toggle="dropdown">
                            <img src="../assets/adminLogo.png" alt="Avatar Logo" style="width:40px;" class="rounded-pill"></i>
                        <ul class="dropdown-menu bg-primary dropdown-menu-end">
                            <li><img src="../assets/adminLogo.png" alt="Avatar Logo" style="width:40px;" class="rounded-pill mx-auto d-block"></i></li>
                            <li><a class="btn mx-auto d-block mt-2" href="#"><?= $_SESSION['username']; ?></a></li>
                            <li><a class="btn mx-auto d-block" href="#"><?= $_SESSION['sebagai']; ?></a></li>
                            <li><a class="btn mx-auto d-block bg-danger" href="logout.php" onclick="return confirm('Apakah anda ingin keluar dari aplikasi ini?');">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block position-fixed vh-100">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="data-buku.php">
                                Data Buku
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="data-member.php">
                                Data Member
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pengguna.php">
                                Data Pengguna
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content Area -->
            <main id="content" class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Content goes here -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="mt-2">Data Buku</h2>
                        <!-- Button to Open the Modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                            Tambah Buku
                        </button>
                    </div>
                    <div class="card-body scrollable-card">
                        <form class="d-flex" action="" method="post">
                            <input class="form-control me-2" type="text" name="keyword" id="keyword" placeholder="Search">
                            <button class="btn btn-primary" type="submit" name="search">Search</button>
                        </form>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cover</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Pengarang</th>
                                    <th>Penerbit</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1; // Nomor urut dimulai dari 1
                                foreach ($databuku as $item) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><img src="../imgDB/<?= $item['cover']; ?>" alt="" width="70px" height="100px" style="border-radius: 5px;"></td>
                                        <td><?= $item["judul"]; ?></td>
                                        <td><?= $item["kategori"]; ?></td>
                                        <td><?= $item["pengarang"]; ?></td>
                                        <td><?= $item["penerbit"]; ?></td>
                                        <td>
                                            <a href="" class="btn btn-success mt-2">Detail</a>
                                            <a href="" class="btn btn-warning mt-2">Edit</a>
                                            <a href="" class="btn btn-danger mt-2" onclick="return confirm('Apakah Buku <?= $item['judul']; ?> ingin anda hapus?');">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" method="post" enctype="multipart/form-data" class="">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Form Tambah Buku</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="custom-css-form">
                            <div class="mb-3">
                                <label for="formFileMultiple" class="form-label">Cover Buku</label>
                                <input class="form-control" type="file" name="cover" id="cover" required>
                            </div>

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Id Buku</label>
                                <input type="text" class="form-control" name="id_buku" id="id_buku" placeholder="example inf01" required>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Kategori</label>
                            <select class="form-select" id="kategori" name="kategori">
                                <option selected>Choose</option>
                                <?php foreach ($kategori as $item) : ?>
                                    <option><?= $item["kategori"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-book"></i></span>
                            <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul Buku" aria-label="Username" aria-describedby="basic-addon1" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Pengarang</label>
                            <input type="text" class="form-control" name="pengarang" id="pengarang" placeholder="nama pengarang" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Penerbit</label>
                            <input type="text" class="form-control" name="penerbit" id="penerbit" placeholder="nama penerbit" required>
                        </div>

                        <label for="validationCustom01" class="form-label">Tahun Terbit</label>
                        <div class="input-group mt-0">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-calendar-days"></i></span>
                            <input type="date" class="form-control" name="thn_terbit" id="thn_terbit" required>
                        </div>

                        <label for="validationCustom01" class="form-label">Jumlah Halaman</label>
                        <div class="input-group mt-0">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-book-open"></i></span>
                            <input type="number" class="form-control" name="jml_halaman" id="jml_halaman" required>
                        </div>

                        <div class="form-floating mt-3 mb-3">
                            <textarea class="form-control" placeholder="sinopsis tentang buku ini" name="deskripsi" id="deskripsi" style="height: 100px"></textarea>
                            <label for="floatingTextarea2">Deskripsi</label>
                        </div>

                        <div class="custom-css-form">
                            <div class="mb-3">
                                <label for="formFileMultiple" class="form-label">Isi Buku</label>
                                <input class="form-control" type="file" name="isi_buku" id="isi_buku" required>
                            </div>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button class="btn btn-success" type="submit" name="tambah">Tambah</button>
                            <input type="reset" class="btn btn-warning text-light" value="Reset">
                        </div>
                </form>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('active');
        });
    </script>
</body>

</html>