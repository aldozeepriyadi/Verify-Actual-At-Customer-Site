<?php
include ("../config.php");
include("../session.php");
// For Detail Historical
$sql = "SELECT * FROM kyb_mstruk a
LEFT JOIN kyb_msjenistruk c ON a.kyb_jenistruk = c.kyb_idjenistruk
WHERE a.kyb_status = 1 ";
$result = mysqli_query($conn, $sql);



?>