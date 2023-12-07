<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/x-icon" href="img/icon.ico">
    <title>Template</title>
    <link rel="stylesheet" href="scripts/StyleSheet.css" />
    <?php include 'scripts/validate.php';

    session_start();

    if (!isset($_SESSION["username"]) || !isset($_SESSION["fname"]) || !isset($_SESSION["lname"]) || !isset($_SESSION["account_type"])) {
        header("Location: login");
        return;
    }
    
    
    ?>

</head>
<body>
    <script src="https://kit.fontawesome.com/e281ac63ca.js" crossorigin="anonymous"></script>
    <div class="left-menu" id="left-menu">
        <img src="img/Rec-Logo.png" class="main-logo" />
        <div class="option-container">
            <a href=projections><i class="fa-solid fa-briefcase"></i>Bagel Management</a>
            <a href="projections" class="subcategory"> Projections</a>
            <a href="slacksheet" class="subcategory"> Slack Sheet</a>
            <a href="dailyvariance" class="subcategory"> Daily Variance</a>
            
            <a href="usage" class="subcategory"> Edit Usage</a>
 <?php if ($_SESSION["account_type"] == "Admin") { ?>
    <a href=manageusers> <i class="fa-solid fa-users"></i>Manage Users</a>
    <?php } ?>
<a href=accountsettings> <i class="fa-solid fa-gear"></i>Account Settings</a>
<a href=scripts/signout> <i class="fa-solid fa-arrow-right-from-bracket"></i>Sign Out</a>
        </div>
    </div>

    <div class="upper-menu">
        <div class="upper-menu-options">
            <a href="accountsettings"> <?php echo "Hi, " . ucwords($_SESSION["fname"]) . " " . ucwords($_SESSION["lname"]); ?></a>
        </div>
    </div>

    <script>





        function toggleprint()
        {

            if(document.getElementById("printbutton").innerHTML == "Print Mode : OFF")
            {
            document.getElementById("printbutton").style.backgroundColor = "#69b535";
            document.getElementById("left-menu").style.display = "none";
            document.getElementById("printbutton").innerHTML = "Print Mode : ON";
            document.getElementById("Projection-Day-Container").style.marginLeft = "0px";
            document.getElementById("Projection-Day-Cell-Item").style.minWidth = "50px";
                document.getElementById("Projection-Day-Cell-Item").style.display = "inline-block";
                document.getElementById("Projection-Day-Cell-Item").style.marginLeft = "0px";


            const collection = document.getElementsByName("tableprint");
            for (let i = 0; i < collection.length; i++) {

            collection[i].style.display = "none";

                }


            const collection2 = document.getElementsByName("Projection-Day-Cell");
            for (let i = 0; i < collection.length; i++) {

            collection2[i].style.marginLeft = "0px";
             collection2[i].style.minWidth="130px";
                }




            }
            else
            {
                document.getElementById("printbutton").style.backgroundColor = "#ED2700";
            document.getElementById("printbutton").innerHTML = "Print Mode : OFF";
             document.getElementById("left-menu").style.display = "inline";
          document.getElementById("Projection-Day-Cell-Item").style.marginLeft = "40px";
             document.getElementById("Projection-Day-Container").style.marginLeft = "265px";
              const collection = document.getElementsByName("tableprint");
            for (let i = 0; i < collection.length; i++) {

            collection[i].style.display = "inline";
                }

                   const collection2 = document.getElementsByName("Projection-Day-Cell");
            for (let i = 0; i < collection.length; i++) {

            collection2[i].style.marginLeft = "40px";
             collection2[i].style.minWidth="130px";
                }


            }
        }
    </script>

    <?php


    $nativedate = array();


    if (isset($_GET["location"]) && isset($_GET["startdate"]) && isset($_GET["enddate"])) {
        $location = $_GET["location"];
        $startdate = $_GET["startdate"];
        $enddate = $_GET["enddate"];
        
        $_SESSION["location"] = $location;
        $_SESSION["startdate"] = $startdate;
        $_SESSION["enddate"] = $enddate;

    } else {
        $location = "Canton";
        $startdate = date("Y-m-d");
        $enddate = date("Y-m-d");
       
        $_SESSION["location"] = $location;
        $_SESSION["startdate"] = $startdate;
        $_SESSION["enddate"] = $enddate;
    }




    for ($y = $startdate; $y <= $enddate; $y = date('Y-m-d', strtotime("+1 day", strtotime($y)))) {

        array_push($nativedate, date($y));

        if ($y == $enddate) {
            
        }




    }


    ?>




    <div class="upper-menu">
        <div class="upper-menu-options" id="upper-menu-options">
            DAILY SLACK VARIANCE

            <button id="printbutton" onclick="toggleprint()">Print Mode : OFF</button>
        </div>
        <div class="upper-menu-filter">
            <form class="filter-form" action="dailyvariance" method="get">
                <select name="location" id="location" placeholder="Location">

                    <?php   if($_SESSION["account_type"] == "Admin" || $_SESSION["account_type"] == "Manager-Canton") { ?> <option value="Canton"
                        <?php if ($location == "Canton") {
                            echo "selected";
                        } ?>>Canton</option><?php } ?>
                    <?php if($_SESSION["account_type"] == "Admin" || $_SESSION["account_type"] == "Manager-Charles Village") { ?> <option value="Charles Village"
                        <?php if ($location == "Charles Village") {
                            echo "selected";
                        } ?>>Charles Village</option><?php } ?>
                    <?php if($_SESSION["account_type"] == "Admin" || $_SESSION["account_type"] == "Manager-Columbia") { ?><option value="Columbia"
                        <?php if ($location == "Columbia") {
                            echo "selected";
                        } ?>>Columbia</option><?php } ?>
                    <?php if($_SESSION["account_type"] == "Admin" || $_SESSION["account_type"] == "Manager-Owings Mills") { ?> <option value="Owings Mills"
                        <?php if ($location == "Owings Mills") {
                            echo "selected";
                        } ?>>Owings Mills</option><?php } ?>
                    <?php if($_SESSION["account_type"] == "Admin" || $_SESSION["account_type"] == "Manager-Timonium") { ?> <option value="Timonium"
                        <?php if ($location == "Timonium") {
                            echo "selected";
                        } ?>>Timonium</option><?php } ?>
                    <?php if($_SESSION["account_type"] == "Admin" || $_SESSION["account_type"] == "Manager-Towson") { ?> <option value="Towson"
                        <?php if ($location == "Towson") {
                            echo "selected";
                        } ?>>Towson</option><?php } ?>
                </select>
                From : <input type="date" id="startdate" name="startdate" class="datepicker" value="<?php echo $startdate ?>" />
                To : <input type="date" id="enddate" name="enddate" class="datepicker" value="<?php echo $enddate ?>" />
                <input type="submit" value="Filter" class="filterbutton"/>
            </form>
        </div>
    </div>


    <div class="Projection-Day-Container" id="Projection-Day-Container">
        <div class="Projection-Day" id="Projection-Day">
            <?php

          

            $slackquery = "SELECT * FROM daily_projection WHERE DATE between '{$startdate}' and '{$enddate}' ORDER BY DATE ASC";
            $slackdate = mysqli_query($dbconnect, $slackquery);
            if (mysqli_num_rows($slackdate) < 7) {
                if (count($nativedate) - 2 >= 7) {
                    echo "<br><center><h2 style='color:red;'>INCOMPLETE PROJECTION DATA!</h2></center>";
                } else {
                    echo "<br><center><h2 style='color:red;'>INVALID DATE RANGE!</h2></center>";
                }
                return;
            }

            ?>
            <div class="Projection-Day-Cell" id="Projection-Day-Cell-Item">
                <table class="slacktable">

                    <tr>


                        <td></td>
                        <?php

                        while ($row = mysqli_fetch_assoc($slackdate)) {

                            ?>



                            <?php echo "<td><center><b>" . date_format(date_create($row['Date']), "l m/d/Y") . "</center></td></b>"; ?>
                        <?php } ?>

                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <table class="slacktableinner">
                                <tr>

                                    <td>Usage </td>
                                    <td>Dough</td>
                                    <td>Variance</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="slacktableinner">
                                <tr>
                                    <td>Usage </td>
                                    <td>Dough</td>
                                    <td>Variance</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="slacktableinner">
                                <tr>
                                    <td>Usage </td>
                                    <td>Dough</td>
                                    <td>Variance</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="slacktableinner">
                                <tr>
                                    <td>Usage </td>
                                    <td>Dough</td>
                                    <td>Variance</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="slacktableinner">
                                <tr>
                                    <td>Usage </td>
                                    <td>Dough</td>
                                    <td>Variance</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="slacktableinner">
                                <tr>
                                    <td>Usage </td>
                                    <td>Dough</td>
                                    <td>Variance</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="slacktableinner">
                                <tr>
                                    <td>Usage </td>
                                    <td>Dough</td>
                                    <td>Variance</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Plain</b></td>
                        <td>
                            <table class="slacktableinner">
                                <tr>
                                    <?php
                                    $r = 0;
                                    $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                    $slackplain = mysqli_query($dbconnect, $plainquery);


                                    while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                        ?>

                                        <td>
                                            <?php echo round($row2["uPlain"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Plain"]);
                                            $r++; ?>
                                   
                                    </td>
                                        <?php  }
                                        ?>
                                    <td></td>
                                    <td></td>
                                </tr>




                            </table>
                        </td>
                        <td>
                            <table class="slacktableinner">
                                <tr>

                                    <?php
                                    
                                    $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                    $slackplain = mysqli_query($dbconnect, $plainquery);


                                    while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                        ?>

                                        <td>
                                            <?php echo round($row2["uPlain"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Plain"]);
                                            $r++; ?>

                                        </td>
                                    <?php }
                                    ?>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="slacktableinner">
                                <tr>

                                    <?php

                                    $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                    $slackplain = mysqli_query($dbconnect, $plainquery);


                                    while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                        ?>

                                        <td>
                                            <?php echo round($row2["uPlain"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Plain"]);
                                            $r++; ?>

                                        </td>
                                    <?php }
                                    ?>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="slacktableinner">
                                <tr>

                                    <?php

                                    $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                    $slackplain = mysqli_query($dbconnect, $plainquery);


                                    while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                        ?>

                                        <td>
                                            <?php echo round($row2["uPlain"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Plain"]);
                                            $r++; ?>

                                        </td>
                                    <?php }
                                    ?>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="slacktableinner">
                                <tr>

                                    <?php

                                    $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                    $slackplain = mysqli_query($dbconnect, $plainquery);


                                    while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                        ?>

                                        <td>
                                            <?php echo round($row2["uPlain"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Plain"]);
                                            $r++; ?>

                                        </td>
                                    <?php }
                                    ?>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="slacktableinner">
                                 <?php

                                 $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                 $slackplain = mysqli_query($dbconnect, $plainquery);


                                 while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                     ?>

                                            <td>
                                                <?php echo round($row2["uPlain"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Plain"]);
                                                $r++; ?>

                                            </td>
                                    <?php }
                                 ?>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="slacktableinner">
                                <tr>

                                     <?php

                                     $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                     $slackplain = mysqli_query($dbconnect, $plainquery);


                                     while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                         ?>

                                            <td>
                                                <?php echo round($row2["uPlain"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Plain"]);
                                                $r++; ?>

                                            </td>
                                    <?php }
                                     ?>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                        <tr>
                            <td><b>Wheat</b></td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                         <?php
                                         $r = 0;
                                         
                                         $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                         $slackplain = mysqli_query($dbconnect, $plainquery);


                                         while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                             ?>

                                            <td>
                                                <?php echo $row2["uWheat"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Wheat"];
                                                $r++; ?>

                                            </td>
                                    <?php }
                                         ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php
                                        

                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                <td>
                                                    <?php echo $row2["uWheat"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Wheat"];
                                                    $r++; ?>

                                                </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                    <td>
                                                        <?php echo $row2["uWheat"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Wheat"];
                                                        $r++; ?>

                                                    </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                       <?php


                                       $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                       $slackplain = mysqli_query($dbconnect, $plainquery);


                                       while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                           ?>

                                                    <td>
                                                        <?php echo $row2["uWheat"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Wheat"];
                                                        $r++; ?>

                                                    </td>
                                    <?php }
                                       ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                       <?php


                                       $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                       $slackplain = mysqli_query($dbconnect, $plainquery);


                                       while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                           ?>

                                                    <td>
                                                        <?php echo $row2["uWheat"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Wheat"];
                                                        $r++; ?>

                                                    </td>
                                    <?php }
                                       ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                       <?php


                                       $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                       $slackplain = mysqli_query($dbconnect, $plainquery);


                                       while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                           ?>

                                                    <td>
                                                        <?php echo $row2["uWheat"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Wheat"];
                                                        $r++; ?>

                                                    </td>
                                    <?php }
                                       ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                       <?php


                                       $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                       $slackplain = mysqli_query($dbconnect, $plainquery);


                                       while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                           ?>

                                                    <td>
                                                        <?php echo $row2["uWheat"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Wheat"];
                                                        $r++; ?>

                                                    </td>
                                    <?php }
                                       ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>

                        </tr>

                        <tr>
                            <td><b>Marble</b></td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php
                                        $r = 0;

                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                    <td>
                                                        <?php echo $row2["uMarble"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Marble"];
                                                        $r++; ?>

                                                    </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                         <?php
                                         

                                         $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                         $slackplain = mysqli_query($dbconnect, $plainquery);


                                         while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                             ?>

                                                        <td>
                                                            <?php echo $row2["uMarble"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Marble"];
                                                            $r++; ?>

                                                        </td>
                                    <?php }
                                         ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                         <?php


                                         $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                         $slackplain = mysqli_query($dbconnect, $plainquery);


                                         while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                             ?>

                                                            <td>
                                                                <?php echo $row2["uMarble"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Marble"];
                                                                $r++; ?>

                                                            </td>
                                    <?php }
                                         ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                            <td>
                                                                <?php echo $row2["uMarble"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Marble"];
                                                                $r++; ?>

                                                            </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                            <td>
                                                                <?php echo $row2["uMarble"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Marble"];
                                                                $r++; ?>

                                                            </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                            <td>
                                                                <?php echo $row2["uMarble"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Marble"];
                                                                $r++; ?>

                                                            </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                            <td>
                                                                <?php echo $row2["uMarble"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Marble"];
                                                                $r++; ?>

                                                            </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Asiago</b></td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                         <?php

                                         $r = 0;
                                         $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                         $slackplain = mysqli_query($dbconnect, $plainquery);


                                         while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                             ?>

                                                            <td>
                                                                <?php echo $row2["uAsiago"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Asiago"];
                                                                $r++; ?>

                                                            </td>
                                    <?php }
                                         ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php

                                        
                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                <td>
                                                                    <?php echo $row2["uAsiago"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Asiago"];
                                                                    $r++; ?>

                                                                </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                       
                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                    <td>
                                                                        <?php echo $row2["uAsiago"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Asiago"];
                                                                        $r++; ?>

                                                                    </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                       
                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                    <td>
                                                                        <?php echo $row2["uAsiago"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Asiago"];
                                                                        $r++; ?>

                                                                    </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        
                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                    <td>
                                                                        <?php echo $row2["uAsiago"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Asiago"];
                                                                        $r++; ?>

                                                                    </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                       
                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                    <td>
                                                                        <?php echo $row2["uAsiago"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Asiago"];
                                                                        $r++; ?>

                                                                    </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        
                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                    <td>
                                                                        <?php echo $row2["uAsiago"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Asiago"];
                                                                        $r++; ?>

                                                                    </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Egg</b></td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        
                                        <?php
                                        $r = 0;

                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                    <td>
                                                                        <?php echo $row2["uEgg"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Egg"];
                                                                        $r++; ?>

                                                                    </td>
                                    <?php }
                                        ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                         <?php


                                         $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                         $slackplain = mysqli_query($dbconnect, $plainquery);


                                         while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                             ?>

                                                                        <td>
                                                                            <?php echo $row2["uEgg"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Egg"];
                                                                            $r++; ?>

                                                                        </td>
                                    <?php }
                                         ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>


                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                        <td>
                                                                            <?php echo $row2["uEgg"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Egg"];
                                                                            $r++; ?>

                                                                        </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>


                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                        <td>
                                                                            <?php echo $row2["uEgg"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Egg"];
                                                                            $r++; ?>

                                                                        </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>


                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                        <td>
                                                                            <?php echo $row2["uEgg"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Egg"];
                                                                            $r++; ?>

                                                                        </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>


                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                        <td>
                                                                            <?php echo $row2["uEgg"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Egg"];
                                                                            $r++; ?>

                                                                        </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>


                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                        <td>
                                                                            <?php echo $row2["uEgg"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Egg"];
                                                                            $r++; ?>

                                                                        </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Raisin</b></td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>


                                        <?php
                                        $r = 0;

                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                        <td>
                                                                            <?php echo $row2["uRaisin"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Raisin"];
                                                                            $r++; ?>

                                                                        </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>


                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                            <td>
                                                                                <?php echo $row2["uRaisin"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Raisin"];
                                                                                $r++; ?>

                                                                            </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                            <td>
                                                                                <?php echo $row2["uRaisin"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Raisin"];
                                                                                $r++; ?>

                                                                            </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                            <td>
                                                                                <?php echo $row2["uRaisin"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Raisin"];
                                                                                $r++; ?>

                                                                            </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                            <td>
                                                                                <?php echo $row2["uRaisin"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Raisin"];
                                                                                $r++; ?>

                                                                            </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                            <td>
                                                                                <?php echo $row2["uRaisin"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Raisin"];
                                                                                $r++; ?>

                                                                            </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php


                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                            <td>
                                                                                <?php echo $row2["uRaisin"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Raisin"];
                                                                                $r++; ?>

                                                                            </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Blueberry</b></td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php
                                        $r = 0;
                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                        <td>
                                                                            <?php echo $row2["uBlueberry"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Blueberry"];
                                                                            $r++; ?>

                                                                        </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                      <?php
                                        
                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                        <td>
                                                                            <?php echo $row2["uBlueberry"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Blueberry"];
                                                                            $r++; ?>

                                                                        </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php
                                        
                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                        <td>
                                                                            <?php echo $row2["uBlueberry"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Blueberry"];
                                                                            $r++; ?>

                                                                        </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                      <?php
                                        
                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                        <td>
                                                                            <?php echo $row2["uBlueberry"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Blueberry"];
                                                                            $r++; ?>

                                                                        </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php
                                        
                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                        <td>
                                                                            <?php echo $row2["uBlueberry"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Blueberry"];
                                                                            $r++; ?>

                                                                        </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php
                                        
                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                        <td>
                                                                            <?php echo $row2["uBlueberry"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Blueberry"];
                                                                            $r++; ?>

                                                                        </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php
                                        
                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                        <td>
                                                                            <?php echo $row2["uBlueberry"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Blueberry"];
                                                                            $r++; ?>

                                                                        </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Choc-Chip</b></td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php
                                        $r = 0;
                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                        <td>
                                                                            <?php echo $row2["uChoc"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Choc"];
                                                                            $r++; ?>

                                                                        </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                       <?php
                                      
                                       $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                       $slackplain = mysqli_query($dbconnect, $plainquery);


                                       while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                           ?>

                                                                            <td>
                                                                                <?php echo $row2["uChoc"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Choc"];
                                                                                $r++; ?>

                                                                            </td>
                                    <?php }
                                       ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>


                                        <?php

                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                                <td>
                                                                                    <?php echo $row2["uChoc"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Choc"];
                                                                                    $r++; ?>

                                                                                </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>


                                       <?php

                                       $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                       $slackplain = mysqli_query($dbconnect, $plainquery);


                                       while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                           ?>

                                                                                <td>
                                                                                    <?php echo $row2["uChoc"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Choc"];
                                                                                    $r++; ?>

                                                                                </td>
                                    <?php }
                                       ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>


                                       <?php

                                       $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                       $slackplain = mysqli_query($dbconnect, $plainquery);


                                       while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                           ?>

                                                                                <td>
                                                                                    <?php echo $row2["uChoc"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Choc"];
                                                                                    $r++; ?>

                                                                                </td>
                                    <?php }
                                       ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>


                                        <?php

                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                                <td>
                                                                                    <?php echo $row2["uChoc"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Choc"];
                                                                                    $r++; ?>

                                                                                </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>


                                       <?php

                                       $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                       $slackplain = mysqli_query($dbconnect, $plainquery);


                                       while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                           ?>

                                                                                <td>
                                                                                    <?php echo $row2["uChoc"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["Choc"];
                                                                                    $r++; ?>

                                                                                </td>
                                    <?php }
                                       ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td><b>LTO</b></td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>


                                        <?php
                                        $r = 0;
                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                                <td>
                                                                                    <?php echo $row2["uLTO_1"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["LTO_1"];
                                                                                    $r++; ?>

                                                                                </td>
                                    <?php }
                                        ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                         <?php

                                         $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                         $slackplain = mysqli_query($dbconnect, $plainquery);


                                         while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                             ?>

                                                                                    <td>
                                                                                        <?php echo $row2["uLTO_1"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["LTO_1"];
                                                                                        $r++; ?>

                                                                                    </td>
                                    <?php }
                                         ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php

                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                                        <td>
                                                                                            <?php echo $row2["uLTO_1"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["LTO_1"];
                                                                                            $r++; ?>

                                                                                        </td>
                                    <?php }
                                        ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                         <?php

                                         $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                         $slackplain = mysqli_query($dbconnect, $plainquery);


                                         while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                             ?>

                                                                                        <td>
                                                                                            <?php echo $row2["uLTO_1"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["LTO_1"];
                                                                                            $r++; ?>

                                                                                        </td>
                                    <?php }
                                         ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php

                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                                        <td>
                                                                                            <?php echo $row2["uLTO_1"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["LTO_1"];
                                                                                            $r++; ?>

                                                                                        </td>
                                    <?php }
                                        ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                         <?php

                                         $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                         $slackplain = mysqli_query($dbconnect, $plainquery);


                                         while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                             ?>

                                                                                        <td>
                                                                                            <?php echo $row2["uLTO_1"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["LTO_1"];
                                                                                            $r++; ?>

                                                                                        </td>
                                    <?php }
                                         ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php

                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                                        <td>
                                                                                            <?php echo $row2["uLTO_1"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["LTO_1"];
                                                                                            $r++; ?>

                                                                                        </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td><b>LTO</b></td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>


                                        <?php
                                        $r = 0;
                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                                        <td>
                                                                                            <?php echo $row2["uLTO_2"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["LTO_2"];
                                                                                            $r++; ?>

                                                                                        </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php
                                        
                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                                            <td>
                                                                                                <?php echo $row2["uLTO_2"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["LTO_2"];
                                                                                                $r++; ?>

                                                                                            </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php

                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                                                <td>
                                                                                                    <?php echo $row2["uLTO_2"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["LTO_2"];
                                                                                                    $r++; ?>

                                                                                                </td>
                                    <?php }
                                        ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                       <?php

                                       $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                       $slackplain = mysqli_query($dbconnect, $plainquery);


                                       while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                           ?>

                                                                                                <td>
                                                                                                    <?php echo $row2["uLTO_2"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["LTO_2"];
                                                                                                    $r++; ?>

                                                                                                </td>
                                    <?php }
                                       ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php

                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                                                <td>
                                                                                                    <?php echo $row2["uLTO_2"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["LTO_2"];
                                                                                                    $r++; ?>

                                                                                                </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php

                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                                                <td>
                                                                                                    <?php echo $row2["uLTO_2"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["LTO_2"];
                                                                                                    $r++; ?>

                                                                                                </td>
                                    <?php }
                                        ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="slacktableinner">
                                    <tr>

                                        <?php

                                        $plainquery = "SELECT * FROM daily_projection WHERE DATE = '{$nativedate[$r]}'";
                                        $slackplain = mysqli_query($dbconnect, $plainquery);


                                        while ($row2 = mysqli_fetch_assoc($slackplain)) {


                                            ?>

                                                                                                <td>
                                                                                                    <?php echo $row2["uLTO_2"] * ($row2["Projected_Sales"] / 10000) * $row2["Projected_Variation"] + $row2["LTO_2"];
                                                                                                    $r++; ?>

                                                                                                </td>
                                    <?php }
                                        ?>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                </table>

            </div>


        </div>

    </div>



</body>

</html>