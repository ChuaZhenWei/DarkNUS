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
    </head>
    <body>
        <h2>Tutorial Group</h2>
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
                    <table width="700" border="0" cellpadding="1" cellspacing="1">
                        <tr>
                            <th></th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Faculty</th>
                            <th>Email</th>
                        </tr>
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
                    </table>
                    <hr>
                    <p><input type="submit" name="Action" value="Add Student"></p>
                </div>
                </form>
            </div>
    </body>
</html> 
<?php
}
?>