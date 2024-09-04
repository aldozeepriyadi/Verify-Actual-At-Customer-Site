<?php
include ("../config.php");
include ("../session.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_schedule = $_POST['id_scheduleRemark'];
    $problem = $_POST['problemRemark'];
    $foto = $_POST['fotoRemark'];
    $latitude = $_POST['latitudeRemark'];
    $longitude = $_POST['longitudeRemark'];
    $driver_id = $_SESSION['id_usr'];

    // Decode the base64 encoded image
    $image_parts = explode(";base64,", $foto);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file_name = uniqid() . '.' . $image_type;
    $file = '../uploads/' . $file_name;

    file_put_contents($file, $image_base64);

    $sql = "INSERT INTO kyb_trsproblem (kyb_id_schedule, kyb_problem, kyb_bukti_foto, kyb_lat, kyb_longi, kyb_ins_usr, kyb_ins_dt) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssi", $id_schedule, $problem, $file, $latitude, $longitude, $driver_id);

    if ($stmt->execute()) {
        $update_sql = "UPDATE kyb_trscheduledelivery SET kyb_status = 3 WHERE kyb_id_schedule = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $id_schedule);
        $update_stmt->execute();

        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'message' => $stmt->error));
    }

    $stmt->close();
    $conn->close();
}
?>