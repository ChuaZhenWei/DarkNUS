<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
} else {

    $id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];

    if ($role == 'Student') {
        $forum = "
            SELECT DISTINCT F.forumName, F.courseName, F.acadYear, F.sem
            FROM Forums F LEFT JOIN Threads T ON F.courseName = T.courseName
            AND F.acadYear = T.acadYear and F.sem = T.sem AND F.forumName = T.forumName
            WHERE F.tutID IS NULL AND T.threadTitle IS NOT NULL
            UNION
            SELECT DISTINCT F.forumName, F.courseName, F.acadYear, F.sem
            FROM Belongs B NATURAL JOIN Forums F
            INNER JOIN Threads T ON F.courseName = T.courseName
            AND F.acadYear = T.acadYear and F.sem = T.sem AND F.forumName = T.forumName
            WHERE B.studid = '$id'";
    } elseif ($role == 'Professor') {
        $forum = "
            SELECT F.forumName, F.courseName, F.acadYear, F.sem
            FROM Forums F LEFT JOIN Threads T ON F.courseName = T.courseName
            AND F.acadYear = T.acadYear and F.sem = T.sem AND F.forumName = T.forumName
            WHERE F.tutID IS NULL AND T.threadTitle IS NOT NULL
            UNION
            SELECT F.forumName, F.courseName, F.acadYear, F.sem
            FROM Forums F INNER JOIN Threads T ON F.courseName = T.courseName
            AND F.acadYear = T.acadYear and F.sem = T.sem AND F.forumName = T.forumName
            WHERE F.profid = '$id'";
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
                                $discussion = "
                                    SELECT COUNT (*) AS threadCount
                                    FROM 
                                    (
                                        SELECT DISTINCT F.forumName, F.courseName, F.acadYear, F.sem, T.threadTitle
                                        FROM Forums F LEFT JOIN Threads T ON F.courseName = T.courseName
                                        AND F.acadYear = T.acadYear and F.sem = T.sem AND F.forumName = T.forumName
                                        WHERE T.threadTitle IS NOT NULL
                                        GROUP BY F.forumName, F.courseName, F.acadYear, F.sem, T.threadTitle
                                    ) AS A
                                    WHERE A.forumName = '$row[0]' AND A.courseName = '$row[1]'
                                    AND A.acadYear = $row[2] AND A.sem = $row[3]";
                                $query = pg_query($discussion);
                                $threadCount = pg_fetch_result($query, 0, 0);
                                echo "<tr>";
                                echo "<td>";
                                echo "<h4><a href='thread.php?fname=$row[0]&amp;cname=$row[1]&amp;ay=$row[2]&amp;sem=$row[3]'>$row[0]</a></h4>";
                                echo "<p>$row[1]</p>";
                                echo "<p>Academic Year $row[2], ";
                                echo "Semester $row[3]</p>"; 
                                echo "</td>";
                                echo "<td>";
                                echo "<p>Number of Discussion Threads: $threadCount</p>";
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