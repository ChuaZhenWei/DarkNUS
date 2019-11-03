<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) { ?>
    <h2>Access Denied. User Not Logged In</h2>
<?php } else {
    $id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>Threads</h2>
            <div class="card">
                <div class="card-body">                   
                    <h4>Create Forum</h4>
                    <hr>
                    <form class="form-horizontal" method="post" action="doCreateForum.php">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="courseName">Course:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="selected">
                                    <option value="coursename">Course Name</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="forumName">Forum Name:</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="forum_name" type="text" placeholder="Forum Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="tutID">Tutorial ID:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="selected">
                                    <option value="tutorialID">Tutorial ID</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="tutID">Forum Description:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="forumdescription" placeholder="Forum Description" rows="3"></textarea>
                            </div>
                        </div>
                        <input type="submit" name="Action" value="Create Forum">
                    </form>

                    <hr>
                    <br>
                </div>
            </div>
    </body>
</html> 
<?php
}
?>