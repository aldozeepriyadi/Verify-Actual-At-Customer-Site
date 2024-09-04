<?php
include '../config.php';

$keranjang = json_decode($_POST['keranjang'], true);
$userId = $_SESSION['user_id']; // Atau sesuai dengan ID user yang sedang login

// Simpan data ke tabel kyb_keranjang
$sqlKeranjang = "INSERT INTO kyb_palet (kyb_id_user) VALUES ('$userId')";
if (mysqli_query($conn, $sqlKeranjang)) {
    $keranjangId = mysqli_insert_id($conn);

    foreach ($keranjang as $item) {
        $barangId = $item['kyb_id_barang'];
        $jumlah = $item['jumlah'];
        
        $sqlDetail = "INSERT INTO kyb_detail_keranjang (kyb_id_keranjang, kyb_id_barang, kuantitas) VALUES ('$keranjangId', '$barangId', '$jumlah')";
        mysqli_query($conn, $sqlDetail);
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
}
?>
