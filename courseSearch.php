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
        if(isset($_POST['courseName']))
        {  
            $word = $_POST['courseName'];
            $query = "SELECT * FROM Courses WHERE upper(courseName) LIKE upper('%$word%')";
            $course = $query;
        }       
        $results = pg_query($course);
    }
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
                Find a Course
            </h4>
            <br>
            <nav class="navbar">
                <form class="form-inline my-2 my-sm-0" method="post" action="">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search Course" aria-label="Search" name="courseName" required>
                    <button name="searchCourse" class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </nav>
            <div class="card-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>
                                Course Title
                            </th>
                            <th>
                                Faculty
                            </th>
                        </tr>
                        <?php
                        if(isset($_POST['courseName']))
                        {
                            while ($row = pg_fetch_row($results)) {
                                echo "<tr>";
                                    echo "<td>";
                                    echo "$row[0]";
                                    echo "</td>";
                                    echo "<td>";
                                    echo "$row[2]";
                                    echo "</td>";
                                echo "</tr>";
                            }
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