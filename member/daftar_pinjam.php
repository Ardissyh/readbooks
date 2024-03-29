<?php
// Start the session
session_start();

// Check if 'nama' is set in the session, if not, redirect to the login page
if (!isset($_SESSION['nama'])) {
  header("Location: ../login.php");
  exit();
}

if (!isset($_SESSION['nisn'])) {
  header("Location: ../login.php");
  exit();
}

// Access the NIS from the session
$nisn = $_SESSION['nisn'];

// Now you can use $nis wherever you need it

require "../config/config.php";

// Assuming $id is the specific value you want to match
$peminjaman = queryReadData("SELECT * FROM peminjaman
INNER JOIN buku ON peminjaman.id_buku = buku.id_buku
INNER JOIN member ON peminjaman.nisn = member.nisn
INNER JOIN user ON peminjaman.id_user = user.id
WHERE peminjaman.nisn = $nisn");

?>


<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
  <title>Readbooks.com</title>
  <link rel="icon" href="../assets/iconblack.png" type="image/png">
</head>
<style>
  body {
    display: flex;
    align-items: top;
    justify-content: top;
    background-image: url(../assets/perpus.jpg);
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    background-attachment: fixed;
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
    max-height: 600px;
    /* Atur tinggi maksimum sesuai kebutuhan */
    overflow-y: auto;
    /* Aktifkan scrolling vertikal jika kontennya melebihi tinggi maksimum */
  }
</style>

<body>

  <nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <div class="dropdown" data-bs-theme="dark">
        <button class="btn btn-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="../assets/memberLogo.png" alt="memberLogo" width="40px">
        </button>
        <ul style="margin-right: -7rem;" class="dropdown-menu position-absolute mt-2 p-2">
          <li>
            <a class="dropdown-item text-center" href="#">
              <img src="../assets/memberLogo.png" alt="adminLogo" width="30px">
            </a>
          </li>
          <li>
            <a class="dropdown-item text-center text-secondary" href="#"> <span class="text-capitalize"><?php echo $_SESSION['nama']; ?></span></a>
            <a class="dropdown-item text-center mb-2" href="#">Siswa</a>
          </li>
          <li>
            <a class="dropdown-item text-center p-2 bg-danger text-light rounded" href="logout.php">Logout <i class="fa-solid fa-right-to-bracket"></i></a>
          </li>
        </ul>
      </div>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mynavbar">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">Daftar Buku</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="daftar_pinjam.php">Daftar Pinjam</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="history.php">History</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <div class="container-xxl p-5 my-5">
    <div class="">
      <div class="alert alert-dark" role="alert">Data Peminjaman Buku Anda</div>
      <!-- Content goes here -->
      <div class="card">
        <div class="card-header">
          <h2 class="mt-4">Data Peminjaman Buku Anda</h2>
        </div>
        <div class="card-body scrollable-card">
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Cover</th>
                <th>Judul</th>
                <th>NISN</th>
                <th>Nama Peminjam</th>
                <th>Nama Petugas</th>
                <th>Tgl. Pinjam</th>
                <th>Tgl. Akhir</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1; // Nomor urut dimulai dari 1
              if (isset($peminjaman) && is_array($peminjaman) && count($peminjaman) > 0) {
                foreach ($peminjaman as $item) :
              ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><img src="../imgDB/<?= $item['cover']; ?>" alt="" width="70px" height="100px" style="border-radius: 5px;"></td>
                    <td><?= $item['judul']; ?></td>
                    <td><?= $item['nisn']; ?></td>
                    <td><?= $item['nama']; ?></td>
                    <td><?= $item['username']; ?></td>
                    <td><?= $item['tgl_pinjam']; ?></td>
                    <td><?= $item['tgl_kembali']; ?></td>
                    <td>
                      <?php
                      if ($item['status'] == '0') {
                        echo '<b class="badge bg-danger">Belum ada Izin</b>';
                      } elseif ($item['status'] == '1') {
                        ?>
                        <a href="" class="btn btn-primary">Baca</a>
                        <?php
                      }
                      ?>

                    </td>
                  </tr>
              <?php endforeach;
              } else {
                echo '<tr><td colspan="10">Tidak ada data peminjaman.</td></tr>';
              } ?>
              <!-- Tambahkan baris data lainnya sesuai kebutuhan -->
            </tbody>
          </table>
        </div>
      </div>


    </div>
  </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  <!-- /.content-wrapper -->

</body>

</html>