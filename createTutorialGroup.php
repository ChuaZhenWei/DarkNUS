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
        <h2>Create Tutorial Group</h2>
            <div class="card">
                <div class="card-body">                   
                    <h4>Create Tutorial Group</h4>
                    <hr>
                    <form class="form-horizontal" method="post" action="doCreateTutorialGroup.php">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="tutday">Tutorial Day:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="selected" required>
                                    <option value="tutday">Tutorial Day</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="tutday">Start Time:</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="time" name="starttime" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="tutday">End Time:</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="time" name="endtime" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="courseName">Teaching Assistant (Optional):</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="selected">
                                    <option value="" selected>Select Teaching Assistant</option>
                                    <option value="TAName">TA Name</option>
                                </select>
                            </div>
                        </div> 
                        <input type="submit" name="Action" value="Create Tutorial Group">
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