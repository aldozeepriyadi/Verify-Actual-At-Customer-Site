<?php
session_start(); 
include ("../session.php");

if($_SESSION['role_id'] != 3){
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
    <?php include ("../Content/Content_kadept/sidebar_kadept.php");?>
    <?php include ("../Component/component_kadept/component_monitoringdriver.php");?>
    <?php include ("../Content/footer_content.php");?>
</body>

</html>