<?php
session_start();

include ('dbFunction.php');

if (!isset($_SESSION['user_id'])){
    header('location:index.php');
} else {
    if (isset($_GET['cname']) && isset($_GET['fname']) && isset($_GET['threadTitle'])) {
        $id = $_SESSION['user_id'];
        $acadYear = $_SESSION['acadYear'];
        $sem = $_SESSION['sem'];
        
        $forumName = $_GET['fname'];
        $courseName = $_GET['cname'];
        $threadTitle = $_GET['threadTitle'];
        
        $delete = "DELETE FROM THREADS
            WHERE coursename = '$courseName'
            AND acadyear = '$acadYear'
            AND sem = '$sem'
            AND forumname = '$forumName'
            AND threadtitle = '$threadTitle'";
        
        pg_query($delete);
    }
    header("location:thread.php?fname=$forumName&cname=$courseName");
}
pg_close();
?>