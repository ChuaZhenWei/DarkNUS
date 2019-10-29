<html>
    <head>
        
    </head>
    <body>
        <?php if (!isset($_SESSION['user_role'])){ ?>
        <a href="index.php">Home</a> | <a href="login.php">Login</a>
        <?php } 
        else{
            $rol=$_SESSION['user_role'];
            $name=  ucfirst($_SESSION['name']);
            
            if ($_SESSION['user_role']=='Student'){ ?>
        <a href="index.php">Home</a> | <a href="changePassword.php">Change Password</a> | <a href="doLogout.php">Logout</a>
      <?php      }
         elseif($_SESSION['user_role']=='Professor'){ ?>
             <a href="index.php">Home</a> | <a href="showReport.php">Show Report</a> | <a href="changePassword.php">Change Password</a> | <a href="doLogout.php">Logout</a>
        <?php }
        echo "<b style='background-color:black; margin-left:50px'><font color='white'>$name ($rol)</font></b>"; 
        }
?>
        <hr>
    </body>
</html>