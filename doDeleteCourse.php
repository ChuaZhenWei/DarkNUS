<?php
session_start();

include ('dbFunction.php');

if (!isset($_SESSION['user_id'])){
    header('location:login.php');
} else {
    if (isset($_POST['delChoice'])){
        $id = $_SESSION['user_id'];
        $acadYear = $_SESSION['acadYear'];
        $sem = $_SESSION['sem'];
        $courseName = $_POST['delChoice'];
       
        $delete = "DELETE FROM TEACHES
                WHERE profid = '$id'
                AND coursename = '$courseName'
                AND acadyear = '$acadYear'
                AND sem = '$sem'";
            
        pg_query($delete);
    }
    header('location:index.php');
}
pg_close($link);
?>

