<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
} else {
    if (isset($_POST['Action'])) {
        $id = $_SESSION['user_id'];
        $role = $_SESSION['user_role'];
        $acadYear = $_SESSION['acadYear'];
        $semester = $_SESSION['sem'];
        
        if ($role == 'Student') {
            header('location:tutorialGroup.php');
        }
        
        $selectedCourse = $_POST['courseName'];
        $tutID = $_POST['tutID'];
        $headcount = $_POST['headcount'];
        $selectedDay = $_POST['selectedDay'];
        $startTime = $_POST['startTime'].":00";
        $endTime = $_POST['endTime'].":00";
        $selectedTA = $_POST['selectedTA'];
        
        $insert = "INSERT INTO Tutorial_Groups (profID, courseName, acadYear, sem, tutID, maxHeadCount,
            tutDay, startTime, endTime) VALUES ('$id', '$selectedCourse', $acadYear, $semester, $tutID,
            $headcount, '$selectedDay', '$startTime', '$endTime')";
        
        $query = pg_query($insert);
        
        if ($selectedTA) {
            $insertTA = "INSERT INTO Teaching_Assistants (studid, coursename, acadyear, sem, tutid) VALUES
                    ('$selectedTA', '$selectedCourse', $acadYear, $semester, $tutID)";
            pg_query($insertTA);
        }
        
        $message = pg_last_notice($link);
        if ($message) {
            $_SESSION['error'] = $message;
        }
        $message = pg_last_error($link);
        if ($message) {
            $_SESSION['error'] = "This tutorial group already exist.";
        }
    }
    header('location:tutorialGroup.php');
}

pg_close();
?>