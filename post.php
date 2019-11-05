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
    $sem = $_SESSION['sem'];
    
    $TA = false;
    
    $post = "
        SELECT *
        FROM
        (
        SELECT S.name, T.courseName, T.forumName, T.threadTitle, T.postDetails, T.posted, T.userid
        FROM Threads T INNER JOIN Students S ON T.userID = S.studID 
        WHERE T.courseName = '$courseName' AND T.forumName = '$forumName'
        AND T.acadYear = $acadYear AND T.sem = $sem AND T.threadTitle = '$threadTitle'
        UNION
        SELECT P.name, T.courseName, T.forumName, T.threadTitle, T.postDetails, T.posted, T.userid
        FROM Threads T INNER JOIN Professors P ON T.userID = P.profID
        WHERE T.courseName = '$courseName' AND T.forumName = '$forumName'
        AND T.acadYear = $acadYear AND T.sem = $sem AND T.threadTitle = '$threadTitle'
        ) AS A
        ORDER BY A.posted";
    
    $results = pg_query($post);
    
    $findTA = "SELECT *
        FROM TEACHING_ASSISTANTS
        NATURAL JOIN FORUMS
        WHERE studid = '$id'
        AND acadyear = '$acadYear'
        AND sem = '$sem'
        AND coursename = '$courseName'";

    
    if (pg_num_rows(pg_query($findTA)) > 0) {
        $TA = true;
    } 
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
                    <form method="post" action="doPost.php">
                        <input type="hidden" value="<?php echo $forumName ?>" name="forumName">
                        <input type="hidden" value="<?php echo $courseName ?>" name="courseName">
                        <input type="hidden" value="<?php echo $threadTitle ?>" name="threadTitle">
                        <div class="form-group">
                            <label for="comment">Comment:</label>
                            <textarea name="comment" class="form-control" rows="5" id="comment" required></textarea>
                        </div>
                        <input type="submit" name="Action" value="Submit" class="btn btn-success">
                    </form>
                    <?php 
                    if (isset($_SESSION['result'])) {
                        echo $_SESSION['result'];
                        unset($_SESSION['result']);
                    } ?>
                    <hr>
                    <br>
                    <?php
                    $row = pg_fetch_row($results);
                    while ($row = pg_fetch_row($results)) {
                        echo "<p>Reply by $row[0]";
                        echo "</p>";
                        echo "<p>$row[4]</p>";
                        if ($row[6] == $id || $role == 'Professor' || $TA == true) {
                                echo "<a style='color:red' href='doPost.php?coursename=$row[1]&amp;forumname=$row[2]&amp;tt=$row[3]&amp;td=$row[4]&amp;lForum=$forumName&amp;lCourse=$courseName&amp;lTitle=$threadTitle'>Delete</a>";
                        }
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