<?php
include ("../config.php");

$kyb_id_palet = $_GET['kyb_id_palet'];

$sql = "SELECT SUM(kuantitas) AS jumlah_barang FROM kyb_detail_palet WHERE kyb_id_palet = $kyb_id_palet";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $jumlah_barang = $row['jumlah_barang'];
    echo json_encode(array('success' => true, 'jumlah_barang' => $jumlah_barang));
} else {
    echo json_encode(array('success' => false, 'message' => 'Error fetching palet capacity'));
}

$conn->close();
?>
