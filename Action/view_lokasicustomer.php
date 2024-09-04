<?php
include ("../config.php");
include("../session.php");
// For Detail Historical
$sql = "SELECT * FROM kyb_mslokasicustomer  WHERE kyb_status = 1  ";
$result = mysqli_query($conn, $sql);



?>