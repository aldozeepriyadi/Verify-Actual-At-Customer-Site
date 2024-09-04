<?php
include("../config.php"); // Pastikan menginclude file koneksi database

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaBarang = $_POST['namaBarang'];
    $jumlahBarang = $_POST['jumlahBarang'];
    $jenisBarang = $_POST['jenisBarang'];
    $ins_usr = $_SESSION['id_usr'];

    $statusBarang = ($jumlahBarang > 0) ? 1 : 0;

    $sql = "INSERT INTO kyb_msbarang (kyb_nama_barang, kyb_jumlah_barang, kyb_jenis_barang, kyb_ins_usr, kyb_ins_dt, kyb_status) VALUES (?, ?, ?, ?, NOW(), ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("siiii", $namaBarang, $jumlahBarang, $jenisBarang, $ins_usr, $statusBarang);

        if ($stmt->execute()) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, "error" => $stmt->error));
        }

        $stmt->close();
    } else {
        echo json_encode(array("success" => false, "error" => $conn->error));
    }

    $conn->close();
}
?>
