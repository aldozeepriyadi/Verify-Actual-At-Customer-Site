<?php
include "../config.php";
session_start();

$response = array('success' => false, 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];
    $truk = $_POST['absensiTruck'];
    $id_schedule = $_POST['kyb_id_schedule'];
    $status = 2;
    $statusVerifikasi = 0;
    $id_driver = $_SESSION['id_usr'];
    $fotoBinary = $_POST['fotoBinary'];

    if (preg_match('/^data:image\/(\w+);base64,/', $fotoBinary, $type)) {
        $fotoBinary = substr($fotoBinary, strpos($fotoBinary, ',') + 1);
        $type = strtolower($type[1]);

        $fotoBinary = base64_decode($fotoBinary);
        if ($fotoBinary === false) {
            $response['message'] = 'Base64 decode failed';
            echo json_encode($response);
            exit;
        }

        $filePath = '../uploads/' . uniqid() . '.' . $type;
        if (!file_put_contents($filePath, $fotoBinary)) {
            $response['message'] = 'File put contents failed';
            echo json_encode($response);
            exit;
        }
    } else {
        $response['message'] = 'Did not match data URI with image data';
        echo json_encode($response);
        exit;
    }

    mysqli_autocommit($conn, FALSE);

    try {
        $sql = "UPDATE kyb_trscheduledelivery SET kyb_idtruk = ?, kyb_id_usr = ?, kyb_status = ?, kyb_bukti_foto = ? WHERE kyb_id_schedule = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("iiisi", $truk, $id_driver, $status, $filePath, $id_schedule);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            }
            $stmt->close();
        } else {
            throw new Exception("Failed to prepare statement for kyb_trscheduledelivery: " . $conn->error);
        }

        $sqlVerifikasi = "INSERT INTO kyb_trsverifikasikedatangan (kyb_lat, kyb_longi, kyb_status, kyb_id_schedule) VALUES (?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sqlVerifikasi)) {
            $stmt->bind_param("ssii", $latitude, $longitude, $statusVerifikasi, $id_schedule);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            }
            $stmt->close();
        } else {
            throw new Exception("Failed to prepare statement for kyb_trsverifikasikedatangan: " . $conn->error);
        }

        mysqli_commit($conn);
        $response['success'] = true;
        $response['message'] = "Absensi berhasil disimpan.";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $response['message'] = "Error: " . $e->getMessage();
    }

    mysqli_autocommit($conn, TRUE);
    $conn->close();
}

echo json_encode($response);
?>