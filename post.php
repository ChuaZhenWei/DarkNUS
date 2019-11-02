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
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="forum.php">Forum</a></li>
                    <li class="breadcrumb-item"><a href="thread.php">"Forum Name"</a></li>
                    <li class="breadcrumb-item active" aria-current="page">"Thread Name"</li>                    
                </ol>
                </nav>
                <div class="card-body">                   
                    <h4><a href="#">Thread Title</a></h4>
                    <p>Posted by "Name of poster"</p>
                    <hr>
                    <p>Dear Prof, for the past few lectures...</p>
                    <br>
                    <form>
                        <div class="form-group">
                            <label for="comment">Comment:</label>
                            <textarea class="form-control" rows="5" id="comment"></textarea>
                        </div>
                        <input type="submit" value="Submit">
                    </form>
                    <hr>
                    <br>
                    <p>Reply by "Name of poster"</p>
                    <p>There is no mistake in the updated lecture notes...</p>
                    <hr>
                </div>
            </div>
    </body>
</html> 
<?php
}
?>