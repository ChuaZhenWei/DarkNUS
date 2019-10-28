<?php
session_start();

include ('dbFunction.php');

if (!isset($_SESSION['user_id'])){
    if (isset($_POST['user'])){
        $user= $_POST['user'];
        $pass= htmlspecialchars($_POST['pass']);
        
        $query="SELECT *
            FROM users
            WHERE userid = '$user'";
        
        if (substr($user, 0, 1) == "P") {
            $getRole = "SELECT *
                FROM professors
                WHERE profid='$user'";
            
            $role = "Professor";
        } else if (substr($user, 0, 1) == "S") {
            $getRole = "SELECT *
                FROM students
                WHERE studid = '$user'";
            
            $role = "Student";
        }
        
        $result = pg_query($query);
        $userDetails = pg_query($getRole);
        
        if (pg_num_rows($result)==1){
            $row=pg_fetch_array($result);
            if (password_verify($pass, $row['password'])) {
                $row=pg_fetch_array($userDetails);
                $_SESSION['user_id']=$user;
                $_SESSION['user_role']=$role;
                $_SESSION['name']=$row['name'];
                header('location:index.php');
            } else {
                echo "Incorrect password </br>
                    <a href = 'login.php'>Back</a>";
            }
        }
        else{
            echo "Incorrect username </br>
                <a href = 'login.php'>Back</a>";
        }
    }
}
else{
    echo "You are already logged in </br>
        <a href='index.php'>Home</a>";
}
pg_close($link);
?>