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
        $acadYear = $_POST['acadYear'];
        $semester = $_POST['semester'];
        $threadTitle = $_POST['threadTitle'];
        
        $postDetail = $_POST['comment'];
        
        echo $id;
        echo $forumName;
        echo $courseName;
        echo $acadYear;
        echo $semester;
        echo $threadTitle;
        echo $postDetail;
        
        $insert = "INSERT INTO Threads (courseName, acadYear, sem, forumName, threadTitle, postDetails, studID)
                VALUES ('$courseName', $acadYear, $semester, '$forumName', '$threadTitle', 
                '$postDetail', '$id')";
        
        pg_query($insert);
        
        header("location:post.php?fname=$forumName&cname=$courseName&ay=$acadYear&sem=$semester&threadTitle=$threadTitle");
    }
}
pg_close();
?>
