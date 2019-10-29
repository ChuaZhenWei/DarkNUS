<?php
session_start();

include ('navBar.php');

if (!isset($_SESSION['user_id'])){
?>

<html>
    <head>
        <link href="stylesheet/style.css" rel="stylesheet" type="text/css">
        <!-- CSS for Styling -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <!-- JavaScript for Interactivity -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    </head>
    <body style="background-color: rgb(27, 27, 27);">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card card-signin my-5">
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