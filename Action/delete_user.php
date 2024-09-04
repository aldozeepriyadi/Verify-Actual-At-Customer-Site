<?php
include("../config.php");  // Ensure this file is connected to the database

header('Content-Type: application/json');

$response = array('success' => false, 'message' => 'Unknown error');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteId'])) {
    $id = $_POST['deleteId'];

    // Siapkan query untuk mengubah status data
    $sql = "UPDATE kyb_msuser SET kyb_status = 0 WHERE kyb_id_usr = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind status baru dan ID ke statement
        mysqli_stmt_bind_param($stmt, "i", $id);

        // Eksekusi statement
        if (mysqli_stmt_execute($stmt)) {
            $response['success'] = true;
            $response['message'] = 'Status data berhasil diubah.';
        } else {
            $response['message'] = "Error: " . mysqli_stmt_error($stmt);
        }

        // Tutup statement
        mysqli_stmt_close($stmt);
    } else {
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    // Tutup koneksi database
    mysqli_close($conn);
} else {
    $response['message'] = 'Invalid request';
}

echo json_encode($response);
?>
