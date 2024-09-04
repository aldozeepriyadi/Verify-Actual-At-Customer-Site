<?php
include ("../config.php");

$id = intval($_GET['id']);
$response = array();

$sqlDetail = "SELECT a.kyb_id_palet, a.kyb_id_barang, a.kuantitas, c.kyb_nama_barang
FROM  kyb_detail_palet a
LEFT JOIN  kyb_palet b ON a.kyb_id_palet = b.kyb_id_palet
LEFT JOIN kyb_msbarang c ON a.kyb_id_barang = c.kyb_id_barang
WHERE a.kyb_id_palet = ?";
$stmtDetail = $conn->prepare($sqlDetail);
$stmtDetail->bind_param("i", $id);
$stmtDetail->execute();

// Bind result variables
$stmtDetail->bind_result($kyb_id_keranjang, $kyb_id_barang, $kuantitas, $kyb_nama_barang);

// Fetch values
while ($stmtDetail->fetch()) {
    $response[] = array(
        'kyb_id_palet' => $kyb_id_keranjang,
        'kyb_id_barang' => $kyb_id_barang,
        'kuantitas' => $kuantitas,
        'kyb_nama_barang' => $kyb_nama_barang
    );
}

$stmtDetail->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
