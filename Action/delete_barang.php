<?php
include("../config.php");  // Make sure this file is connected to the database

header('Content-Type: application/json');

$response = array('success' => false, 'message' => 'Unknown error');

// Get the raw POST data
$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($input['deleteId'])) {
    $id = $input['deleteId'];

    // Prepare query to update status data
    $sql = "UPDATE kyb_msbarang SET kyb_status = 0 WHERE kyb_id_barang = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind ID to statement
        mysqli_stmt_bind_param($stmt, "i", $id);

        // Execute statement
        if (mysqli_stmt_execute($stmt)) {
            $response['success'] = true;
            $response['message'] = 'Status data berhasil diubah.';
        } else {
            $response['message'] = "Error: " . mysqli_stmt_error($stmt);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
} else {
    $response['message'] = 'Invalid request';
}

echo json_encode($response);
?>
