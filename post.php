<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
} else {

    $forumName = $_GET['fname'];
    $courseName = $_GET['cname'];
    $threadTitle = $_GET['threadTitle'];
    
    $id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];
    $acadYear = $_SESSION['acadYear'];
    $semester = $_SESSION['sem'];
    
    $post = "
        SELECT *
        FROM
        (
        SELECT S.name, T.courseName, T.forumName, T.threadTitle, T.postDetails, T.posted
        FROM Threads T INNER JOIN Students S ON T.userID = S.studID 
        WHERE T.courseName = '$courseName' AND T.forumName = '$forumName'
        AND T.acadYear = $acadYear AND T.sem = $semester AND T.threadTitle = '$threadTitle'
        UNION
        SELECT P.name, T.courseName, T.forumName, T.threadTitle, T.postDetails, T.posted
        FROM Threads T INNER JOIN Professors P ON T.userID = P.profID
        WHERE T.courseName = '$courseName' AND T.forumName = '$forumName'
        AND T.acadYear = $acadYear AND T.sem = $semester AND T.threadTitle = '$threadTitle'
        ) AS A
        ORDER BY A.posted";

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
                        echo "<a href='thread.php?fname=$forumName&amp;cname=$courseName'>";
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
                            <h4><a href="#">
                        <?php
                        echo $threadTitle;
                        echo "</a></h4>";
                        $threadStarter = pg_fetch_result($results, 0, 0);
                        $threadDetails = pg_fetch_result($results, 0, 4);
                        echo "<p>Posted by $threadStarter</p>";
                        echo "<hr>";
                        echo "<p>$threadDetails</p>";
                        echo "<br>";
                        ?>
                    <form method="post" action="doPost.php  ">
                        <input type="hidden" value="<?php echo $forumName ?>" name="forumName">
                        <input type="hidden" value="<?php echo $courseName ?>" name="courseName">
                        <input type="hidden" value="<?php echo $threadTitle ?>" name="threadTitle">
                        <div class="form-group">
                            <label for="comment">Comment:</label>
                            <textarea name="comment" class="form-control" rows="5" id="comment"></textarea>
                        </div>
                        <input type="submit" name="Action" value="Submit">
                    </form>
                    <hr>
                    <br>
                    <?php
                    $row = pg_fetch_row($results);
                    while ($row = pg_fetch_row($results)) {
                        echo "<p>Reply by $row[0]</p>";
                        echo "<p>$row[4]</p>";
                        echo "<hr>";
                    }
                    ?>
                </div>
            </div>
    </body>
</html> 
<?php
}
?>