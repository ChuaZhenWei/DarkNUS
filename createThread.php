<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) { ?>
    <h2>Access Denied. User Not Logged In</h2>
<?php } else {

$id = $_SESSION['user_id'];
$role = $_SESSION['user_role'];

if ($role == 'Student') {
    $query = "SELECT *
        FROM students
        WHERE studid = '$id'";
    
} elseif ($role == 'Professor') {
    $query = "SELECT *
        FROM teaches
        WHERE profid = '$id'";
}

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
                    <p class="font-weight-light">for "Forum Name"</p>
                    <hr>
                    <form method="post" action="">
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