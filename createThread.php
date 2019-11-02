<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) { ?>
    <h2>Access Denied. User Not Logged In</h2>
<?php } else {
    $forumName = $_GET['fname'];
    $courseName = $_GET['cname'];
    $acadYear = $_GET['ay'];
    $semester = $_GET['sem'];
    
    $id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];
    
    if (isset($_POST['submit'])) {
        $threadTitle = $_POST['thread_title'];
        $postDetail = $_POST['post_content'];

        $insert = "INSERT INTO Threads (courseName, acadYear, sem, forumName, threadTitle, postDetails, userID, posted)
                    VALUES ('$courseName', $acadYear, $semester, '$forumName', '$threadTitle', 
                    '$postDetail', '$id', current_timestamp)";

        pg_query($insert);
    }
    
    pg_close();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>Threads</h2>
            <div class="card">
                <div class="card-body">                   
                    <h4>Start a Discussion Thread</h4>
                    <p class="font-weight-light">for
                    <?php
                        echo $forumName
                    ?></p>
                    <hr>
                    <?php
                    echo $acadYear;
                    echo $semester;
                    echo "<form method='post' action='thread.php?fname=$forumName&cname=$courseName&ay=$acadYear&sem=$semester'>";
                    ?>
                        <input class="form-control" name="thread_title" type="text" placeholder="Title"><br>
                        <textarea class="form-control" name="post_content" placeholder="Text (required)" rows="5"></textarea><br>
                        <input type="submit" value="Create thread">
                    </form>

                    <hr>
                    <br>
                </div>
            </div>
    </body>
</html> 
<?php
}
?>