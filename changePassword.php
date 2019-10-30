<?php
session_start();

include ("navBar.php");
if (!isset($_SESSION['user_id'])){
    echo "You are not logged in. Please <a href='login.php'>login here</a>";
}
else{ ?>

<html>
    <head>
        <link href="style.css" rel="stylesheet" type="text/css">
        
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
        <h2>Change Password</h2>
        <form method="post" action="doChangePassword.php" onSubmit="return validate(this);">
            <table class="formLayout">
                <tr>
                    <td>Old Password: </td>
                    <td><input type="password" name="opass"></td>
                </tr>
                <tr>
                    <td>New Password: </td>
                    <td><input type="password" name="npass"></td>
                </tr>
                <tr>
                    <td>Confirm New Password: </td>
                    <td>
                        <input type="password" name="cnpass">
                        <input type="hidden" name="id" value="<?php echo $_SESSION['user_id'] ?>"
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Change"></td>
                </tr>
            </table>
        </form>
    </body>
</html>
<?php }