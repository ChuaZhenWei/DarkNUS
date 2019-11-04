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

    if ($role == 'Professor') {
        $request = "SELECT ROW_NUMBER() OVER (ORDER BY NULL) AS No, *
                FROM (SELECT R.studid, R.profid, R.coursename, R.acadyear, R.sem, S.name, S.email, S.faculty
                FROM REQUESTS R
                NATURAL JOIN STUDENTS S
                WHERE profid = '$id'
                AND acadyear = '$acadYear'
                AND sem = '$sem') AS foo"; 
    } 

    $results = pg_query($request);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>Enroll Request List</h2>
        <form action = "doRequest.php" method ="post">
            <table width="1500" border="0" cellpadding="1" cellspacing="1">
                <col width = "80">
                <col width = "500">
                <col width = "200">
                <col width = "200">
                <col width = "200">
                <col width = "200">
                <col width = "200">
                <tr>
                    <th>Select</th>
                    <th>Course Name</th>
                    <th>Academic Year</th>
                    <th>Semester</th>
                    <th>Student Name</th>
                    <th>Student Email</th>
                    <th>Student Faculty</th>
                </tr>
                <?php while ($row = pg_fetch_row($results)) { 
                    echo "<tr>"; ?>
                <td><input type = 'radio' name = 'requestChoice' value = '<?php echo $row[0] ?>'></td>
                        <?php
                        echo "<td>$row[3]</td>";
                        echo "<td>$row[4]</td>";
                        echo "<td>$row[5]</td>";
                        echo "<td>$row[6]</td>";
                        echo "<td>$row[7]</td>";
                        echo "<td>$row[8]</td>";
                    echo "<tr>";
                } 
                ?>
            </table>
            <br />
            <br />
            <input type="Submit" name ="Action" value="Accept">
            <input type="Submit" name ="Action" value="Reject">
            <br />
            <?php
            if (isset($_SESSION['Adding'])) {
                $message = $_SESSION['Adding'];
                echo "$message";
                unset($_SESSION['Adding']);
            }
            ?>
        </form>  
    </body>
</html>
<?php
}
pg_close($link);
?>