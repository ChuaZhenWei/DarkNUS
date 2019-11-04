<?php
session_start();

include ('dbFunction.php');

if (!isset($_SESSION['user_id'])){
    header('location:index.php');
} else {
    if (isset($_POST['Action']) && isset($_POST['forumName']) && $_POST['tutid']!='' && isset($_POST['forumdesc']) ) {
        $id = $_SESSION['user_id'];
        
        $forumName = $_POST['forumName'];
        $courseName = $_POST['courseName'];
        $tutId = $_POST['tutid'];
        $forumdesc = $_POST['forumdesc'];
        
        $acadYear = $_SESSION['acadYear'];
        $semester = $_SESSION['sem'];
        
        echo "fn: $forumName, cn: $courseName, tid: $tutId, fd: $forumdesc";
        
        $insert = "INSERT INTO FORUMS (profid, coursename, acadYear, sem, forumName, tutid, forumdescription)
                VALUES ('$id', '$courseName', $acadYear, $semester, '$forumName', '$tutId', '$forumdesc')";
        
        pg_query($insert);
        
        header("location:forum.php");
    } else {
        echo "LL";
    }
}
pg_close();
?>