<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
} else {    
    $id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];
    $acadYear = $_SESSION['acadYear'];
    $semester = $_SESSION['sem'];

    if ($role == 'Student') {
        header('location:tutorialGroup.php');
    }

    $courseName = $_GET['courseName'];
    $tutID = $_GET['tutID'];

    $delete = "DELETE FROM Tutorial_Groups WHERE courseName = '$courseName' AND
        acadYear = $acadYear AND sem = $semester AND tutID = $tutID";
    
    pg_query($delete);
        
    header("location:tutorialGroup.php");
}
pg_close();
?>