<?php
session_start();

include ('navBar.php');

if (!isset($_SESSION['user_id'])){
?>

<html>
    <head>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- jQuery library -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body style="background-color: rgb(27, 27, 27);">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card card-signin my-5" style= "background-color: rgb(27, 27, 27);">
                        <div style= "background-color: rgb(27, 27, 27);" class="card-body">
                            <h1 class="card-title text-center"><span style="color: mintcream;">Dark</span><span style="color: darkorange;">NUS</span></h1>
                            <form method="post" action="doLogin.php">
                                <div class="form-group">
                                    <label style="color: mintcream;">User ID</label>
                                    <input type="text" class="form-control" placeholder="User ID" required="required" autofocus="autofocus" name="user" pattern="[A-Za-z][A-Za-z0-9_]{2,14}">
                                </div>
                                <div class="form-group">
                                    <label style="color: mintcream;">Password</label>
                                    <input type="password" class="form-control" placeholder="Password" required="required" name="pass">
                                </div>
                                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<?php }

else{
    echo "You are already logged in </br>
        <a href='index.php'>home</a></br>";
    echo $_SESSION['user_id']. " as " .$_SESSION['name']. " " .$_SESSION['user_role'];
}
?>