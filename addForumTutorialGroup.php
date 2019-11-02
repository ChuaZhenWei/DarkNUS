<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) { ?>
    <h2>Access Denied. User Not Logged In</h2>
<?php } else {

$id = $_SESSION['user_id'];
$role = $_SESSION['user_role'];

if ($role == 'Student') {
    $query = "SELECT *
        FROM students
        WHERE studid = '$id'";
    
} elseif ($role == 'Professor') {
    $query = "SELECT *
        FROM teaches
        WHERE profid = '$id'";
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>Tutorial Group</h2>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4>Add tutorial group to "Forum Name/Thread Name?"</h4>
                        </div>                       
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="font-weight-light">"Number of tutorial groups:"</p>
                        </div>
                    </div>
                </div>
                <form action="thread.php" method="get">
                <div class="card-body"> 
                    <table width="700" border="0" cellpadding="1" cellspacing="1">
                        <tr>
                            <th></th>
                            <th>Tutorial Group</th>               
                        </tr>
                        <tr>
                            <td><input type="radio" value=""></td>
                            <td>Tutorial T1</td>
                        <tr>
                    </table>
                    <hr>
                    <p><input type="submit" value="Add Tutorial Group"></p>
                </div>
                </form>
            </div>
    </body>
</html> 
<?php
}
?>