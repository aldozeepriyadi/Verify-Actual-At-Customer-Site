<?php
include ("../config.php");
include("../session.php");
// For Detail Historical
$sql = "SELECT * FROM kyb_msuser where kyb_id_role = 1 AND kyb_status = 1";
$result = mysqli_query($conn, $sql);



?>