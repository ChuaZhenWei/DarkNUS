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

    if ($role == 'Professor') {
        $request = "SELECT courseName, acadYear, sem, name, email, faculty
            FROM Requests NATURAL JOIN Students
            WHERE profID = '$id'"; 
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
        <table width="1500" border="0" cellpadding="1" cellspacing="1">
            <col width = "500">
            <col width = "200">
            <col width = "200">
            <col width = "200">
            <col width = "200">
            <col width = "200">
            <tr>
                <th>Course Name</th>
                <th>Academic Year</th>
                <th>Semester</th>
                <th>Student Name</th>
                <th>Student Email</th>
                <th>Student Faculty</th>
            </tr>
            <?php while ($row = pg_fetch_row($results)) {
                echo "<tr>";
                    echo "<td> $row[0]</td>";
                    echo "<td> $row[1]</td>";
                    echo "<td> $row[2]</td>";
                    echo "<td> $row[3]</td>";
                    echo "<td> $row[4]</td>";
                    echo "<td> $row[5]</td>";
                echo "<tr>";
            }
            ?>
        </table>
    </body>
</html>
<?php
}
?>