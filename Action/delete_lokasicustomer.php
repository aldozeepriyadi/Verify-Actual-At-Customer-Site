<?php
include("../config.php");  // Pastikan file ini terkoneksi dengan database

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['statusId']) && isset($_POST['newStatus'])) {
    $id = $_POST['statusId'];
    $newStatus = $_POST['newStatus'];

    // Siapkan query untuk memperbarui status
    $sql = "UPDATE kyb_mslokasicustomer SET kyb_status = ? WHERE kyb_id_lokasicustomer = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind parameter ke statement
        mysqli_stmt_bind_param($stmt, "ii", $newStatus, $id);

        // Eksekusi statement
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'error' => mysqli_stmt_error($stmt)));
        }

        // Tutup statement
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(array('success' => false, 'error' => mysqli_error($conn)));
    }

    // Tutup koneksi database
    mysqli_close($conn);
} else {
    echo json_encode(array('success' => false, 'error' => 'Invalid request'));
}
?>
