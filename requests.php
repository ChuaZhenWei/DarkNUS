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

    if ($role == 'Professor') {
        $request = "SELECT ROW_NUMBER() OVER (ORDER BY NULL) AS No, *
                FROM (SELECT R.studid, R.profid, R.coursename, R.acadyear, R.sem, S.name, S.email, S.faculty
                FROM REQUESTS R
                NATURAL JOIN STUDENTS S
                WHERE profid = '$id'
                AND acadyear = '$acadYear'
                AND sem = '$sem') AS foo"; 
    } 

    $results = pg_query($request);
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
                Enroll Request List
            </h4>
            <div class="card-body">
                <form action = "doRequest.php" method ="post">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Select</th>
                            <th>Course Name</th>
                            <th>Academic Year</th>
                            <th>Semester</th>
                            <th>Student Name</th>
                            <th>Student Email</th>
                            <th>Student Faculty</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($row = pg_fetch_row($results)) { 
                            echo "<tr>";
                                echo "<td><input type = 'radio' name = 'requestChoice' value = '$row[0]'></td>";
                                echo "<td>$row[3]</td>";
                                echo "<td>$row[4]</td>";
                                echo "<td>$row[5]</td>";
                                echo "<td>$row[6]</td>";
                                echo "<td>$row[7]</td>";
                                echo "<td>$row[8]</td>";
                            echo "<tr>";
                        } 
                        ?>
                        </tbody>
                    </table>
                    <br>
                    <input type="Submit" name ="Action" value="Accept" class="btn btn-primary">
                    <input type="Submit" name ="Action" value="Reject" class="btn btn-danger">
                    <?php
                    if (isset($_SESSION['Adding'])) {
                        $message = $_SESSION['Adding'];
                        echo "<div class='text-primary' style='padding-left: 15px; display:inline'>$message</div>";
                        unset($_SESSION['Adding']);
                    }
                    ?>
                </form>
            </div>
        </div>
    </body>
</html>
<?php
}
pg_close($link);
?>