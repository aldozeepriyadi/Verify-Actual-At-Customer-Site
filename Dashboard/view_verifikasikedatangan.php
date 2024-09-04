<?php
session_start();
include ("../session.php");
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
    <?php include ("../Content/head_tag.php"); ?>
</head>

<body>

    <?php include ("../Content/header_content.php"); ?>
    <?php include ("../Content/Content_driver/sidebar_driver.php"); ?>
    <?php include ("../Component/component_driver/component_viewverfikasikedatangan.php"); ?>


</body>
<?php include ("../Content/footer_content.php"); ?>

</html>