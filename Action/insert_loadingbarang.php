<?php
include ("../config.php");

// Mengambil data dari permintaan POST
$input = file_get_contents("php://input");
$data = json_decode($input, true);

$id_schedule = $data['id'];
$status_value = $data['value'];

// Memperbarui status di database berdasarkan id_schedule
$sql = "UPDATE kyb_trscheduledelivery SET kyb_status = ? WHERE kyb_id_schedule = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $status_value, $id_schedule);

$response = array();
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
