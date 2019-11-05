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
    $theRow = $_GET['theRow'];

    if ($role == 'Student') {
        header('location:tutorialGroup.php');
    }
    
    $tutorial = "SELECT ROW_NUMBER() OVER (ORDER BY NULL) AS num, T.courseName, TG.tutID, 
            TG.tutDay, TG.startTime, TG.endTime, TG.maxHeadcount
            FROM Teaches T INNER JOIN Tutorial_Groups TG ON 
            T.profID = TG.profID AND T.courseName = TG.courseName
            AND T.acadYear = TG.acadYear AND T.sem = TG.sem
            WHERE T.profID = '$id' AND T.acadYear = $acadYear AND T.sem = $semester";
    
    $result = pg_query($tutorial);
    $tutorial_details = pg_fetch_row($result, $theRow-1);
    $courseName = $tutorial_details[1];
    $tutID = $tutorial_details[2];
    
    $students = "SELECT studID, name, faculty, email
        FROM Belongs B NATURAL JOIN Students S
        WHERE courseName = '$courseName' AND acadYear = $acadYear
        AND sem = $semester AND tutID = $tutID";
    
    $results = pg_query($students);
    
    $currentCount = "SELECT COUNT (*)
        FROM ($students) AS students";
    
    $count = pg_query($currentCount);
    $noOfStudents = pg_fetch_result($count, 0);
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
                        <?php
                        echo "<h4>Tutorial Group $tutID</h4>";
                        ?>
                    </div>
                    <div class="col">
                        <?php
                        echo "<a class='btn btn-primary' href='addStudentTutorialGroup.php?cname=$courseName&amp;tutid=$tutID&amp;count=$noOfStudents&amp;row=$theRow'
                                role='button' style='float: right;'>Add Student</a>";
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="font-weight-light">
                        <?php
                        echo "Number of students: $noOfStudents";
                        ?></p>
                    </div>
                </div>
            </div>
            <div class="card-body"> 
                <?php echo "<form action='deleteStudentTutorialGroup.php' method='post'>"; ?>
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
                    while ($row = pg_fetch_row($results)) {
                        echo "<tr>";
                        echo "<td><input type='radio' name='studID' value='$row[0]'></td>";
                        echo "<td>$row[0]</td>";
                        echo "<td>$row[1]</td>";
                        echo "<td>$row[2]</td>";
                        echo "<td>$row[3]</td>";
                        echo "</tr>";
                        echo "<input type='hidden' value=$theRow name='theRow'>";
                        echo "<input type='hidden' value='$courseName' name='courseName'>";
                        echo "<input type='hidden' value=$tutID name='tutID'>";
                    }

                    if (isset($_SESSION['error'])) {
                        $message = $_SESSION['error'];
                        echo "<script type='text/javascript'>alert('$message');</script>";
                        unset($_SESSION['error']);
                    }
                    ?>
                    </tbody>
                </table>
                <input type="submit" name="Action" value="Remove Student" class="btn btn-danger">
                <?php echo "</form>"; ?>
            </div>
        </div>
    </body>
</html> 
<?php
}
?>