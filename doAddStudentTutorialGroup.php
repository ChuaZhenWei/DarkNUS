<?php
session_start();

include ('dbFunction.php');

if (!isset($_SESSION['user_id'])){
    header('location:index.php');
} else {
    if (isset($_POST['selectedStudent'])) {
        $id = $_SESSION['user_id'];
        $acadYear = $_SESSION['acadYear'];
        $semester = $_SESSION['sem'];
        
        $selected = $_POST['selectedStudent'];
        $theRow = $_POST['theRow'];
        $studID = $_POST['studID'];
        $courseName = $_POST['courseName'];
        $tutID = $_POST['tutID'];
        
        $insert = "INSERT INTO Belongs (studID, courseName, acadYear, sem, tutID)
            VALUES ('$studID', '$courseName', $acadYear, $semester, $tutID)";
          
        pg_query($insert);
        echo $insert;
        
        header("location:viewTutorialGroup.php?theRow=$theRow");
    }
}
pg_close();
?>

