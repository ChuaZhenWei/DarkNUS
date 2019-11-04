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
        $sem = $_SESSION['sem'];
        
        $insert = "INSERT INTO FORUMS (profid, coursename, acadYear, sem, forumName, tutid, forumdescription)
                VALUES ('$id', '$courseName', $acadYear, $sem, '$forumName', '$tutId', '$forumdesc')";
        
        pg_query($insert);
        
        if (pg_last_notice($link)) {
            $_SESSION['result'] = pg_last_notice($link);
            header("location:createForumTutId.php");
        } else if (pg_last_error($link)) {
            $_SESSION['result'] = "Forum Already Exist";
            header("location:createForumTutId.php");
        }
        
        header("location:forum.php");
    } else {
        $_SESSION['result'] = "Please fill in the missing fields";
        header("location:createForumTutId.php");
    }
}
pg_close();
?>