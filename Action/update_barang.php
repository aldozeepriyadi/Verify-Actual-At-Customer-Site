<?php
include ("../config.php");
include "../lib/phpPasswordHashingLib-master/passwordLib.php"; // Pastikan library ini benar di-load

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['updateIdBarang']; // Mengambil ID dari POST
    $namaBarang = $_POST['updateNamaBarang'];
    $jumlahBarang = $_POST['updateJumlahBarang'];
    $jenisBarang = $_POST['updateJenisBarang'];
    $param_ins_usr = $_SESSION['id_usr'];

    $statusBarang = ($jumlahBarang > 0) ? 1 : 0;

    $sql = "UPDATE kyb_msbarang SET kyb_nama_barang=?, kyb_jumlah_barang=?, kyb_jenis_barang=?, kyb_status=?, kyb_modi_usr=?, kyb_modi_dt=NOW() WHERE kyb_id_barang=?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "siisii", $namaBarang, $jumlahBarang, $jenisBarang, $statusBarang, $param_ins_usr, $id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, "error" => mysqli_stmt_error($stmt)));
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(array("success" => false, "error" => mysqli_error($conn)));
    }

    mysqli_close($conn);
}
?>
