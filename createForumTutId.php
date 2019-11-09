<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    
} else if ($_SESSION['user_role']!='Professor') {
    header('location:index.php');
    
} else {
    $id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];
    $acadYear = $_SESSION['acadYear'];
    $sem = $_SESSION['sem'];
    
    $courseName = $_POST['selected'];
    
    $getCourse = "SELECT DISTINCT TG.tutid
            FROM teaches T
            INNER JOIN tutorial_groups TG ON T.coursename = TG.coursename AND T.acadyear = TG.acadyear AND T.sem = TG.sem AND T.profid = TG.profid
            WHERE T.profid = '$id' 
            AND T.acadyear = '$acadYear'
            AND T.sem = '$sem'
            AND T.coursename = '$courseName'";
    
    $result = pg_query($getCourse);
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
                        Create Forum
                    </h4>
                    <div class="card-body">
                        <label class="control-label col-sm-5" for="cName">Course Name:<b style= "padding-left: 8px"><?php echo $courseName ?></b></label><br><br>
                        <form class="form-horizontal" method="post" action="doCreateForum.php">
                            <input type="hidden" value="<?php echo $courseName ?>" name="courseName">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="forumName">Forum Name:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="forumName" type="text" placeholder="Forum Name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="tutID">Tutorial ID:</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="tutid" required>
                                        <option value="">Select Tutorial ID</option>
                                        <?php
                                        while ($row = pg_fetch_row($result)) {
                                            echo "<option name='tutid' value='$row[0]'>$row[0]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="forumdesc">Forum Description:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="forumdesc" placeholder="Forum Description" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <input type="submit" name="Action" value="Create Forum" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
        </body>
    </html> 
    <?php
}
?>