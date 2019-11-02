<?php
session_start();
$message="";

if (isset($_SESSION['user_id'])) {
    $_SESSION = array();
    session_destroy();
}
header('location:index.php');

include ("navBar.php");
?>