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
    
    $getCourse = "SELECT DISTINCT T.coursename 
            FROM teaches T
            INNER JOIN tutorial_groups TG ON T.coursename = TG.coursename AND T.acadyear = TG.acadyear AND T.sem = TG.sem AND T.profid = TG.profid
            WHERE T.profid = '$id' 
            AND T.acadyear = '$acadYear'
            AND T.sem = '$sem'";
    
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
                    <form class="form-horizontal" method="post" action="createForumTutId.php">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="courseName">Choose Course:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="selected" required>
                                    <option name='coursename' value=''>Select a course</option>
                                    <?php
                                    while ($row = pg_fetch_row($result)) {
                                        echo "<option name='coursename' value='$row[0]'>$row[0]</option>";
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="col-sm-10">
                            <input type="submit" name="Action" value="Next" class="btn btn-primary">
                        </div>
                    </form>
                    <?php 
                    if (isset($_SESSION['result'])) {
                        echo $_SESSION['result'];
                        unset($_SESSION['result']);
                    }
                    ?>
                </div>
            </div>
        </body>
    </html> 
    <?php
}
?>