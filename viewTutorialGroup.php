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
                    <h4>"Tutorial Group Name"</h4>
                    <p class="font-weight-light">"Number of students"</p>
                </div>
                <div class="card-body">                   
                    <table width="700" border="0" cellpadding="1" cellspacing="1">
                        <tr>
                            <th>Name</th>
                        </tr>
                            <tr>
                                <td>Ryan</td>                       
                            <tr>
                    </table>
                </div>
            </div>
    </body>
</html> 
<?php
}
?>