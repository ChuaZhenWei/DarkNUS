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
        FROM enrolls
        WHERE studid = '$id';";
    
    $course = "SELECT U.userID AS UserID, E.courseName AS CourseName, C.faculty AS FacultyName, P.name AS ProfName "
            . "FROM Users U INNER JOIN Enrolls E ON U.userID = E.studID INNER JOIN Teaches T ON E.courseName = T.courseName AND E.acadYear = T.acadYear AND E.sem = T.sem INNER JOIN Professors P ON T.profID = P.profID INNER JOIN Courses C ON E.courseName = C.courseName "
            . "WHERE U.userid = '$id';";
    
} elseif ($role == 'Professor') {
    $query = "SELECT *
        FROM teaches
        WHERE profif = '$id'";
}

$result = pg_query($course);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>Courses</h2>
        <table>
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Faculty</th>
                    <th>Professor Name</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <?php while ($row = pg_fetch_row($result)) {
                    echo "<td> $row[1]</td>";
                    echo "<td> $row[2]</td>";
                    echo "<td> $row[3]</td>";
                }
                ?>
                </tr>
            </tbody>
        </table>
    </body>
</html>
<?php
}
?>
