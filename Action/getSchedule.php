<?php
include "../config.php";
// Get the id_driver from the request
$id_schedule = $_GET['id_schedule'];

// Prepare and execute the SQL query
$sql = "SELECT waktu FROM schedule_delivery WHERE id_schedule = '$id_schedule'";
$result = mysqli_query($conn, $sql);

// Fetch the result
$rowDriver = mysqli_fetch_assoc($result);

// Return the driver's name as JSON
echo json_encode($rowDriver);

// Close the connection
mysqli_close($conn);
?>