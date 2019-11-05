<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
} else {

    $id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];
    $acadYear = $_SESSION['acadYear'];
    $sem = $_SESSION['sem']; 

    if ($role == 'Student') {
        $forum = "
            SELECT DISTINCT F.forumName, F.courseName, F.acadYear, F.sem
            FROM Forums F LEFT JOIN Enrolls E ON F.courseName = E.courseName
            AND F.acadYear = E.acadYear AND F.sem = E.sem 
            WHERE F.tutID = 0 AND E.studID = '$id' AND F.acadYear = $acadYear AND F.sem = $sem
            UNION
            SELECT DISTINCT F.forumName, F.courseName, F.acadYear, F.sem
            FROM Belongs B NATURAL JOIN Forums F
            WHERE B.studid = '$id' AND F.acadYear = $acadYear AND F.sem = $sem
            UNION
            SELECT DISTINCT F.forumName, F.courseName, F.acadYear, F.sem
            FROM Teaching_Assistants TA LEFT JOIN Forums F ON TA.courseName = F.courseName
            AND TA.acadYear = F.acadYear AND TA.sem = F.sem  
            WHERE TA.studid = '$id' AND F.acadYear = $acadYear AND F.sem = $sem";
    } elseif ($role == 'Professor') {
        $forum = "
            SELECT DISTINCT F.forumName, F.courseName, F.acadYear, F.sem
            FROM Forums F WHERE F.profID = '$id' AND F.acadYear = $acadYear AND F.sem = $sem";
    }

    $result = pg_query($forum);
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
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Forum</li>
                </ol>
            </nav>
            
            <div class="card-body">
                <?php
                if ($role == 'Professor')
                {
                    echo "<a class='btn btn-primary' href='createForumMod.php' role='button'>Create Forum</a>";
                    echo "<br><br>";
                }
                ?>
                <table class="table">
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
                            echo "<h4><a href='thread.php?fname=$row[0]&amp;cname=$row[1]'>$row[0]</a></h4>";
                            echo "<p>$row[1]</p>";
                            echo "<p>Academic Year $row[2], ";
                            echo "Semester $row[3]</p>"; 
                            echo "</td>";
                            echo "<td>";
                            echo "<p>Number of Discussion Threads: $threadCount</p>";
                            if ($role == 'Professor') {
                                echo "<br>";
                                echo "<a href='doDeleteForum.php?fname=$row[0]&amp;cname=$row[1]'><input type = 'button' value = 'Delete' class='btn btn-danger'></a>";
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