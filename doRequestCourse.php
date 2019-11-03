<?php
session_start();

include ('dbFunction.php');

if (!isset($_SESSION['user_id'])){
    header('location:login.php');
} else {
    if (isset($_POST['courseChoice'])){
        $id = $_SESSION['user_id'];
        $acadYear = $_SESSION['acadYear'];
        $sem = $_SESSION['sem'];
        
        $courseChoice = $_POST['courseChoice'];
        
        $query = "SELECT T.courseName as CourseName, C.faculty as Faculty, P.name as ProfName, P.profid, T.lectureDay, T.startTime, T.endTime
            FROM Professors P NATURAL JOIN Teaches T INNER JOIN Courses C ON T.courseName = C.courseName
            WHERE acadYear = '$acadYear' AND sem = '$sem'
            EXCEPT
            (SELECT T.courseName, C.faculty, P.name, P.profid, T.lectureDay, T.startTime, T.endTime
            FROM Enrolls E NATURAL JOIN Teaches T NATURAL JOIN Professors P INNER JOIN Courses C ON T.courseName = C.courseName
            WHERE E.studID = '$id'
            AND acadyear = '$acadYear'
            and sem = '$sem'
            UNION
            SELECT R.coursename, C.faculty, P.name, P.profid, T.lectureday, T.starttime, T.endtime
            FROM REQUESTS R
            NATURAL JOIN Teaches T
            NATURAL JOIN Professors P
            INNER JOIN Courses C ON R.coursename = C.coursename
            WHERE R.studID = '$id'
            AND acadyear = '$acadYear'
            and sem = '$sem')";
        
        $result = pg_query($query);
        if (pg_num_rows($result) > 0) {
            $row=pg_fetch_row($result, $courseChoice-1);
            
            $insert = "INSERT INTO REQUESTS (studid, profid, coursename, acadyear, sem)
                VALUES ('$id', '$row[3]', '$row[0]', '$acadYear', '$sem')";
                
            pg_query($insert);
            
            header('location:requestCourse.php');
        }
    }
}
pg_close();
?>

