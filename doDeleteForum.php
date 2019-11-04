<?php
session_start();

include ('dbFunction.php');

if (!isset($_SESSION['user_id'])){
    header('location:index.php');
} else {
    if (isset($_GET['fname']) && isset($_GET['cname'])) {
        $id = $_SESSION['user_id'];
        
        $forumName = $_GET['fname'];
        $courseName = $_GET['cname'];
        
        $acadYear = $_SESSION['acadYear'];
        $sem = $_SESSION['sem'];
        
        $delete = "DELETE FROM FORUMS
                WHERE coursename = '$courseName'
                AND forumname = '$forumName'
                AND acadyear = '$acadYear'
                AND sem = '$sem'";
        
        pg_query($delete);
    }
    header("location:forum.php");
}
pg_close();
?>