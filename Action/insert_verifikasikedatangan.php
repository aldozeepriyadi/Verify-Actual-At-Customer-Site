<?php
include ("../config.php");
include ("../session.php");

$response = array('success' => false, 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_verifikasi = $_POST['id_verifikasi'];
    $id_schedule = $_POST['id_scheduleKedatangan'];
    $latitude = $_POST['latitudeKedatangan'];
    $longitude = $_POST['longitudeKedatangan'];
    $foto = $_POST['fotoBinary'];
    $id_usr = $_SESSION['id_usr'];

    // Decode the base64 encoded image
    $image_parts = explode(";base64,", $foto);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file_name = uniqid() . '.' . $image_type;
    $file = '../uploads/' . $file_name;

    if (file_put_contents($file, $image_base64)) {
        // Update into database
        $sql = "UPDATE kyb_trsverifikasikedatangan SET kyb_lat=?, kyb_longi=?, kyb_bukti_foto=?, kyb_id_user=?, kyb_status=1, kyb_actual_arrival=NOW() WHERE kyb_id_verfikasi=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $latitude, $longitude, $file, $id_usr, $id_verifikasi);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Verifikasi berhasil.';
        } else {
            $response['message'] = 'Error: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['message'] = 'Error: Unable to upload file.';
    }
} else {
    $response['message'] = 'Invalid request.';
}

echo json_encode($response);
?>