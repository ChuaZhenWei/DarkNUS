<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    
} else if ($_SESSION['user_role']!='Professor') {
    header('location:index.php');
    
} else if (!isset($_POST['selected']) || $_POST['selected']=='') {
    header('location:createForumMod.php');
    
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
        </head>
        <body>
            <h2>Threads</h2>
                <div class="card">
                    <div class="card-body">                   
                        <h4>Create Forum</h4>
                        <hr>
                        <label class="control-label col-sm-2" for="cName">Course Name: <b><?php echo $courseName ?></b></label>
                        <form class="form-horizontal" method="post" action="doCreateForum.php">
                            <input type="hidden" value="<?php echo $courseName ?>" name="courseName">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="forumName">Forum Name:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="forumName" type="text" placeholder="Forum Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="tutID">Tutorial ID:</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="tutid">
                                        <option value=""></option>
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
                                    <textarea class="form-control" name="forumdesc" placeholder="Forum Description" rows="3"></textarea>
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