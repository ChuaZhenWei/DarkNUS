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
            B.tutID, TG.tutDay, TG.startTime, TG.endTime, TG.maxHeadcount
            FROM Belongs B NATURAL JOIN Tutorial_Groups TG
            WHERE B.studID =  '$id' AND B.acadYear = $acadYear AND B.sem = $semester";

    } else if ($role == 'Professor') {
        $tutorial = "SELECT ROW_NUMBER() OVER (ORDER BY NULL) AS num, T.courseName, TG.tutID, 
            TG.tutDay, TG.startTime, TG.endTime, TG.maxHeadcount
            FROM Teaches T INNER JOIN Tutorial_Groups TG ON 
            T.profID = TG.profID AND T.courseName = TG.courseName
            AND T.acadYear = TG.acadYear AND T.sem = TG.sem
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
        <?php
        if ($role == 'Professor') {
            echo "<a class='btn btn-primary' href='createTutorialGroup.php' role='button'>Create Tutorial Group</a>";
            if (isset($_SESSION['error'])) {
                $message = $_SESSION['error'];
                echo "<script type='text/javascript'>alert('$message');</script>";
                unset($_SESSION['error']);
            }
        }
        ?>
        <div>
            <table width="700" border="0" cellpadding="1" cellspacing="1">
                <tr>
                    <th>Course Name</th>
                    <th>Tutorial ID</th>
                    <th>Tutorial Day</th>
                    <th>Tutorial Start Time</th>
                    <th>Tutorial End Time</th>
                    <th>Max Headcount</th>
                    <th>Teaching Assistant</th>
                    <th>Teaching Assistant's Email</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                while($row = pg_fetch_row($results)) {
                    $teaching_assistant = "SELECT S.name, S.email FROM
                            Teaching_Assistants TA NATURAL JOIN Students S
                            WHERE TA.courseName = '$row[1]' AND TA.tutID = $row[2]
                            AND TA.acadYear = $acadYear AND TA.sem = $semester";
                    $ta = pg_query($teaching_assistant);
                    $taResult = pg_fetch_row($ta);
                    echo "<tr>";
                    echo "<td>$row[1]</td>";
                    echo "<td>$row[2]</td>";
                    echo "<td>$row[3]</td>";
                    echo "<td>$row[4]</td>";
                    echo "<td>$row[5]</td>";
                    echo "<td>$row[6]</td>"; 
                    if (pg_num_rows($ta) > 0) {                   
                        echo "<td>$taResult[0]</td>";
                        echo "<td>$taResult[1]</td>";
                    } else {
                        echo "<td></td>";
                        echo "<td></td>";
                    }
                    if ($role == 'Professor') {
                        echo "<td><a class='btn btn-primary btn-sm' href='viewTutorialGroup.php?theRow=$row[0]' role='button'>View</a></td>";
                        echo "<td><a class='btn btn-primary btn-sm' href='editTutorialGroup.php?coursename=$row[1]&amp;tutid=$row[2]' role='button'>Edit</a></td>";
                        echo "<td><a class='btn btn-primary btn-sm' href='deleteTutorialGroup.php?courseName=$row[1]&tutID=$row[2]' role='button'>Delete</a></td>";
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