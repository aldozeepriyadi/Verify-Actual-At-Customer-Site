<?php
session_start(); 
include ("../session.php");
if($_SESSION['role_id'] != 2){
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
    <?php include ("../Content/Content_finish_good/sidebar_finish_good.php");?>
    <?php include ("../Content/Content_finish_good/dashboard_finish_good_page.php");?>
    <?php include ("../Content/footer_content.php");?>
</body>

</html>