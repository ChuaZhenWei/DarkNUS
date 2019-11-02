<?php
session_start();

include ('dbFunction.php');

if (!isset($_SESSION['user_id'])){
    header('location:index.php');
} else {
    if (isset($_POST['Action']) && isset($_POST['thread_title']) && isset($_POST['post_content'])) {
        $id = $_SESSION['user_id'];
        
        $forumName = $_POST['forumName'];
        $courseName = $_POST['courseName'];
        $acadYear = $_POST['acadYear'];
        $semester = $_POST['semester'];
        
        $threadTitle = $_POST['thread_title'];
        $postDetail = $_POST['post_content'];
        
        echo $id;
        echo $forumName;
        echo $courseName;
        echo $acadYear;
        echo $semester;
        
        echo $threadTitle;
        echo $postDetail;
        
        $insert = "INSERT INTO Threads (courseName, acadYear, sem, forumName, threadTitle, postDetails, userID, posted)
                VALUES ('$courseName', $acadYear, $semester, '$forumName', '$threadTitle', 
                '$postDetail', '$id', current_timestamp)";
        
        
        pg_query($insert);
        
        header("location:thread.php?fname=$forumName&cname=$courseName&ay=$acadYear&sem=$semester");
    }
}
pg_close();
?>