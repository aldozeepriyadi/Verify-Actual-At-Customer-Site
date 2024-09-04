<?php
include "../config.php"; // Memastikan file konfigurasi database di-include
session_start(); // Memastikan session dimulai

$response = array('success' => false, 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan nilai dari form
    $dockCustomer = $_POST['dock_customer'];
    $planArrival = $_POST['updatePlanArrival'];
    $dock_kybi = $_POST['dock_kybi'];
    $updateQuantity = $_POST['updateQuantity'];
    $status = 1;
    $id_user =  $_POST['driver'];
    $ins_usr = $_SESSION['id_usr'];
    $keranjang = json_decode($_POST['keranjang'], true);

    if (empty($dock_kybi)) {
        $response['message'] = "Dock Kayaba Indonesia tidak boleh kosong";
        echo json_encode($response);
        exit();
    }

    if (empty($updateQuantity) || $updateQuantity <= 0) {
        $response['message'] = "Quantity Pallet tidak boleh kosong atau kurang dari 1";
        echo json_encode($response);
        exit();
    }

    // Inisialisasi variabel untuk menyimpan ID keranjang dan preparation_barang yang baru saja dimasukkan
    $keranjangId = null;
    $preparationBarang = null;

    // Mulai transaksi manual
    mysqli_autocommit($conn, FALSE);

    try {
        $sqlKeranjang = "INSERT INTO kyb_palet (kyb_id_user) VALUES (?)";
        if ($stmt = $conn->prepare($sqlKeranjang)) {
            $stmt->bind_param("i", $id_user);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            }
            $keranjangId = $stmt->insert_id;
            $stmt->close();
        } else {
            throw new Exception("Failed to prepare statement for kyb_keranjang: " . $conn->error);
        }

        // Query untuk memasukkan data ke dalam tabel kyb_detail_keranjang
        $sqlDetail = "INSERT INTO  kyb_detail_palet (kyb_id_palet, kyb_id_barang, kuantitas) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($sqlDetail)) {
            foreach ($keranjang as $item) {
                $stmt->bind_param("iii", $keranjangId, $item['kyb_id_barang'], $item['jumlah']);
                if (!$stmt->execute()) {
                    throw new Exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
                }
            }
            $stmt->close();
        } else {
            throw new Exception("Failed to prepare statement for kyb_detail_keranjang: " . $conn->error);
        }

        // Query untuk memasukkan data ke dalam tabel kyb_trspreparationbarang
        $sqlPreparation = "INSERT INTO kyb_trspreparationbarang (kyb_id_palet,kyb_id_lokasicustomer,kyb_ins_usr, kyb_ins_dt) VALUES (?, ?, ?,NOW())";
        if ($stmt = $conn->prepare($sqlPreparation)) {
            $stmt->bind_param("iii", $keranjangId, $dockCustomer, $ins_usr);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            }
            $preparationBarang = $stmt->insert_id;
            $stmt->close();
        } else {
            throw new Exception("Failed to prepare statement for kyb_trspreparationbarang: " . $conn->error);
        }

        // Query untuk memasukkan data ke dalam tabel kyb_trscheduledelivery
        $sqlScheduledDelivery = "INSERT INTO kyb_trscheduledelivery (kyb_id_lokasicustomer, kyb_plan_arrival, kyb_dock_kybi, kyb_status, kyb_qty_palet, kyb_idpreparationbarang,kyb_ins_usr, kyb_ins_dt) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?,NOW())";
        if ($stmt = $conn->prepare($sqlScheduledDelivery)) {
            $stmt->bind_param("issiiii", $dockCustomer, $planArrival, $dock_kybi, $status, $updateQuantity, $preparationBarang,$ins_usr);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            }
            $stmt->close();
        } else {
            throw new Exception("Failed to prepare statement for kyb_trscheduledelivery: " . $conn->error);
        }

        // Commit transaksi manual
        mysqli_commit($conn);
        $response['success'] = true;
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        mysqli_rollback($conn);
        $response['message'] = "Error: " . $e->getMessage();
    }

    mysqli_autocommit($conn, TRUE);
    $conn->close();
}

header('Content-Type: application/json');
echo json_encode($response);
?>
