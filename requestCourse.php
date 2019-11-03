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
        $course = "SELECT ROW_NUMBER() OVER (ORDER BY NULL) AS No, *
            FROM (SELECT T.courseName as CourseName, C.faculty as Faculty, P.name as ProfName, P.profid, T.lectureDay, T.startTime, T.endTime
            FROM Professors P NATURAL JOIN Teaches T INNER JOIN Courses C ON T.courseName = C.courseName
            WHERE acadYear = '$acadYear' AND sem = '$sem'
            EXCEPT
            (SELECT T.courseName, C.faculty, P.name, P.profid, T.lectureDay, T.startTime, T.endTime
            FROM Enrolls E NATURAL JOIN Teaches T NATURAL JOIN Professors P INNER JOIN Courses C ON T.courseName = C.courseName
            WHERE E.studID = '$id'
            AND acadyear = '$acadYear'
            and sem = '$sem'
            UNION
            SELECT R.coursename, C.faculty, P.name, P.profid, T.lectureday, T.starttime, T.endtime
            FROM REQUESTS R
            NATURAL JOIN Teaches T
            NATURAL JOIN Professors P
            INNER JOIN Courses C ON R.coursename = C.coursename
            WHERE R.studID = '$id'
            AND acadyear = '$acadYear'
            and sem = '$sem')) AS F";
}

$results = pg_query($course)
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>Request Courses</h2>
        <form action = "doRequestCourse.php" method ="post">
            <table width="1500" border="0" cellpadding="1" cellspacing="1">
                <col width = "80">
                <col width = "500">
                <col width = "200">
                <col width = "200">
                <col width = "200">
                <col width = "200">
                <col width = "200">
                <tr>
                    <th>Select</th>
                    <th>Course Name</th>
                    <th>Faculty</th>
                    <th>Professor Name</th>
                    <th>Lecture Day</th>
                    <th>Lecture Start Time</th>
                    <th>Lecture End Time</th>
                </tr>
                <?php
                while($row = pg_fetch_row($results)) {
                    echo "<tr>"; ?>
                    <td><input type = 'radio' name = 'courseChoice' value = '<?php echo $row[0] ?>'></td>
                    <?php
                    echo "<td> $row[1]</td>";
                    echo "<td> $row[2]</td>";
                    echo "<td> $row[3]</td>";
                    echo "<td> $row[5]</td>";
                    echo "<td> $row[6]</td>";
                    echo "<td> $row[7]</td>";
                    echo "<tr>";
                }
                ?>
            </table>
            <br />
            <br />
            <input type = "Submit" name = "Action" value = "Add">
        </form>
    </body>
</html> 
<?php
}
?>