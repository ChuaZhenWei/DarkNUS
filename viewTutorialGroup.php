<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
} else {
    $id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];
    $theRow = $_GET['row'];

    if ($role == 'Student') {
        header('location:tutorialGroup.php');
    }
    
    $tutorial = "SELECT ROW_NUMBER() OVER (ORDER BY NULL) AS num, T.courseName, T.acadYear, T.sem, TG.tutID, 
        TG.tutDay, TG.startTime, TG.endTime, S.name, S.email
        FROM Teaches T INNER JOIN Tutorial_Groups TG ON 
        T.profID = TG.profID AND T.courseName = TG.courseName
        AND T.acadYear = TG.acadYear AND T.sem = TG.sem
        INNER JOIN Teaching_Assistants TA ON T.courseName = TA.courseName AND T.acadYear = TA.acadYear 
        AND T.sem = TA.sem AND TG.tutID = TA.tutID NATURAL JOIN Students S
        WHERE T.profID = '$id'";
    
    $result = pg_query($tutorial);
    $tutorial_details = pg_fetch_row($result, $theRow-1);
    $courseName = $tutorial_details[1];
    $acadYear = $tutorial_details[2];
    $sem = $tutorial_details[3];
    $tutID = $tutorial_details[4];
    
    $students = "SELECT studID, name, faculty, email
        FROM Belongs B NATURAL JOIN Students S
        WHERE courseName = '$courseName' AND acadYear = $acadYear
        AND sem = $sem AND tutID = $tutID";
    
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
    </head>
    <body>
        <h2>Tutorial Group</h2>
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
                            echo "<a class='btn btn-primary' href='addStudentTutorialGroup.php?cname=$courseName&amp;ay=$acadYear&amp;sem=$sem&amp;tutid=$tutID&amp;count=$noOfStudents&amp;row=$theRow'
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
                    <table width="700" border="0" cellpadding="1" cellspacing="1">
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Faculty</th>
                            <th>Email</th>
                        </tr>
                        <?php
                        while ($row = pg_fetch_row($results)) {
                            echo "<tr>";
                            echo "<td>$row[0]</td>";
                            echo "<td>$row[1]</td>";
                            echo "<td>$row[2]</td>";
                            echo "<td>$row[3]</td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
    </body>
</html> 
<?php
}
?>