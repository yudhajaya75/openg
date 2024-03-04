<?php
// FILE LOGIN SYSTEM 
$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "perpustakaan";
$connect = mysqli_connect($host, $username, $password, $database);

/* SIGN UP Member */
function signUp($data) {
  global $connect;
  
  $no_ktp = isset($data["no_ktp"]) ? htmlspecialchars($data["no_ktp"]) : '';
  $kodeMember = isset($data["kode_member"]) ? htmlspecialchars($data["kode_member"]) : '';
  $nama = isset($data["nama"]) ? htmlspecialchars(strtolower($data["nama"])) : '';
  $password = isset($data["password"]) ? mysqli_real_escape_string($connect, $data["password"]) : '';
  $confirmPw = isset($data["confirmPw"]) ? mysqli_real_escape_string($connect, $data["confirmPw"]) : '';
  $jk = isset($data["jenis_kelamin"]) ? htmlspecialchars($data["jenis_kelamin"]) : '';
  $noTlp = isset($data["no_tlp"]) ? htmlspecialchars($data["no_tlp"]) : '';
  $tglDaftar = isset($data["tgl_pendaftaran"]) ? $data["tgl_pendaftaran"] : '';
  
  // Pastikan no_ktp tidak kosong
  if (empty($no_ktp)) {
    echo "<script>
    alert('Nomor KTP tidak boleh kosong!');
    </script>";
    return 0;
  }
  
  // cek no_ktp sudah ada / belum 
  $noktpResult = mysqli_query($connect, "SELECT no_ktp FROM member WHERE no_ktp = '$no_ktp'");
  if(mysqli_num_rows($noktpResult) > 0) {
    echo "<script>
    alert('Nisn sudah terdaftar, silahkan gunakan no ktp lain!');
    </script>";
    return 0;
  }
  
  //cek kodeMember sudah ada / belum
  $kodeMemberResult = mysqli_query($connect, "SELECT  kode_member FROM member WHERE kode_member = '$kodeMember'");
  if(mysqli_num_rows($kodeMemberResult) > 0){
    echo "<script>
    alert('Kode member telah terdaftar, silahkan gunakan kode member lain!');
    </script>";
    return 0;
  }
  
  // Pengecekan kesamaan confirm password dan password
  if($password !== $confirmPw) {
    echo "<script>
    alert('password / confirm password tidak sesuai');
    </script>";
    return 0;
  }
  
  // Enkripsi password
  $password = password_hash($password, PASSWORD_DEFAULT);
  
  
  $querySignUp = "INSERT INTO member VALUES('$no_ktp', '$kodeMember', '$nama', '$password', '$jk', '$noTlp', '$tglDaftar')";
  mysqli_query($connect, $querySignUp);
  return mysqli_affected_rows($connect);
}

?>
