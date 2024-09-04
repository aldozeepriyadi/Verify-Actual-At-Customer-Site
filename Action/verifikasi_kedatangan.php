<?php
include ("../config.php");
 // Make sure to start the session at the beginning


$currentDate = date("Y-m-d"); // Get the current date in the format YYYY-MM-DD


// For Current Event
$sqlCurrentEvent = "SELECT vd.id_verifikasi, sd.bpid, sd.cycle, sd.dock_customer, sd.qty_palet, 
TIME( sd.plan_arrival ) AS plan_arrival_time, sd.id_schedule, sd.waktu
FROM schedule_delivery sd
JOIN (
SELECT id_schedule, MAX( id_verifikasi ) AS max_id_verifikasi
FROM verifikasi_delivery
WHERE STATUS =0
GROUP BY id_schedule
)max_vd ON sd.id_schedule = max_vd.id_schedule
JOIN verifikasi_delivery vd ON max_vd.max_id_verifikasi = vd.id_verifikasi
WHERE sd.plan_arrival <= DATE_ADD( NOW( ) , INTERVAL 3
DAY )
AND sd.cycle ='" . $_SESSION['cycle'] . "'";
$resultCurrentEvent = mysqli_query($conn, $sqlCurrentEvent);
$counterCurrentEvent = 1;



// For Upcoming Events
$sqlUpcomingEvents = "SELECT vd.id_verifikasi, sd.bpid, sd.cycle, sd.dock_customer, sd.qty_palet, TIME( sd.plan_arrival ) AS plan_arrival_time, sd.id_schedule, sd.waktu
FROM schedule_delivery sd
JOIN (
SELECT id_schedule, MAX( id_verifikasi ) AS max_id_verifikasi
FROM verifikasi_delivery
WHERE STATUS =0
GROUP BY id_schedule
)max_vd ON sd.id_schedule = max_vd.id_schedule
JOIN verifikasi_delivery vd ON max_vd.max_id_verifikasi = vd.id_verifikasi
WHERE sd.plan_arrival > DATE_ADD( NOW( ) , INTERVAL 3
DAY )
AND sd.cycle ='" . $_SESSION['cycle'] . "'";
$resultUpcomingEvents = mysqli_query($conn, $sqlUpcomingEvents);
$counterUpcomingEvents = 1;


// For Historical
$sqlProblem = "SELECT vd.id_schedule, vd.lat, vd.longi, 
vd.actual_arrival, vd.bukti_foto, sd.plan_arrival, vd.status, vd.id_driver,sd.cycle,sd.dock_customer,sd.qty_palet,sd.dock_kybi
FROM verifikasi_delivery vd
JOIN schedule_delivery sd ON vd.id_schedule = sd.id_schedule
WHERE vd.id_driver ='" . $_SESSION['id_driver'] . "'
AND vd.STATUS =1
AND sd.cycle ='" . $_SESSION['cycle'] . "'";
$resultProblem = mysqli_query($conn, $sqlProblem);
$counterProblem = 1;



// For Detail Historical
$sqlDetail = "SELECT pd.bukti_foto,pd.problem,pd.lat,pd.longi FROM verifikasi_delivery vd JOIN schedule_delivery sd 
ON vd.id_schedule = sd.id_schedule JOIN problem_delivery pd ON pd.id_schedule =sd.id_schedule
WHERE vd.id_driver = '" . $_SESSION['id_driver'] . "'
AND vd.STATUS =1
AND sd.cycle ='" . $_SESSION['cycle'] . "'";
$resultDetail = mysqli_query($conn, $sqlDetail);
$counterDetail = 1;






if (isset ($_POST["simpan"])) {
    $problem = $_POST["problem"];
    $lat = $_POST["latitude"];
    $longi = $_POST['longitude'];
    $id_schedule = $_POST['id_schedule'];

    // Decode base64-encoded image data
    $fotoData = $_POST["foto"];
    $imageBlob = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $fotoData));
    $newImagePath = "../uploads/image_" . uniqid() . ".png";
    file_put_contents($newImagePath, $imageBlob);

    // Convert the binary image data to a hexadecimal representation
    $fotoHex = bin2hex($fotoBinary);

    $sql = "INSERT INTO problem_delivery(bukti_foto, problem, lat, longi, id_schedule,ins_dt,inst_usr) 
            VALUES ('$newImagePath', '$problem', '$lat', '$longi', '$id_schedule',NOW(),'" . $_SESSION['id_driver'] . "')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // header("Location:dashboardVerify.php");
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}
if (isset ($_POST["submit"])) {

    $latitude = $_POST["latitudeKedatangan"];
    $longitude = $_POST['longitudeKedatangan'];
    $id_schedule = $_POST['id_scheduleKedatangan'];

    $id_verifikasi = $_POST['id_verifikasi'];

    // Decode base64-encoded image data
    $fotoData = $_POST["fotoBinary"];
    $imageBlob = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $fotoData));
    $newImagePath = "../uploads/image_" . uniqid() . ".png";
    file_put_contents($newImagePath, $imageBlob);


    // Convert the binary image data to a hexadecimal representation


    $sql = "UPDATE verifikasi_delivery 
    SET bukti_foto='$newImagePath', 
        status=1, 
        actual_arrival=NOW(), 
        longi='$longitude', 
        lat='$latitude' 
    WHERE id_verifikasi='$id_verifikasi' ";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location:dashboardVerify.php");
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}

?>