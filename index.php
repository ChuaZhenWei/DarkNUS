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
    $course = "SELECT E.studid AS UserID, E.courseName AS CourseName, C.faculty AS FacultyName, P.name AS ProfName,
        T.lectureDay, T.startTime, T.endTime
        FROM Enrolls E
        INNER JOIN Teaches T ON E.courseName = T.courseName AND E.acadYear = T.acadYear AND E.sem = T.sem 
        INNER JOIN Professors P ON T.profID = P.profID 
        INNER JOIN Courses C ON E.courseName = C.courseName
        WHERE E.studid = '$id'";
    
} elseif ($role == 'Professor') {
    $query = "SELECT *
        FROM teaches
        WHERE profid = '$id'";
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
        <table width="600" border="0" cellpadding="1" cellspacing="1">
            <tr>
                <th>Course Name</th>
                <th>Faculty</th>
                <th>Professor Name</th>
                <th>Lecture Day</th>
                <th>Lecture Start Time</th>
                <th>Lecture End Time</th>
            </tr>
            <?php while ($row = pg_fetch_row($result)) {
                echo "<tr>";
                    echo "<td> $row[1]</td>";
                    echo "<td> $row[2]</td>";
                    echo "<td> $row[3]</td>";
                    echo "<td> $row[4]</td>";
                    echo "<td> $row[5]</td>";
                    echo "<td> $row[6]</td>";
                echo "<tr>";
            }
            ?>
        </table>
    </body>
</html>
<?php
}
?>
