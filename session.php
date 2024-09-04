<?php
session_start();

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../");
    exit();
}

if (!isset($_SESSION['username'])) {
    session_unset();
    session_destroy();
    header("Location: ../");
    exit();
}
?>
