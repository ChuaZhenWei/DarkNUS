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
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>Add Course</h2>
            <div class="card">
                <div class="card-body">                   
                    <h4>Add Course</h4>
                    <hr>
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