<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
} else {
    $theRow = $_POST['theRow'];
    
    if (isset($_POST['studID'])) {
        $id = $_SESSION['user_id'];
        $role = $_SESSION['user_role'];
        $acadYear = $_SESSION['acadYear'];
        $semester = $_SESSION['sem'];

        if ($role == 'Student') {
            header('location:tutorialGroup.php');
        }

        $selected = $_POST['studID'];
        $courseName = $_POST['courseName'];
        $tutID = $_POST['tutID'];
        
        $delete = "DELETE FROM Belongs WHERE studID = '$selected' AND 
                courseName = '$courseName' AND acadYear = $acadYear AND sem = $semester
                AND tutID = $tutID";
        
        pg_query($delete);
    }

    header("location:viewTutorialGroup.php?theRow=$theRow");
}
pg_close();
?>
