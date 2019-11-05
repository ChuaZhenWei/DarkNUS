<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
} else {
    $forumName = $_GET['fname'];
    $courseName = $_GET['cname'];
    
    $id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];
    $acadYear = $_SESSION['acadYear'];
    $semester = $_SESSION['sem'];

    if ($role == 'Student') {
        $thread = "SELECT T.courseName, T.forumName, T.threadTitle, COUNT(*) AS noOfReplies
            FROM Threads T
            WHERE T.courseName = '$courseName' AND T.forumName = '$forumName' 
            AND T.acadYear = $acadYear AND T.sem = $semester
            GROUP BY T.courseName, T.acadYear, T.sem, T.forumName, T.threadTitle";

    } elseif ($role == 'Professor') {
        $thread = "SELECT T.courseName, T.forumName, T.threadTitle, COUNT(*) AS noOfReplies
            FROM Threads T
            WHERE T.courseName = '$courseName' AND T.forumName = '$forumName' 
            AND T.acadYear = $acadYear AND T.sem = $semester
            GROUP BY T.courseName, T.acadYear, T.sem, T.forumName, T.threadTitle";
    }
    
    if(isset($_POST['searchThread'])){       
        if(isset($_POST['threadTitle']) && !empty($_POST['threadTitle']))
        {  
            $word = $_POST['threadTitle'];
            $query= "SELECT T.courseName, T.forumName, T.threadTitle, COUNT(*) AS noOfReplies
                FROM Threads T WHERE lower(threadTitle) LIKE '%$word%' AND forumName = '$forumName' AND courseName = '$courseName'
                AND acadYear = $acadYear AND sem = $semester
                GROUP BY T.courseName, T.acadYear, T.sem, T.forumName, T.threadTitle";

            $thread = $query;
        }       
    }
    $results = pg_query($thread);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div class="card">
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="forum.php">Forum</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php
                    echo $forumName;
                    ?>
                </li>                    
            </ol>
            </nav>
            <nav class="navbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <?php
                        echo "<a class='btn btn-primary' href='createThread.php?fname=$forumName&amp;cname=$courseName'
                            role='button'>Create New Thread</a>";
                        ?>          
                    </li>       
                </ul>
                <form class="form-inline my-2 my-sm-0" method="post" action="">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search Threads" aria-label="Search" name="threadTitle" required>
                    <button name="searchThread" class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </nav>
            <div class="card-body">
                <table class="table">
                    <tbody>
                        <?php
                        while ($row = pg_fetch_row($results)) {
                            echo "<tr>";
                            echo "<td>";
                            echo "<h4><a href='post.php?fname=$row[1]&amp;cname=$row[0]&amp;threadTitle=$row[2]'>$row[2]</a></h4>";
                            echo "</td>";
                            echo "<td>";
                            echo "<p>Number of replies: $row[3]</p>";
                            if ($role == 'Professor') {
                                echo "<a href='doDeleteThread.php?cname=$row[0]&amp;fname=$row[1]&amp;threadTitle=$row[2]'><input type = 'button' value = 'Delete' class='btn btn-danger'></a><br><br>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html> 
<?php
}
?>