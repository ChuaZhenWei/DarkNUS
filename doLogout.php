<?php
session_start();
$message="";

if (!isset($_SESSION['user_id'])) {
    $message='<p>You are not logged in.</p>';
}
else{
    $_SESSION = array();
    session_destroy();
    $message = '<p>You have logged out.</p>';
}

include ("navBar.php");
echo $message;
?>