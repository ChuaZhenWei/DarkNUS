<?php
session_start();

include ('dbFunction.php');

if (!isset($_SESSION['user_id'])){
    header('location:login.php');
} else {
    if (isset($_POST['Action']) ) {
        $id = $_SESSION['user_id'];
        $role = $_SESSION['user_role'];
        $acadYear = $_SESSION['acadYear'];
        $sem = $_SESSION['sem'];
        
        if ($role == 'Student') {
            header('location:index.php');
        } 
        
        $courseName = $_POST['courseName'];
        $selectedDay = $_POST['selectedDay'];
        $startTime = $_POST['starttime'] . ":00";
        $endTime = $_POST['endtime'] . ":00";
        
        $update = "UPDATE Teaches T SET lectureDay = '$selectedDay', 
                startTime = '$startTime', endTime = '$endTime' WHERE
                profID = '$id' AND acadYear = $acadYear AND sem = $sem
                AND courseName = '$courseName'";
        
        echo $update;
        
        pg_query($update);
        if (pg_last_notice($link)) {
            $_SESSION['error'] = pg_last_notice($link);
        }
    }
    header('location:index.php');
}
pg_close();
?>