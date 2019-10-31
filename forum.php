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
        <h2>Forum</h2>
            <div class="card">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Forum</li>
                    </ol>
                </nav>
                <div class="card-body">
                    <table cellspacing="1000">
                        <tbody>
                            <tr>
                                <td>
                                    <h4><a href="thread.php">Forum Name #1</a></h4>
                                    <p>Course Name</p>
                                </td>
                                <td>
                                    <p>Number of discussion threads</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4><a href="thread.php">Forum Name #2</a></h4>
                                    <p>Course Name</p>
                                </td>
                                <td>
                                    <p>Number of discussion threads</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
    </body>
</html> 
<?php
}
?>