<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="icon" type="image/x-icon" href="img/icon.ico" />
<link rel="stylesheet" href="scripts/loginsheet.css" />
    <?php
    session_start();

    if (isset($_SESSION["username"]) || isset($_SESSION["fname"]) || isset($_SESSION["lname"]) || isset($_SESSION["account_type"])) {
        header("Location: projections");
        return;
        }


    ?>

</head>

<body>

    
    <div class="login-container">
        
        <div class="loginbox">
            <div class="login-cell">
                <center>
                    <img src="img/Rec-Logo.png" width="300" style="margin-bottom:10px;"/>
                </center>
                <?php if (isset($_GET["error"]) && $_GET["error"] == 621) { ?>
                    <div class="errormessage">Incorrect username or password.</div>
                <?php } ?>
                    <div class="login-border">
                        <center>
                            <h1>Sign In</h1>
                            <form method="POST" action="scripts/validatelogin">


                              



                                <input class="login-input" name="username" placeholder="Username" spellcheck="false" autocomplete="off" />
                                <div class="underline"></div>
                                <input class="login-input" type="password" name="password" placeholder="Password" />
                                <div class="underline2"></div>

                                
                                <input type="submit" class="login-submit" value="Login"/>

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