<?php

session_start();

if (!isset($_SESSION["username"]) || !isset($_SESSION["fname"]) || !isset($_SESSION["lname"]) || !isset($_SESSION["account_type"])) {
    header("Location: login");
    return;
}
else{
    header("Location: projections");
}

?>