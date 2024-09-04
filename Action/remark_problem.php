<?php
include ("../config.php");
include ("../session.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id_schedule = $data['id_schedule'];

    $sqlUpdate = "UPDATE kyb_trscheduledelivery SET kyb_status = 4 WHERE kyb_id_schedule = ?";
    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bind_param("i", $id_schedule);

    if ($stmt->execute()) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'message' => $stmt->error));
    }

    $stmt->close();
    $conn->close();
}
?>