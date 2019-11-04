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
    $course = "SELECT E.courseName AS CourseName, C.faculty AS FacultyName, P.name AS ProfName,
        T.lectureDay, T.startTime, T.endTime
        FROM Enrolls E
        INNER JOIN Teaches T ON E.courseName = T.courseName AND E.acadYear = T.acadYear AND E.sem = T.sem 
        INNER JOIN Professors P ON T.profID = P.profID 
        INNER JOIN Courses C ON E.courseName = C.courseName
        WHERE E.studid = '$id'
        AND E.acadyear = '$acadYear'
        AND E.sem = '$sem'";
    
} elseif ($role == 'Professor') {
    $course = "SELECT T.coursename, C.faculty, T.lectureday, T.starttime, T.endtime
        FROM TEACHES T
        JOIN COURSES C ON T.coursename = C.coursename
        WHERE profid = '$id'
        AND acadyear = '$acadYear'
        AND sem = '$sem'";
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
        <?php
        if ($role == 'Professor')
        {
            echo "<nav class='navbar'>";
                echo "<ul class='navbar-nav'>";
                    echo "<li class='nav-item'>";
                        echo "<a class='btn btn-primary' href='addCourse.php' role='button'>Add Course</a>";
                    echo "</li>";
                echo "</ul>";
            echo "</nav>";
        }
        ?>
        <table width="1500" border="0" cellpadding="1" cellspacing="1">
            <col width = "500">
            <col width = "200">
            <col width = "200">
            <col width = "200">
            <col width = "200">
            <col width = "200">
            <tr>
                <th>Course Name</th>
                <th>Faculty</th>
                <?php
                if ($role == 'Student') {
                    echo "<th>Professor Name</th>";
                } ?>
                <th>Lecture Day</th>
                <th>Lecture Start Time</th>
                <th>Lecture End Time</th>
            </tr>
            <?php while ($row = pg_fetch_row($result)) {
                echo "<tr>";
                    echo "<td> $row[0]</td>";
                    echo "<td> $row[1]</td>";
                    echo "<td> $row[2]</td>";
                    echo "<td> $row[3]</td>";
                    echo "<td> $row[4]</td>";
                    if ($role == 'Student') {
                        echo "<td> $row[5]</td>";
                    }
                    if ($role == 'Professor') {
                        echo "<td><a class='btn btn-primary btn-sm' href='editCourse.php' role='button'>Edit</a></td>";
                    }
                echo "<tr>";
            }
            ?>
        </table>
    </body>
</html>
<?php
}
?>
