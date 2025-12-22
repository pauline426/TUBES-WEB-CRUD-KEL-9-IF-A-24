<?php
session_start();
include "koneksi.php";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $data = mysqli_fetch_assoc($q);

    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['nama'] = $data['nama'];

        header("Location: Beranda.php");
        exit;
    } else {
        echo "<script>
          alert('Email atau Password salah');
          window.location='login.html';
        </script>";
    }
}
