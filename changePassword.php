<?php
session_start();

include ("navBar.php");
if (!isset($_SESSION['user_id'])){
    echo "You are not logged in. Please <a href='login.php'>login here</a>";
}
else{ ?>

<html>
    <head>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- jQuery library -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        
        <script type="text/javascript">
            var RE_OP=/^\w+$/;
            var RE_NP=/^\w{8,30}$/;
            
            function validate(form){
                var op=form.opass.value;
                var np=form.npass.value;
                var cnp=form.cnpass.value;
                
                var errors=[];
                
                if (!RE_OP.test(op)){
                    errors[errors.length]="Old password must be fielded up";
                }
                if (!RE_NP.test(np)){
                    errors[errors.length]="Password must be 8 to 30 characters";
                }
                if (cnp!==np){
                    errors[errors.length]="New password and confirm new password does not match";
                }
                if (errors.length>0){
                    reportErrors(errors);
                    errors=[];
                    
                    return false;
                }
                
                return true;
                
                function reportErrors(errors){
                    var msg="There were some problem";
                    for (var i=0;i<errors.length;i++){
                        var num=i+1;
                        msg+="\n"+num+": "+errors[i];
                    }
                    alert(msg);
                }
            }   
        </script>
    </head>
    <body>
        <div class="card">
            <h4 class="card-header">
                Change Password
            </h4>
            <form method="post" action="doChangePassword.php" onSubmit="return validate(this);">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"><b>Old Password:</b></label>
                        <div class="col-sm-2">
                            <input type="password" required="required" class="form-control" placeholder="Your old password" name="opass"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"><b>New Password:</b></label>
                        <div class="col-sm-2">
                            <input type="password" required="required" class="form-control" placeholder="Your new password" name="npass" pattern=".{8,}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"><b>Confirm New Password:</b></label>
                        <div class="col-sm-2">
                            <input type="password" required="required" class="form-control" placeholder="Confirm new password" name="cnpass" pattern=".{8,}"/>
                            <input type="hidden" name="id" value="<?php echo $_SESSION['user_id'] ?>">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary">Update Password</button>
                </div>
            </form>
        </div>
    </body>
</html>
<?php }