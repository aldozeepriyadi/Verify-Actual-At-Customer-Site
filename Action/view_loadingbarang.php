<?php
include ("../config.php");
include("../session.php");
// For Detail Historical
$sql = "SELECT a.kyb_dock_kybi, c.kyb_dock_customer, a.kyb_qty_palet, b.kyb_id_palet, a.kyb_id_schedule
FROM kyb_trscheduledelivery a
LEFT JOIN kyb_trspreparationbarang b ON a.kyb_idpreparationbarang = b.kyb_idpreparationbarang
LEFT JOIN kyb_mslokasicustomer c ON a.kyb_id_lokasicustomer = c.kyb_id_lokasicustomer
LEFT JOIN kyb_mstruk d ON a.kyb_idtruk = d.kyb_idtruk
WHERE a.kyb_status = 2 AND a.kyb_id_usr = ".$_SESSION['id_usr'];
$result = mysqli_query($conn, $sql);



?>  