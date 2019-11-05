<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
} else if($_SESSION['user_role'] != 'Professor') {
    header('location:index.php');
} else {
    $id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];
    $acadYear = $_SESSION['acadYear'];
    $sem = $_SESSION['sem'];
    
    $courses = "SELECT coursename
        FROM COURSES
        EXCEPT
        SELECT coursename
        FROM TEACHES
        WHERE profid = '$id'
        AND acadyear = '$acadYear'
        AND sem = '$sem'";
    
    $result = pg_query($courses);
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
            <div class="card">
            <h4 class="card-header">
                Add Course
            </h4>
            <div class="card-body">                   
                <form class="form-horizontal" method="post" action="doAddCourse.php">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="courseName">Course Name:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="coursename" required>
                                <option value=''>Select a course</option>
                                <?php while($row = pg_fetch_row($result)) {
                                    echo "<option value='$row[0]'>$row[0]</option>";
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="lectureDay">Lecture Day:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="lectureday" required>
                                <option value=''>Select a day</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
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
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="maxHeadCount">Max Head Count:</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="maxheadcount" type="text" placeholder="Max Head Count" required>
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <input type="submit" name="Action" value="Add Course" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html> 
<?php
}
?>