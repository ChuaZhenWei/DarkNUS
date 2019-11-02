<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
} else {

$id = $_SESSION['user_id'];
$role = $_SESSION['user_role'];
$acadYear = pg_query("SELECT acadyear FROM Semesters");
$sem = pg_query("SELECT sem FROM Semesters");

$selection = $_POST['selected'];
$academicYear = substr($selection, 0, 4);
$semester = substr($selection, 7, 1);

if ($role == 'Student') {
    $course = "SELECT T.courseName as CourseName, C.faculty as Faculty, P.name as ProfName, T.lectureDay, T.startTime, T.endTime
            FROM Professors P NATURAL JOIN Teaches T INNER JOIN Courses C ON T.courseName = C.courseName
            WHERE acadYear = '$academicYear' AND sem = '$semester'";
    
}

$results = pg_query($course)
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>Add Courses</h2>
        <div>
            <form method="POST" action="addCourse.php">
            <select name="selected">
            <?php
            while($acadyear = pg_fetch_row($acadYear) + $semester = pg_fetch_row($sem)){
                echo "<option value='$acadyear[0] + $semester[0]'>Academic Year $acadyear[0] Semester $semester[0]</option>";
            }            
            ?>
            </select>
            <input type="submit" value="Display">
            </form>
        </div>
        <div>
            <table width="600" border="0" cellpadding="1" cellspacing="1">
                <tr>
                    <th>Course Name</th>
                    <th>Faculty</th>
                    <th>Professor Name</th>
                    <th>Lecture Day</th>
                    <th>Lecture Start Time</th>
                    <th>Lecture End Time</th>
                </tr>
                <?php
                while($row = pg_fetch_row($results)) {
                    echo "<tr>";
                    echo "<td> $row[0]</td>";
                    echo "<td> $row[1]</td>";
                    echo "<td> $row[2]</td>";
                    echo "<td> $row[3]</td>";
                    echo "<td> $row[4]</td>";
                    echo "<td> $row[5]</td>";
                    echo "<tr>";
                }
                ?>
            </table>
        </div>
    </body>
</html> 
<?php
}
?>