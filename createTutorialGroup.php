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
    $sem = $_SESSION['sem'];
    
    if ($role == 'Student') {
        header('location:tutorialGroup.php');
    }
    
    $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
    
    $courseName = "SELECT DISTINCT courseName FROM Teaches T WHERE T.profID = '$id' AND acadyear = $acadYear AND sem = $sem";
    $courses = pg_query($courseName);
    
    $name = "SELECT studID, name FROM Students";
    $names = pg_query($name);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- jQuery library -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="card">
            <h4 class="card-header">
                Create Tutorial Group
            </h4>
            <div class="card-body">
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
                            <input class="form-control" name="tutID" type="text" placeholder="E.g. 1" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="headcount">Max Headcount:</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="headcount" type="text" placeholder="E.g. 5" required>
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
                    <div class="col-sm-10">
                        <input type="submit" name="Action" value="Create Tutorial Group" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html> 
<?php
}
?>