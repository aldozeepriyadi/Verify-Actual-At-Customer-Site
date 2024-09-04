<?php
include("../config.php");
include "../lib/phpPasswordHashingLib-master/passwordLib.php"; // Pastikan library ini benar di-load
  // Pastikan file ini menghubungkan ke database Anda dengan benar

// Cek apakah form telah di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id = $_GET['id'];
    $nama = $_POST['updateNamaDriver'];
    $noTelepon = $_POST['updateNoTeleponDriver'];
    $username = $_POST['updateusernameDriver'];
    $password = $_POST['updatepasswordDriver'];  // Asumsi Anda ingin update password juga
    

    // Validasi input
    if (empty($nama) || empty($noTelepon) || empty($username) || empty($password)) {
        // Handle error jika data tidak lengkap
        echo "<script>alert('Harap isi semua data.'); window.location.href = 'view_user.php';</script>";
        exit();
    }

    // Siapkan query update
    $sql = "UPDATE kyb_msuser SET kyb_nama_usr=?, kyb_no_telp=?, kyb_username=?, kyb_password=?, kyb_ins_usr=?,kyb_ins_dt=NOW() WHERE kyb_id_usr=?";

    // Persiapkan prepared statement
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variabel ke prepared statement sebagai parameter
        mysqli_stmt_bind_param($stmt, "ssssii", $param_nama, $param_noTelepon, $param_username, $param_password,$param_ins_usr,$param_id);

        // Set parameter
        $param_nama = $nama;
        $param_noTelepon = $noTelepon;
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);  // Hash password
        $param_id = $id;
        $param_ins_usr =$_SESSION['role'];

        // Eksekusi statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect jika update berhasil
            echo "<script>alert('Data berhasil diperbarui.'); </script>";
            header("Location:../Dashboard/view_user.php"); // Pastikan ini tidak mengeksekusi jika terjadi error
            exit(); // Menghentikan script setelah redirect
        } else {
            // Handle error jika update gagal
            echo "Error: " . mysqli_stmt_error($stmt);
        }

        // Tutup statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Tutup koneksi database
    mysqli_close($conn);
} else {
    // Redirect jika akses langsung ke file ini tanpa submit form
    header("Location: view_user.php");
    exit();
}
?>
