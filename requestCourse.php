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
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- jQuery library -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="card">
            <div class="card-header">
                <h4>Request Course</h4>
            </div>
            <div class="card-body">
                <form action = "doRequestCourse.php" method ="post">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Select</th>
                            <th>Course Name</th>
                            <th>Faculty</th>
                            <th>Professor Name</th>
                            <th>Lecture Day</th>
                            <th>Lecture Start Time</th>
                            <th>Lecture End Time</th>
                        </tr>
                        </thead>
                        <tbody>
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
                        </tbody>
                    </table>
                    <input type = "Submit" name = "Action" value = "Enroll Course" class="btn btn-primary">
                </form>
            </div>
        </div>
    </body>
</html> 
<?php
}
?>