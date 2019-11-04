<?php
session_start();

include ('dbFunction.php');

if (!isset($_SESSION['user_id'])){
    header('location:index.php');
} else {
    $forumName = $_POST['forumName'];
    $courseName = $_POST['courseName'];
    if (isset($_POST['Action']) && isset($_POST['thread_title']) && isset($_POST['post_content'])) {
        $id = $_SESSION['user_id'];
        
        $acadYear = $_SESSION['acadYear'];
        $semester = $_SESSION['sem'];
        
        $threadTitle = $_POST['thread_title'];
        $postDetail = $_POST['post_content'];
        
        $insert = "INSERT INTO Threads (courseName, acadYear, sem, forumName, threadTitle, postDetails, userID, posted, tutID)
                VALUES ('$courseName', $acadYear, $semester, '$forumName', '$threadTitle', 
                '$postDetail', '$id', current_timestamp, NULL)";
        
        pg_query($insert);
        
        if (pg_last_notice($link)) {
            $_SESSION['result'] = pg_last_notice($link);
            header("location:createThread.php?fname=$forumName&cname=$courseName");
        } else if (pg_last_error($link)) {
            $_SESSION['result'] = "Thread Already Exist";
            header("location:createThread.php?fname=$forumName&cname=$courseName");
        }
    }
    header("location:thread.php?fname=$forumName&cname=$courseName");
}
pg_close();
?>