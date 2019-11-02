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
    $forum = "SELECT F.forumName, F.courseName, COUNT(*) AS noOfThreads
        FROM Belongs B NATURAL JOIN Forums F
        INNER JOIN Threads T ON F.courseName = T.courseName
        AND F.acadYear = T.acadYear and F.sem = T.sem AND F.forumName = T.forumName
        WHERE B.studid = '$id'
        GROUP BY F.forumName, F.courseName";
    
} elseif ($role == 'Professor') {
    $forum = "SELECT forumName, courseName
        FROM Forums F 
        WHERE profid = '$id'";
}

$result = pg_query($forum);

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>Forum</h2>
            <div class="card">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Forum</li>
                    </ol>
                </nav>
                <div class="card-body">
                    <table cellspacing="1000">
                        <tbody>
                            <?php
                            while ($row = pg_fetch_row($result)) {
                                
                                echo "<tr>";
                                echo "<td>";
                                echo "<h4><a href='thread.php'>$row[0]</a></h4>";
                                echo "<p>$row[1]</p>";
                                echo "</td>";
                                echo "<td>";
                                echo "<p>Number of Discussion Threads: $row[2]</p>";
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