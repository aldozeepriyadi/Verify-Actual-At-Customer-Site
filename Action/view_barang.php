<?php
include ("../config.php");
include("../session.php");
// For Detail Historical
$sql = "SELECT * FROM kyb_msbarang JOIN kyb_msjenisbarang ON kyb_msbarang.kyb_jenis_barang = kyb_msjenisbarang.kyb_id
WHERE kyb_msbarang.kyb_status = 1";
$result = mysqli_query($conn, $sql);



?>