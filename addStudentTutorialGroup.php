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
    $semester = $_SESSION['sem'];
    
    if ($role == 'Student') {
        header('location:tutorialGroup.php');
    }
    
    $courseName = $_GET['cname'];
    $tutID = $_GET['tutid'];
    $count = $_GET['count'];
    $theRow = $_GET['row'];

    $query = "SELECT studID, name, faculty, email, courseName
        FROM (
            SELECT studID, courseName, acadYear, sem
            FROM Enrolls E
            EXCEPT
            SELECT studID, courseName, acadYear, sem
            FROM Belongs B
        ) AS A NATURAL JOIN Students S
        WHERE courseName = '$courseName' AND acadYear = $acadYear
        AND sem = $semester";
    
    $result = pg_query($query);
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
                    <div class="row">
                        <div class="col">
                            <h4>Add student to Tutorial Group
                            <?php
                            echo $tutID;
                            ?></h4>
                        </div>                       
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="font-weight-light">Number of students:
                            <?php
                            echo "$count</p>";
                            ?>
                        </div>
                    </div>
                </div>
                <form action="doAddStudentTutorialGroup.php" method="post">
                <div class="card-body"> 
                    <table class="table">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Faculty</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = pg_fetch_row($result)) {
                            echo "<tr>";
                            echo "<td><input type='radio' name='selectedStudent' value='$row[0]''></td>";
                            echo "<td>$row[0]</td>";
                            echo "<td>$row[1]</td>";
                            echo "<td>$row[2]</td>";
                            echo "<td>$row[3]</td>";
                            echo "</tr>";
                            echo "<input type='hidden' value=$theRow name='theRow'>";
                            echo "<input type='hidden' value=$row[0] name='studID'>";
                            echo "<input type='hidden' value='$row[4]' name='courseName'>";
                            echo "<input type='hidden' value=$tutID name='tutID'>";
                        }
                        ?>
                        </tbody>
                    </table>
                    <hr>
                    <p><input type="submit" name="Action" value="Add Student" class="btn btn-success"></p>
                </div>
                </form>
            </div>
    </body>
</html> 
<?php
}
?>