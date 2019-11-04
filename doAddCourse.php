<?php
session_start();

include ('dbFunction.php');

if (!isset($_SESSION['user_id'])){
    header('location:login.php');
} else {
    if (isset($_POST['Action']) ) {
        $id = $_SESSION['user_id'];
        $acadYear = $_SESSION['acadYear'];
        $sem = $_SESSION['sem'];
        
        $courseName = $_POST['coursename'];
        $day = $_POST['lectureday'];
        $start = $_POST['starttime'];
        $end = $_POST['endtime'];
        $max = $_POST['maxheadcount'];
        
        $insert = "INSERT INTO TEACHES (profid, coursename, acadYear, sem, lectureday, starttime, endtime, maxheadcount)
                VALUES ('$id', '$courseName', $acadYear, $sem, '$day', '$start', '$end', '$max')";
        
        pg_query($insert);
        
        if (pg_last_notice($link)) {
            $_SESSION['result'] = pg_last_notice($link);
            header("location:createForumTutId.php");
        } else if (pg_last_error($link)) {
            $_SESSION['result'] = "Already Teaching Course";
            header("location:createForumTutId.php");
        }
        
        header("location:index.php");
    }
}
pg_close();
?>