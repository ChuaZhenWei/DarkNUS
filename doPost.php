<?php
session_start();

include ('dbFunction.php');

if (!isset($_SESSION['user_id'])){
    header('location:index.php');
} else {
    if (isset($_POST['Action']) && isset($_POST['comment'])) {
        $id = $_SESSION['user_id'];
        
        $forumName = $_POST['forumName'];
        $courseName = $_POST['courseName'];
        $acadYear = $_SESSION['acadYear'];
        $semester = $_SESSION['sem'];
        $threadTitle = $_POST['threadTitle'];
        
        $postDetail = $_POST['comment'];
        
        $insert = "INSERT INTO Threads (courseName, acadYear, sem, forumName, threadTitle, postDetails, userID, posted)
                VALUES ('$courseName', $acadYear, $semester, '$forumName', '$threadTitle', 
                '$postDetail', '$id', current_timestamp)";
        
        
        pg_query($insert);
        
        header("location:post.php?fname=$forumName&cname=$courseName&threadTitle=$threadTitle");
    }
}
pg_close();
?>
