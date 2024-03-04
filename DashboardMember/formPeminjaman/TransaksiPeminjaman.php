<?php 
session_start();

if(!isset($_SESSION["signIn"]) ) {
  header("Location: ../../sign/member/sign_in.php");
  exit;
}
require "../../config/config.php";
$akunMember = $_SESSION["member"]["no_ktp"];
$dataPinjam = queryReadData("SELECT peminjaman.id_peminjaman, peminjaman.id_buku, buku.judul, member.no_ktp, member.nama, admin.nama_admin, peminjaman.tgl_peminjaman, peminjaman.tgl_pengembalian
FROM peminjaman
INNER JOIN buku ON peminjaman.id_buku = buku.id_buku
INNER JOIN member ON peminjaman.no_ktp_member = member.no_ktp
INNER JOIN admin ON peminjaman.id_admin = admin.id
WHERE member.no_ktp = '$akunMember'");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Bagian head HTML -->
  </head>
  <body>
    <!-- Bagian body HTML -->
    <div class="p-4 mt-5">
      <div class="mt-5 alert alert-primary" role="alert">Riwayat transaksi Peminjaman Buku Anda - <span class="fw-bold text-capitalize"><?php echo htmlentities($_SESSION["member"]["nama"]); ?></span></div>
      
      <div class="table-responsive mt-3">
        <table class="table table-striped table-hover">
          <thead class="text-center">
            <tr>
              <th class="bg-primary text-light">Id Peminjaman</th>
              <th class="bg-primary text-light">Id Buku</th>
              <th class="bg-primary text-light">Judul Buku</th>
              <th class="bg-primary text-light">No KTP</th>
              <th class="bg-primary text-light">Nama</th>
              <th class="bg-primary text-light">Nama Admin</th>
              <th class="bg-primary text-light">Tanggal Peminjaman</th>
              <th class="bg-primary text-light">Tanggal Pengembalian</th>
              <th class="bg-primary text-light">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($dataPinjam as $item) : ?>
            <tr>
              <td><?= $item["id_peminjaman"]; ?></td>
              <td><?= $item["id_buku"]; ?></td>
              <td><?= $item["judul"]; ?></td>
              <td><?= $item["no_ktp"]; ?></td>
              <td><?= $item["nama"]; ?></td>
              <td><?= $item["nama_admin"]; ?></td>
              <td><?= $item["tgl_peminjaman"]; ?></td>
              <td><?= $item["tgl_pengembalian"]; ?></td>
              <td>
                <a class="btn btn-success" href="pengembalianBuku.php?id=<?= $item["id_peminjaman"]; ?>">Kembalikan</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  
    <footer class="fixed-bottom shadow-lg bg-subtle p-3">
      <!-- Bagian footer HTML -->
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
