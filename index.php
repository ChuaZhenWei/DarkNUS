<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

$id = $_SESSION['user_id'];
$role = $_SESSION['user_role'];

if ($role == 'Student') {
    $query = "SELECT *
        FROM enrolls
        WHERE studid = '$id';";
} elseif ($role == 'Professor') {
    $query = "SELECT *
        FROM teaches
        WHERE profif = '$id'";
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>MODULES</h2>
        <?php
        echo "Test";
        ?>
    </body>
</html>
