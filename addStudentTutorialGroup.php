<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
} else {

    $id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];
    
    if ($role == 'Student') {
        header('location:tutorialGroup.php');
    }
    
    $courseName = $_GET['cname'];
    $acadYear = $_GET['ay'];
    $semester = $_GET['sem'];
    $tutID = $_GET['tutid'];
    $count = $_GET['count'];
    $theRow = $_GET['row'];

    $query = "SELECT ROW_NUMBER() OVER (ORDER BY NULL) AS num, studID, name, faculty, email
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
                <form action="viewTutorialGroup.php?" method="get">
                <input type="hidden" value="<?php echo $theRow ?>" name="row">
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
                            echo "<td>$row[1]</td>";
                            echo "<td>$row[2]</td>";
                            echo "<td>$row[3]</td>";
                            echo "<td>$row[4]</td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                    <hr>
                    <p><input type="submit" value="Add Student"></p>
                </div>
                </form>
            </div>
    </body>
</html> 
<?php
}
?>