<?php
session_start();

if (!isset($_SESSION['user_id'])){
    echo "You are not logged in </br>
        click <a href='login.php'>here</a> to login";
}
else{
$opass=$_POST['opass'];
$npass=$_POST['npass'];
$id=$_POST['id'];

include ("dbFunction.php");
include ("navBar.php");

$option = ['cost' >= 10];
$npass = password_hash($npass, PASSWORD_BCRYPT, $option);

$query="SELECT *
    FROM users
    WHERE userid = '$id'";

$result = pg_query($query);
$row = pg_fetch_array($result);

if (password_verify($opass, $row['password'])){
    $cpass="UPDATE users
        SET password = '$npass'
        WHERE userid = '$id'";
    
    pg_query($cpass) or die ("Error changing password. Please try again");
    
    Echo "Password had been changed successfully.";
}
else{
    echo "Wrong password inputted. </br>
        Click <a href='changePassword.php'>back</a> to redo.";
}
}
pg_close($link);
?>