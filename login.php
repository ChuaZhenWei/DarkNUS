<?php
session_start();

include ('navBar.php');

if (!isset($_SESSION['user_id'])){
?>

<html>
    <head>
        <link href="stylesheet/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <h2><b>DarkNUS - Login</b></h2>
        <form method="post" action="doLogin.php">
            <table class="formLayout">
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="user"></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="pass"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: left"><input type="submit" value="Login"></td>
                </tr>
            </table>
        </form>
    </body>
</html>

<?php }

else{
    echo "You are already logged in </br>
        <a href='index.php'>home</a></br>";
    echo $_SESSION['user_id']. " as " .$_SESSION['name']. " " .$_SESSION['user_role'];
}
?>