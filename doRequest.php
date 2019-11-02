<?php
session_start();

include ('dbFunction.php');

if (!isset($_SESSION['user_id'])){
    header('location:index.php');
} else {
    if (isset($_POST['requestChoice'])){
        $id = $_SESSION['user_id'];
        $requestChoice = $_POST['requestChoice'];
        echo "TEST $id and $requestChoice<br />";
        
        $query = "SELECT *
            FROM request_list
            WHERE profid = '$id'
            AND no = '$requestChoice'";
        
        $result = pg_query($query);
        
        if (pg_num_rows($result) == 1) {
            $row=pg_fetch_array($result);
            
            $insertEnroll = "INSERT INTO ENROLLS (studid, coursename, acadyear, sem)
                VALUES ('$row[1]', '$row[3]', '$row[4]', '$row[5]')";
            
            pg_query($insertEnroll);
            
            header('location:requests.php');
        }
    }
}
pg_close();
?>

