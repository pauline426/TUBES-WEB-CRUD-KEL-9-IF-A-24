<?php
include "koneksi.php";

if (isset($_POST['register'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>
          alert('Email sudah terdaftar');
          window.location='login.php';
        </script>";
        exit;
    }

    mysqli_query(
        $koneksi,
        "INSERT INTO users (nama_lengkap, email, password)
         VALUES ('$nama','$email','$password')"
    );

    echo "<script>
      alert('Registrasi berhasil, silakan login');
      window.location='login.php';
    </script>";
}
