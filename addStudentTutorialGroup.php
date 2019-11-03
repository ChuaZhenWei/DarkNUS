<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
} else {

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
                            <h4>Add student to "Tutorial Group Name"</h4>
                        </div>                       
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="font-weight-light">"Number of students:"</p>
                        </div>
                    </div>
                </div>
                <form action="viewTutorialGroup.php" method="get">
                <div class="card-body"> 
                    <table width="700" border="0" cellpadding="1" cellspacing="1">
                        <tr>
                            <th></th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Faculty</th>
                            <th>Email</th>
                        </tr>
                        <tr>
                            <td><input type="radio" value=""></td>
                            <td>S12345678</td>
                            <td>Ryan</td>
                            <td>Engineering</td>
                            <td>ryan@u.nus.edu</td>
                        <tr>
                    </table>
                    <hr>
                    <p><input type="submit" value="Add Student"></p>
                </div>
                </form>
            </div>
    </body>
</html> 
<?php
}
?>