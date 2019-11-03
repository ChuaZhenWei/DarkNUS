<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) { ?>
    <h2>Access Denied. User Not Logged In</h2>
<?php } else {
    $forumName = $_GET['fname'];
    $courseName = $_GET['cname'];
    
    $id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];
    $acadYear = $_SESSION['acadYear'];
    $semester = $_SESSION['sem'];
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
                    <form method="post" action="doCreateThread.php">
                        <input type="hidden" value="<?php echo $forumName ?>" name="forumName">
                        <input type="hidden" value="<?php echo $courseName ?>" name="courseName">
                        <input class="form-control" name="thread_title" type="text" placeholder="Title"><br>
                        <textarea class="form-control" name="post_content" placeholder="Text (required)" rows="5"></textarea><br>
                        <input type="submit" name="Action" value="Create thread">
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