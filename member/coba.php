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
$nis = $_SESSION['nisn'];

// Now you can use $nis wherever you need it

require "../config/config.php";

// Assuming $id is the specific value you want to match
$id = 123; // replace with the actual value

$dataPinjam = queryReadData("SELECT peminjaman.id, peminjaman.id_buku, buku.judul, peminjaman.nisn, member.nama, user.username, peminjaman.tgl_pinjam, peminjaman.tgl_kembali
FROM peminjaman
INNER JOIN buku ON peminjaman.id_buku = buku.id_buku
INNER JOIN member ON peminjaman.nisn = member.nisn
INNER JOIN user ON peminjaman.id_user = user.id
WHERE peminjaman.id = $id");

// Replace $id with the actual condition you want to use in the WHERE clause
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
        <a class="dropdown-item text-center text-secondary" href="#"> <span class="text-capitalize"><?php echo $_SESSION['member']['nama']; ?></span></a>
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
    <div class="alert alert-dark" role="alert">Daftar Pinjaman Buku Anda</div>
  <!-- Default box -->
<div class="card mb-auto">
        <div class="card-header">
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="table">
            <table class="table-hover" id="table2" width="100%">
              <thead class="thead-dark">
              <tr align="center">
                <th>Kode Peminjaman</th>
                <th>Id Buku</th>
                <th>Judul Buku</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Nama Petugas</th>
                <th>Tgl. Pinjam</th>
                <th>Tgl. Selesai</th>
                <th>Status</th>
                <th width="160">Action</th>
                </tr></thead>
              <tbody>
                <tr align="center">
                <?php foreach ($dataPinjam as $item) : ?>
                <td><?= $item["id"]; ?></td>
                <td><?= $item["id_buku"]; ?></td>
                <td><?= $item["judul"]; ?></td>
                <td><?= $item["nisn"]; ?></td>
                <td><?= $item["nama"]; ?></td>
                <td><?= $item["username"]; ?></td>
                <td><?= $item["tgl_pinjam"]; ?></td>
                <td><?= $item["tgl_kembali"]; ?></td>
                <td><?= $item["Status"]; ?></td>
                <td>
                <a class="btn btn-primary" href="../bacabuku.php?id=<?= $item["id_buku"]; ?>" style="height:40px;width:100px"> Baca Buku</a>
                </td>
                </tr>
                
                <?php
                endforeach;
                ?>
              </tbody>
              </table> 
          </div>
        </div>
      </div> 
      <!-- /.card -->

  </div>
  </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  <!-- /.content-wrapper -->
  
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<script src="../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../assets/plugins/jszip/jszip.min.js"></script>
<script src="../assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.min.js"></script>
<!-- coba -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
 

<script>
  $(function () {
    $('#table_user').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
      
    });
    $('#table').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
    $('#table2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": true,
      "responsive": true,

    });
    $('#table-report').DataTable({
      dom: 'Btlip',
      buttons: [
           'excel', 'pdf', 'print'
      ],
    });
  });

  $(document).ready(function() {
    $('#mauexport').DataTable( {
        dom: 'Bfrtip',
        buttons: [
          'copy','excel', 'print'
        ]
    } );
} );

</script>

</body>
</html>