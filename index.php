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
        T.lectureDay, T.startTime, T.endTime, T.maxHeadcount
        FROM Enrolls E
        INNER JOIN Teaches T ON E.courseName = T.courseName AND E.acadYear = T.acadYear AND E.sem = T.sem 
        INNER JOIN Professors P ON T.profID = P.profID 
        INNER JOIN Courses C ON E.courseName = C.courseName
        WHERE E.studid = '$id'
        AND E.acadyear = '$acadYear'
        AND E.sem = '$sem'";
    
} elseif ($role == 'Professor') {
    $course = "SELECT T.coursename, C.faculty, T.lectureday, T.starttime, T.endtime, T.maxHeadcount
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
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- jQuery library -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div class="card">
        <h5 class="card-header">
            Dashboard
        </h5>
            
            <div class="card-body">
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
                <br>
                <form action='doDeleteCourse.php' method='post'>
                    <table class="table">
                        <thead>
                        <tr>
                            <?php
                            if ($role == 'Professor') {
                                echo "<th></th>";
                            }
                            ?>
                            <th>Course Name</th>
                            <th>Faculty</th>
                            <?php
                            if ($role == 'Student') {
                                echo "<th>Professor Name</th>";
                            } ?>
                            <th>Lecture Day</th>
                            <th>Lecture Start Time</th>
                            <th>Lecture End Time</th>
                            <th>Max Headcount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($row = pg_fetch_row($result)) {
                            echo "<tr>";
                                if ($role == 'Professor') {
                                    echo "<td><input type = 'radio' name = 'delChoice' value = '$row[0]'></td>";
                                }
                                echo "<td> $row[0]</td>";
                                echo "<td> $row[1]</td>";
                                echo "<td> $row[2]</td>";
                                echo "<td> $row[3]</td>";
                                echo "<td> $row[4]</td>";
                                if ($role == 'Student') {
                                    echo "<td> $row[5]</td>";
                                    echo "<td> $row[6]</td>";
                                } else if ($role == 'Professor') {
                                    echo "<td> $row[5]</td>";
                                    //echo "<td><a class='btn btn-primary btn-sm' href='editCourse.php' role='button'>Edit</a></td>";
                                }

                            echo "<tr>";
                        }
                        ?>
                        </tbody>
                    </table>
            </div>
                <div class="card-footer">
                <nav class='navbar'>
                    <ul class='navbar-nav'>
                        <li class='nav-item'>
                            <button type="Submit" name ="Action" value="Delete" class="btn btn-danger">Delete Course</button>
                        </li>   
                    </ul>
                </nav>
                </form>
            </div>
        </div>
    </body>
</html>
<?php
}
?>
