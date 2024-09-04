<?php
header('Content-Type: application/json');
include ("../config.php");
include ("../session.php");

$dock_customer = isset($_POST['dock_customer']) ? $_POST['dock_customer'] : '';
$dock_kybi = isset($_POST['dock_kybi']) ? $_POST['dock_kybi'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';
$actual_day = isset($_POST['actual_day']) ? $_POST['actual_day'] : '';
$actual_month = isset($_POST['actual_month']) ? $_POST['actual_month'] : '';
$actual_year = isset($_POST['actual_year']) ? $_POST['actual_year'] : '';

$sqlMonitoring = "SELECT 
    vd.kyb_id_verfikasi,
    lc.kyb_bpid, 
    lc.kyb_cycle,
    lc.kyb_dock_customer,
    lc.kyb_longi,
    lc.kyb_lat, 
    sd.kyb_qty_palet, 
    sd.kyb_plan_arrival,
    sd.kyb_id_schedule, 
    sd.kyb_waktu, 
    sd.kyb_dock_kybi,
    vd.kyb_actual_arrival,
    usr.kyb_nama_usr,
    sd.kyb_status AS statusSchecdule,
    TIMESTAMPDIFF(MINUTE, sd.kyb_plan_arrival, vd.kyb_actual_arrival) AS delay_minutes,
    IF(sd.kyb_plan_arrival >= vd.kyb_actual_arrival, 'On Time', 'Be late') AS status
FROM 
    kyb_trscheduledelivery sd
LEFT JOIN 
    kyb_trsverifikasikedatangan vd ON sd.kyb_id_schedule = vd.kyb_id_schedule
LEFT JOIN 
    kyb_mslokasicustomer lc ON sd.kyb_id_lokasicustomer = lc.kyb_id_lokasicustomer
LEFT JOIN
    kyb_msuser usr ON sd.kyb_id_usr = usr.kyb_id_usr
WHERE  vd.kyb_status = 1 AND usr.kyb_id_role = 1";

if ($dock_customer !== '') {
    $sqlMonitoring .= " AND lc.kyb_dock_customer = '$dock_customer'";
}
if ($dock_kybi !== '') {
    $sqlMonitoring .= " AND sd.kyb_dock_kybi = '$dock_kybi'";
}
if ($status !== '') {
    $sqlMonitoring .= " AND IF(sd.kyb_plan_arrival >= vd.kyb_actual_arrival, 'On Time', 'Be late') = '$status'";
}
if ($actual_day !== '') {
    $sqlMonitoring .= " AND DAY(vd.kyb_actual_arrival) = '$actual_day'";
}
if ($actual_month !== '') {
    $sqlMonitoring .= " AND MONTH(vd.kyb_actual_arrival) = '$actual_month'";
}
if ($actual_year !== '') {
    $sqlMonitoring .= " AND YEAR(vd.kyb_actual_arrival) = '$actual_year'";
}

$result = mysqli_query($conn, $sqlMonitoring);

if (!$result) {
    echo json_encode(array('error' => mysqli_error($conn)));
    exit;
}

$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $row_data = array();
    $row_data[] = $i;
    $row_data[] = $row['kyb_cycle'];
    $row_data[] = $row['kyb_dock_customer'];
    $row_data[] = $row['kyb_dock_kybi'];
    $row_data[] = $row['kyb_nama_usr'];
    $row_data[] = $row['kyb_actual_arrival'];
    $row_data[] = $row['kyb_qty_palet'];
    $row_data[] = $row['status'];

    if ($row['delay_minutes'] > 5) {
        if ($row['statusSchecdule'] == 3) {
            $row_data[] = "<button type='button' class='btn btn-warning btn-sm' onclick='remarkProblem(" . $row['kyb_id_schedule'] . ")'>Remark Problem</button>";
        }else{
            $row_data[] = "-";
        }


    } else {
        $row_data[] = "-";
    }
    $data[] = $row_data;
    $i++;
}

echo json_encode(array('data' => $data));
?>