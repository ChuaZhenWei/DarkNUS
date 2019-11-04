<?php
session_start();

include ('dbFunction.php');

if (!isset($_SESSION['user_id'])){
    header('location:index.php');
} else {
    $id = $_SESSION['user_id'];
    $acadYear = $_SESSION['acadYear'];
    $sem = $_SESSION['sem'];
    
    if (isset($_POST['Action'])) {
        $forumName = $_POST['forumName'];
        $courseName = $_POST['courseName'];
        $threadTitle = $_POST['threadTitle'];      
        $postDetail = $_POST['comment'];
        
        $insert = "INSERT INTO Threads (courseName, acadYear, sem, forumName, threadTitle, postDetails, userID, posted, tutID)
                VALUES ('$courseName', $acadYear, $sem, '$forumName', '$threadTitle', 
                '$postDetail', '$id', current_timestamp, NULL)";
        
        
        pg_query($insert);
        
        if (pg_last_notice($link)) {
            $_SESSION['result'] = pg_last_notice($link);
        } else if (pg_last_error($link)) {
            $_SESSION['result'] = "Post Already Exist. Please Avoid Duplicated Post";
        }
        
        header("location:post.php?fname=$forumName&cname=$courseName&threadTitle=$threadTitle");
    } else if (isset($_GET['coursename'])) {
        $courseName = $_GET['coursename'];
        $forumName = $_GET['forumname'];
        $threadTitle = $_GET['tt'];
        $postDetails = $_GET['td'];
        $lForum = $_GET['lForum'];
        $lCourse = $_GET['lCourse'];
        $lTitle = $_GET['lTitle'];    
        
        $delete = "DELETE FROM THREADS
            WHERE coursename = '$courseName'
            AND acadYear = '$acadYear'
            AND sem = '$sem'
            AND forumname = '$forumName'
            AND threadtitle = '$threadTitle'
            AND postdetails = '$postDetails'";
        
        pg_query($delete);
        
        header("location:post.php?fname=$lForum&cname=$lCourse&threadTitle=$lTitle");
    }
}
pg_close();
?>
