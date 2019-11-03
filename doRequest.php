<?php
session_start();

include ('dbFunction.php');

if (!isset($_SESSION['user_id'])){
    header('location:login.php');
} else {
    if (isset($_POST['requestChoice'])){
        $id = $_SESSION['user_id'];
        $requestChoice = $_POST['requestChoice'];
        $decision = $_POST['Action'];
        
        $query = "SELECT *
            FROM request_list
            WHERE profid = '$id'
            AND no = '$requestChoice'";
        
        $result = pg_query($query);
        
        if (pg_num_rows($result) == 1) {
            $row=pg_fetch_array($result);
            
            if ($decision == 'Accept') {
                $insert = "INSERT INTO ENROLLS (studid, coursename, acadyear, sem)
                    VALUES ('$row[1]', '$row[3]', '$row[4]', '$row[5]')";
              
                pg_query($insert);
            }
            
            $delete = "DELETE FROM REQUESTS
                    WHERE studid = '$row[1]'
                    AND profid = '$row[2]'
                    AND coursename = '$row[3]'
                    AND acadyear = '$row[4]'
                    AND sem = '$row[5]'";
            
            pg_query($delete);
            
            header('location:requests.php');
        }
    }
}
pg_close();
?>

