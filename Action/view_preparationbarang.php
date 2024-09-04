<?php
include ("../config.php");
include("../session.php");
// For Detail Historical
$sql = "SELECT DISTINCT
a.*,
b.kyb_dock_customer,
b.kyb_bpid,
b.kyb_alamat,
c.kyb_id_user,
d.kyb_qty_palet,
d.kyb_dock_kybi,
e.kyb_id_barang,
e.kyb_id_palet,
e.kuantitas,
d.kyb_plan_arrival
FROM 
kyb_trspreparationbarang a
LEFT JOIN 
kyb_mslokasicustomer b ON a.kyb_id_lokasicustomer = b.kyb_id_lokasicustomer
LEFT JOIN 
kyb_palet c ON a.kyb_id_palet = c.kyb_id_palet
LEFT JOIN 
kyb_detail_palet e ON e.kyb_id_palet = c.kyb_id_palet
LEFT JOIN 
kyb_trscheduledelivery d ON a.kyb_idpreparationbarang = d.kyb_idpreparationbarang
WHERE 
e.kyb_id_barang IN (SELECT kyb_id_barang FROM kyb_msbarang)
AND d.kyb_status = 1
GROUP BY
a.kyb_idpreparationbarang";
$result = mysqli_query($conn, $sql);



?>