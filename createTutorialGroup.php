<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
} else {
    $id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];
    $acadYear = $_SESSION['acadYear'];
    $semester = $_SESSION['sem'];
    
    if ($role == 'Student') {
        header('location:tutorialGroup.php');
    }
    
    $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
    
    $courseName = "SELECT DISTINCT courseName FROM Teaches T WHERE T.profID = '$id'";
    $courses = pg_query($courseName);
    
    $name = "SELECT studID, name FROM Students";
    $names = pg_query($name);
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
                            <label class="control-label col-sm-2" for="courseName">Course Name:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="courseName" required>
                                    <?php
                                    while ($course = pg_fetch_row($courses)) {
                                        echo "<option value='$course[0]'>$course[0]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="tutID">Tutorial ID:</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="tutID" type="text" placeholder="1" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="headcount">Max Headcount:</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="headcount" type="text" placeholder="5" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="selectedDay">Tutorial Day:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="selectedDay" required>
                                    <?php
                                    foreach ($days as $day) {
                                        echo "<option value='$day'>$day</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="startTime">Start Time:</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="time" name="startTime" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="endTime">End Time:</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="time" name="endTime" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="selectedTA">Teaching Assistant (Optional):</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="selectedTA">
                                    <option value=''>Select Teaching Assistant</option>
                                    <?php
                                    while ($name = pg_fetch_row($names)) {
                                        echo "<option value='$name[0]'>$name[1] ($name[0])</option>";
                                    }
                                    ?>
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