<!DOCTYPE html>
<html>
<head>
<title>Create a password</title>
<link rel="stylesheet" href="scripts/loginsheet.css" />
<link rel="icon" type="image/x-icon" href="img/icon.ico" />
</head>

<?php
 
    session_start();

        if (!isset($_SESSION["username"]) || !isset($_SESSION["fname"]) || !isset($_SESSION["lname"]) || !isset($_SESSION["account_type"]))
                {
                      header("Location: login");
                        return;
                }

        if(isset($_SESSION["account_status"]) && $_SESSION["account_status"]!="New")
        {
        header("Location: projections");
        return;
        }


?>






<body>

    <script>
          

           
            
            
            



        function checkpassword()
        {
            
            var password = document.getElementById("newpassword").value;
            var password2 = document.getElementById("verifypassword").value;
           
            if(password!=password2)
            {
            document.getElementById("error").style.display = "flex";
            event.returnValue=false;
                return false;
           
            }
            

        }
    </script>

    <div class="login-container">
        
        <div class="loginbox">
            <div class="login-cell">
                <center>
                    <img src="img/Rec-Logo.png" width="300" style="margin-bottom:10px;"/>
                </center>
                <div class="errormessage-login" id="error">Passwords did not match.</div>
                    <div class="login-border">
                        <center>
                            <h1>New Password</h1>
                            <form method="POST" onsubmit="checkpassword()" action="scripts/activateaccount">

                                <input class="login-input" type="password" name="newpassword" id="newpassword" placeholder="Password" spellcheck="false" minlength="8" maxlength="16"/>
                                <div class="underline"></div>
                                <input class="login-input" type="password" id="verifypassword" name="verifypassword" placeholder="Confirm Password" minlength="8" maxlength="16" />
                                <div class="underline2"></div>
                                <input type="submit" class="login-submit" value="Login" />

                            </form>
                        </center>
                    </div>
</div>
        </div>

    </div>









</body>
</html>




<?php

?>