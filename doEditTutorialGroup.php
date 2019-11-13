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
        
        $courseName = $_POST['courseName'];
        $tutID = $_POST['tutid'];
        $day = $_POST['day'];
        $start = $_POST['starttime'];
        $end = $_POST['endtime'];
        $ta = $_POST['ta'];
        
        $findTA = "SELECT * 
            FROM TEACHING_ASSISTANTS
            WHERE studid = '$ta'
            AND coursename = '$courseName'
            AND acadyear = '$acadYear'
            AND sem = '$sem'
            AND tutid = '$tutID'";
        
        if (pg_num_rows(pg_query($findTA)) == 0) {
            $delTA = "DELETE FROM TEACHING_ASSISTANTS
                WHERE coursename = '$courseName'
                AND acadyear = '$acadYear'
                AND sem = '$sem'
                AND tutid = '$tutID'";
            
            pg_query($delTA);
            
            $insertTA = "INSERT INTO TEACHING_ASSISTANTS (studid, coursename, acadyear, sem, tutid)
                VALUES('$ta', '$courseName', '$acadYear', '$sem', '$tutID')";
            
            pg_query($insertTA);
        }
        
        $updateTut = "UPDATE TUTORIAL_GROUPS
            SET tutday = '$day', starttime = '$start', endtime = '$end'
            WHERE profid = '$id'
            AND coursename = '$courseName'
            AND sem = '$sem'
            AND tutid = '$tutID'";
        
        pg_query($updateTut);
        
        if (pg_last_notice($link)) {
            $_SESSION['result'] = pg_last_notice($link);
            header("location:editTutorialGroup.php?coursename=$courseName&tutid=$tutID");
        } else if (pg_last_error($link)) {
            $_SESSION['result'] = "Nothing Changed";
            header("location:editTutorialGroup.php?coursename=$courseName&tutid=$tutID");
        }
        
        header("location:TutorialGroup.php");
    }
}
pg_close();
?>