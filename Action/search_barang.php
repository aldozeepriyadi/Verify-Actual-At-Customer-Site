<?php
include '../config.php';

$query = $_GET['query'];

$sql = "SELECT kyb_id_barang, kyb_nama_barang, kyb_jumlah_barang FROM kyb_msbarang WHERE kyb_nama_barang LIKE '%$query%' OR kyb_id_barang LIKE '%$query%'";
$result = mysqli_query($conn, $sql);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>
