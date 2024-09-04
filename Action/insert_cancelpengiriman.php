<?php
include "../config.php"; // Memastikan file konfigurasi database di-include
session_start(); // Memastikan session dimulai

$response = array('success' => false, 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan nilai dari form
    $id_schedule = $_POST['id_schedule'];

    // Mulai transaksi manual
    mysqli_autocommit($conn, FALSE);

    try {
        // Query untuk mengupdate data di tabel kyb_trscheduledelivery
        $sql = "UPDATE kyb_trscheduledelivery SET kyb_idtruk = NULL, kyb_id_usr = NULL, kyb_status = 1, kyb_bukti_foto = NULL WHERE kyb_id_schedule = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $id_schedule);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            }
            $stmt->close();
        } else {
            throw new Exception("Failed to prepare statement for kyb_trscheduledelivery: " . $conn->error);
        }

        // Query untuk menghapus data dari tabel kyb_trsverifikasikedatangan
        $sqlDeleteVerifikasi = "DELETE FROM kyb_trsverifikasikedatangan WHERE kyb_id_schedule = ?";
        if ($stmt = $conn->prepare($sqlDeleteVerifikasi)) {
            $stmt->bind_param("i", $id_schedule);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            }
            $stmt->close();
        } else {
            throw new Exception("Failed to prepare statement for kyb_trsverifikasikedatangan: " . $conn->error);
        }

        // Commit transaksi manual
        mysqli_commit($conn);
        $response['success'] = true;
        $response['message'] = 'Pengiriman berhasil dibatalkan.';
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
