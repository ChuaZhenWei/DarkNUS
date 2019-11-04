<?php
session_start();

include ('dbFunction.php');

if (!isset($_SESSION['user_id'])){
    header('location:index.php');
} else {
    $theRow = $_POST['theRow'];
    if (isset($_POST['selectedStudent'])) {
        $id = $_SESSION['user_id'];
        $acadYear = $_SESSION['acadYear'];
        $semester = $_SESSION['sem'];
        
        $selected = $_POST['selectedStudent'];
        $courseName = $_POST['courseName'];
        $tutID = $_POST['tutID'];
        
        $insert = "INSERT INTO Belongs (studID, courseName, acadYear, sem, tutID)
            VALUES ('$selected', '$courseName', $acadYear, $semester, $tutID)";
          
        $query = pg_query($link, $insert);
        $message = pg_last_notice($link);
        if ($message) {
            $_SESSION['error'] = $message;
        }
       
    }
    header("location:viewTutorialGroup.php?theRow=$theRow");
}
pg_close();
?>

