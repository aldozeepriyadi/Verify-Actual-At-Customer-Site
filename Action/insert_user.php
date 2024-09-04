<?php
include ("../config.php");
include ("../session.php");
include "../lib/phpPasswordHashingLib-master/passwordLib.php"; // Pastikan library ini benar di-load

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['namaDriver'];
    $noTelepon = $_POST['noTeleponDriver'];
    $username = $_POST['usernameDriver'];
    $password = $_POST['passwordDriver'];
    $id_role = 1;

    // Cek apakah username sudah ada
    $query = "SELECT kyb_username FROM kyb_msuser WHERE kyb_username = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo "<script>alert('Username Sudah Ada');</script>";
            echo "<script>window.location.href = '../Dashboard/view_user.php';</script>"; // Redirect setelah alert
            exit();
        }
        mysqli_stmt_close($stmt);
    }

    // Jika username belum ada, lakukan proses insert
    $sql = "INSERT INTO kyb_msuser (kyb_nama_usr, kyb_no_telp, kyb_username, kyb_password, kyb_id_role, kyb_ins_usr, kyb_ins_dt,kyb_status) VALUES (?, ?, ?, ?, ?, ?, NOW(),1)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Pastikan jumlah karakter sesuai dengan jumlah parameter
        mysqli_stmt_bind_param($stmt, "sssssi", $param_nama, $param_noTelepon, $param_username, $param_password, $param_id_role, $param_ins_usr);

        $param_nama = $nama;
        $param_noTelepon = $noTelepon;
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $param_id_role = $id_role; // Pastikan ini sudah benar di-set
        $param_ins_usr = $_SESSION['id_usr']; // Dapatkan dari session

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Data Berhasil Ditambahkan');</script>";
            echo "<script>window.location.href = '../Dashboard/view_user.php';</script>"; // Redirect setelah alert
            exit();
        } else {
            echo "Error: " . mysqli_error($conn); // Tampilkan error dari koneksi, bukan dari statement
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
}
?>
