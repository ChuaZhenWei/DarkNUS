<?php
session_start();

include ('dbFunction.php');
include ('navBar.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
} else {  
    $id = $_SESSION['user_id'];
    $role = $_SESSION['user_role'];
    
    if(isset($_POST['searchCourse'])){       
        if(isset($_POST['courseName']) && !empty($_POST['courseName']))
        {  
            $word = $_POST['courseName'];
            $query = "SELECT * FROM Courses WHERE lower(courseName) LIKE '%$word%'";
            $course = $query;
        }       
        $results = pg_query($course);
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>Threads</h2>
            <div class="card">
                <h5 class="card-header">
                    Find a Course
                </h5>
                <br>
                <nav class="navbar">
                    <form class="form-inline my-2 my-sm-0" method="post" action="">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search Course" aria-label="Search" name="courseName" required>
                        <button name="searchCourse" class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </nav>
                <div class="card-body">
                    <table cellspacing="1000">
                        <tbody>
                            <?php
                            while ($row = pg_fetch_row($results)) {
                                echo "<tr>";
                                    echo "<th>";
                                    echo "Course Title";
                                    echo "</th>";
                                    echo "<th>";
                                    echo "Faculty";
                                    echo "</th>";
                                echo "</tr>";
                                
                                echo "<tr>";
                                    echo "<td>";
                                    echo "$row[0]";
                                    echo "</td>";
                                    echo "<td>";
                                    echo "$row[2]";
                                    echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </body>
</html> 
<?php
}
?>