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
        <h2>Threads</h2>
            <div class="card">
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="forum.php">Forum</a></li>
                    <li class="breadcrumb-item active" aria-current="page">"Forum Name"</li>                    
                </ol>
                </nav>
                <nav class="navbar">
                    <a class="btn btn-primary" href="createThread.php" role="button">Create New Thread</a>
                    <form class="form-inline">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search Threads" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </nav>
                <div class="card-body">
                    <table cellspacing="1000">
                        <tbody>
                            <tr>
                                <td>
                                    <h4><a href="post.php">Thread Title #1</a></h4>
                                    <p>Name of the thread creator</p>
                                </td>
                                <td>
                                    <p>Number of replies</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4><a href="post.php">Thread Title #2</a></h4>
                                    <p>Name of the thread creator</p>
                                </td>
                                <td>
                                    <p>Number of replies</p>
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