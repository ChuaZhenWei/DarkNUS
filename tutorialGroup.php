<?php
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
?>

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
        $tutorial = "SELECT courseName, acadYear, sem, tutID, tutDay, startTime, endTime 
                FROM Belongs B NATURAL JOIN Tutorial_Groups TG
                WHERE studID = '$id'";

    } else if ($role == 'Professor') {
        $tutorial = "SELECT T.courseName, T.acadYear, T.sem, TG.tutID, TG.tutDay, TG.startTime, TG.endTime
                FROM Teaches T INNER JOIN Tutorial_Groups TG ON 
                T.profID = TG.profID AND T.courseName = TG.courseName
                AND T.acadYear = TG.acadYear AND T.sem = TG.sem
                WHERE T.profID = '$id'"; 
    } 

    $results = pg_query($tutorial);
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>Tutorial Group</h2>
        <div>
            <table width="700" border="0" cellpadding="1" cellspacing="1">
                <tr>
                    <th>Course Name</th>
                    <th>Academic Year</th>
                    <th>Semester</th>
                    <th>Tutorial ID</th>
                    <th>Tutorial Day</th>
                    <th>Tutorial Start Time</th>
                    <th>Tutorial End Time</th>
                    <th></th>
                </tr>
                <?php
                while($row = pg_fetch_row($results)) {
                    echo "<tr>";
                    echo "<td>$row[0]</td>";
                    echo "<td>$row[1]</td>";
                    echo "<td>$row[2]</td>";
                    echo "<td>$row[3]</td>";
                    echo "<td>$row[4]</td>";
                    echo "<td>$row[5]</td>";
                    echo "<td>$row[6]</td>";
                    echo "<td><a class='btn btn-primary btn-sm' href='viewTutorialGroup.php' role='button'>View</a></td>";
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