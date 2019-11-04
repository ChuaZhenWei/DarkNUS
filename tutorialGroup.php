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
        $tutorial = "SELECT ROW_NUMBER() OVER (ORDER BY NULL) AS num, B.courseName, 
            B.tutID, TG.tutDay, TG.startTime, TG.endTime, S.name, S.email 
            FROM Belongs B NATURAL JOIN Tutorial_Groups TG INNER JOIN Teaching_Assistants TA 
            ON TG.courseName = TA.courseName AND TG.acadYear = TA.acadYear 
            AND TG.sem = TA.sem AND TG.tutID = TA.tutID INNER JOIN Students S ON TA.studID = S.studID
            WHERE B.studID =  '$id' AND B.acadYear = $acadYear AND B.sem = $semester";

    } else if ($role == 'Professor') {
        $tutorial = "SELECT ROW_NUMBER() OVER (ORDER BY NULL) AS num, T.courseName, TG.tutID, 
            TG.tutDay, TG.startTime, TG.endTime, S.name, S.email
            FROM Teaches T INNER JOIN Tutorial_Groups TG ON 
            T.profID = TG.profID AND T.courseName = TG.courseName
            AND T.acadYear = TG.acadYear AND T.sem = TG.sem
            INNER JOIN Teaching_Assistants TA ON T.courseName = TA.courseName AND T.acadYear = TA.acadYear 
            AND T.sem = TA.sem AND TG.tutID = TA.tutID NATURAL JOIN Students S
            WHERE T.profID = '$id' AND T.acadYear = $acadYear AND T.sem = $semester"; 
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
                    <th>Tutorial ID</th>
                    <th>Tutorial Day</th>
                    <th>Tutorial Start Time</th>
                    <th>Tutorial End Time</th>
                    <th>Teaching Assistant</th>
                    <th>Teaching Assistant's Email</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                while($row = pg_fetch_row($results)) {
                    echo "<tr>";
                    echo "<td>$row[1]</td>";
                    echo "<td>$row[2]</td>";
                    echo "<td>$row[3]</td>";
                    echo "<td>$row[4]</td>";
                    echo "<td>$row[5]</td>";
                    echo "<td>$row[6]</td>";
                    echo "<td>$row[7]</td>";
                    if ($role == 'Professor') {
                        echo "<td><a class='btn btn-primary btn-sm' href='viewTutorialGroup.php?theRow=$row[0]' role='button'>View</a></td>";
                        echo "<td><a class='btn btn-primary btn-sm' href='editTutorialGroup.php' role='button'>Edit</a></td>";
                    }
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