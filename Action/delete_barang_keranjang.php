<?php
include '../config.php';

$id = $_POST['id'];  // Mengambil ID barang dari request

$sql = "DELETE FROM kyb_detail_palet WHERE kyb_id_barang = '$id'";
if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
}
?>
