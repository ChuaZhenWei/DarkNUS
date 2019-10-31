<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) { ?>
    <h2>Access Denied. User Not Logged In</h2>
<?php } else {

$id = $_SESSION['user_id'];
$role = $_SESSION['user_role'];
$acadYear = pg_query("SELECT acadyear FROM Semesters");
$sem = pg_query("SELECT sem FROM Semesters");

if ($role == 'Student') {
    $course = "SELECT T.courseName as CourseName, C.faculty as Faculty, P.name as ProfName "
            . "FROM Professors P NATURAL JOIN Teaches T INNER JOIN Courses C ON T.courseName = C.courseName "
            . "WHERE acadYear = '$acadYear' AND sem = '$sem'";
    
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
        <h2>Add Courses</h2>
        <div>
            <form method="POST" action="addCourse.php">
            <select>
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
                </tr>
                <?php
                if (is_array($results) && count($results)>0) {
                    foreach ($results as $result) {
                        echo "<tr>";
                        echo "<td>".$result['Column 1']."</td>";
                        echo "<td>".$result['Column 2']."</td>";
                        echo "<td>".$result['Column 3']."</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </table>
        </div>
    </body>
</html> 
<?php
}
?>