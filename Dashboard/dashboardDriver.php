<?php
session_start(); 
include ("../session.php");
include ("../action/verifikasi_kedatangan.php");

if($_SESSION['role_id'] != 1){
    session_unset();
    session_destroy();
    header("Location: ../");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <?php include ("../Content/head_tag.php");?>
</head>

<body>

    <?php include ("../Content/header_content.php");?>
    <?php include ("../Content/Content_driver/sidebar_driver.php");?>
    <?php include ("../Content/Content_driver/dashboard_driver_page.php");?>
    <?php include ("../Content/footer_content.php");?>

</body>

</html>