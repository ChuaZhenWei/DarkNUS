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
        </head>
        <body>
            <h2>Threads</h2>
                <div class="card">
                    <div class="card-body">                   
                        <h4>Create Forum</h4>
                        <hr>
                        <form class="form-horizontal" method="post" action="createForumTutId.php">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="courseName">Choose Course:</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="selected">
                                        <option name='coursename' value=''></option>
                                        <?php
                                        while ($row = pg_fetch_row($result)) {
                                            echo "<option name='coursename' value='$row[0]'>$row[0]</option>";
                                        }
                                        ?>
                                        
                                    </select>
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