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
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- jQuery library -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
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
                    <input class="form-control" name="thread_title" type="text" placeholder="Title" required><br>
                    <textarea class="form-control" name="post_content" placeholder="Text (required)" rows="5" required></textarea><br>
                    <input type="submit" name="Action" value="Create Thread" class="btn btn-success">
                </form>
            </div>
        </div>
    </body>
</html> 
<?php
}
?>