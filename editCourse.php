<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id']))  {
    header('location:login.php');
}  else {
    $id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];
    $acadYear = $_SESSION['acadYear'];
    $sem = $_SESSION['sem'];
    $courseName = $_GET['cname'];
    
    if ($role == 'Student') {
        header('location:index.php');
    }
    
    $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
?>
<html>
    <head>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- jQuery library -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div class="card">
            <div class="card-body">                   
                <h4>Edit <?php echo $courseName; ?></h4>
                <hr>
                <form class="form-horizontal" method="post" action="doEditCourse.php">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="selectedDay">Lecture Day:</label>
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
                    <div class="col-sm-10">
                        <input type="submit" name="Action" value="Edit Course" class="btn btn-success">
                        <input type="hidden" value="<?php echo $courseName ?>" name="courseName">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html> 
<?php
}
?>