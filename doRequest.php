<?php
session_start();

include ('dbFunction.php');

if (!isset($_SESSION['user_id'])){
    header('location:login.php');
} else {
    if (isset($_POST['requestChoice'])){
        $id = $_SESSION['user_id'];
        $acadYear = $_SESSION['acadYear'];
        $sem = $_SESSION['sem'];
        $requestChoice = $_POST['requestChoice'];
        $decision = $_POST['Action'];
        
        $query = "SELECT R.studid, R.profid, R.coursename, R.acadyear, R.sem, S.name, S.email, S.faculty
                FROM REQUESTS R
                NATURAL JOIN STUDENTS S
                WHERE profid = '$id'
                AND acadyear = '$acadYear'
                AND sem = '$sem'";
        
        $result = pg_query($query);
        
        if (pg_num_rows($result) == 1) {
            $row= pg_fetch_row($result, $requestChoice-1);
            
            if ($decision == 'Accept') {
                $insert = "INSERT INTO ENROLLS (studid, coursename, acadyear, sem)
                    VALUES ('$row[0]', '$row[2]', '$row[3]', '$row[4]')";
              
                pg_query($insert);
            }
            
            $delete = "DELETE FROM REQUESTS
                    WHERE studid = '$row[0]'
                    AND profid = '$row[1]'
                    AND coursename = '$row[2]'
                    AND acadyear = '$row[3]'
                    AND sem = '$row[4]'";
            
            pg_query($delete);
            
            header('location:requests.php');
        }
    }
}
pg_close();
?>

