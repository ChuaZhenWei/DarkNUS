<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
} else {
    $id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>Add Course</h2>
            <div class="card">
                <div class="card-body">                   
                    <h4>Add Course</h4>
                    <hr>
                    <form class="form-horizontal" method="post" action="index.php">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="courseName">Course Name:</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="coursename" type="text" placeholder="Course Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="faculty">Faculty:</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="faculty" type="text" placeholder="Faculty" required>
                            </div>
                        </div>
                        <form class="form-horizontal" method="post" action="tutorialGroup.php">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="lectureday">Lecture Day:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="selected" required>
                                    <option value="lectureday">Lecture Day</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="starttime">Lecture Start Time:</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="time" name="starttime" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="endtime">Lecture End Time:</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="time" name="endtime" required>
                            </div>
                        </div>
                        <input type="submit" name="Action" value="Add Course">
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