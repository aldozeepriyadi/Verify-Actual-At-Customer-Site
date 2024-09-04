<?php
include ("../config.php");
include ("../session.php");

$response = array('success' => false, 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["simpan"])) {
    $id_schedule = $_POST['id_schedule'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $problem = $_POST['problem'];
    $foto = $_POST['foto'];
    $id_usr = $_SESSION['id_usr'];

    $image_parts = explode(";base64,", $foto);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file_name = uniqid() . '.' . $image_type;
    $file = '../uploads/' . $file_name;

    if (file_put_contents($file, $image_base64)) {
        $sql = "INSERT INTO kyb_trsproblem (kyb_id_schedule, kyb_lat, kyb_longi, kyb_problem, kyb_bukti_foto, kyb_ins_usr, kyb_ins_dt) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssi", $id_schedule, $latitude, $longitude, $problem, $file, $id_usr);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Problem berhasil disimpan.';
        } else {
            $response['message'] = 'Error: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['message'] = 'Error: Unable to upload file.';
    }
}
echo json_encode($response);
?>