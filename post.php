<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
} else {

    $forumName = $_GET['fname'];
    $courseName = $_GET['cname'];
    $acadYear = $_GET['ay'];
    $semester = $_GET['sem'];
    $threadTitle = $_GET['threadTitle'];
    
    $id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];

    if ($role == 'Student') {
        $post = "SELECT T.courseName, T.acadYear, T.sem, T.forumName, T.threadTitle, T.postDetails
            FROM Threads T
            WHERE T.courseName = '$courseName' AND T.forumName = '$forumName' 
            AND T.acadYear = $acadYear AND T.sem = $semester AND T.threadTitle = '$threadTitle'";
    } elseif ($role == 'Professor') {
        $post = "SELECT T.courseName, T.acadYear, T.sem, T.forumName, T.threadTitle, T.postDetails
            FROM Threads T
            WHERE T.courseName = '$courseName' AND T.forumName = '$forumName' 
            AND T.acadYear = $acadYear AND T.sem = $semester AND T.threadTitle = '$threadTitle'";
    }

    $results = pg_query($post);
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
                            <li class="breadcrumb-item">
                        <?php
                        echo "<a href='thread.php?fname=$forumName&amp;cname=$courseName&amp;ay=$acadYear&amp;sem=$semester'>";
                        echo $forumName;
                        ?>
                        </a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                    <?php
                    echo $threadTitle;
                    ?>
                    </li>                    
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