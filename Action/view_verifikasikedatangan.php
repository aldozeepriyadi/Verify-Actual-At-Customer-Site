<?php
include("../config.php");
include("../session.php");

$sqlCurrentEvent = "SELECT vd.kyb_id_verfikasi, 
lc.kyb_bpid, 
lc.kyb_cycle, 
lc.kyb_dock_customer,
lc.kyb_longi,
lc.kyb_lat,
sd.kyb_qty_palet, 
sd.kyb_plan_arrival, 
sd.kyb_id_schedule, 
sd.kyb_waktu, 
sd.kyb_dock_kybi
FROM kyb_trscheduledelivery sd
LEFT JOIN kyb_trsverifikasikedatangan vd ON sd.kyb_id_schedule = vd.kyb_id_schedule
LEFT JOIN kyb_mslokasicustomer lc ON sd.kyb_id_lokasicustomer = lc.kyb_id_lokasicustomer
WHERE sd.kyb_plan_arrival <= DATE_ADD( NOW( ) , INTERVAL 3 DAY )
AND sd.kyb_status = 3 AND vd.kyb_status = 0
AND sd.kyb_id_usr =".$_SESSION['id_usr']." AND lc.kyb_id_lokasicustomer =".$_SESSION['customer'] ; // Contoh: kyb_cycle = 1, sesuaikan dengan kebutuhan Anda

$resultCurrentEvent = mysqli_query($conn, $sqlCurrentEvent);

$sqlUpcomingEvents = "SELECT vd.kyb_id_verfikasi,
 lc.kyb_bpid, 
 lc.kyb_cycle,
 lc.kyb_dock_customer,
 lc.kyb_longi,
 lc.kyb_lat, 
 sd.kyb_qty_palet, 
 sd.kyb_plan_arrival,
 sd.kyb_id_schedule, 
 sd.kyb_waktu, 
 sd.kyb_dock_kybi
FROM kyb_trscheduledelivery sd
LEFT JOIN kyb_trsverifikasikedatangan vd ON sd.kyb_id_schedule = vd.kyb_id_schedule
LEFT JOIN kyb_mslokasicustomer lc ON sd.kyb_id_lokasicustomer = lc.kyb_id_lokasicustomer
WHERE sd.kyb_plan_arrival >= DATE_ADD( NOW( ) , INTERVAL 3 DAY )
AND sd.kyb_status =3 AND vd.kyb_status = 0
AND sd.kyb_id_usr =".$_SESSION['id_usr']." AND lc.kyb_id_lokasicustomer =".$_SESSION['customer'] ; // Contoh: kyb_cycle = 1, sesuaikan dengan kebutuhan Anda

$resultUpcomingEvents = mysqli_query($conn, $sqlUpcomingEvents);
?>
