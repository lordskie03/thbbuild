<!DOCTYPE html>
<html>
<head>
    
    <?php include 'scripts/validate.php';

        session_start();

    if(!isset($_SESSION["username"]) || !isset($_SESSION["fname"]) || !isset($_SESSION["lname"]) || !isset($_SESSION["account_type"]))
    {
        header("Location: login");
        return;
    }


    if (isset($_GET["location"]) && isset($_GET["startdate"]) && isset($_GET["enddate"])) {
        $location = $_GET["location"];
        $startdate = $_GET["startdate"];
        $enddate = $_GET["enddate"];
      
        $_SESSION["location"] = $location;
        $_SESSION["startdate"] = $startdate;
        $_SESSION["enddate"] = $enddate;

    }

    else {
        $location = "Canton";
        $startdate = date("Y-m-d");
        $enddate = date("Y-m-d");
        
        $_SESSION["location"] = $location;
        $_SESSION["startdate"] = $startdate;
        $_SESSION["enddate"] = $enddate;
    }



    ?>

<title>Projections</title>
<link rel="icon" type="image/x-icon" href="img/icon.ico">
<link rel="stylesheet" href="scripts/StyleSheet.css" />


</head>
<body>
<script src="https://kit.fontawesome.com/e281ac63ca.js" crossorigin="anonymous"></script>
<div class="left-menu">
<img src="img/Rec-Logo.png" class="main-logo"/>
<div class="option-container">
<a href=projections> <i class="fa-solid fa-briefcase"></i>Bagel Management</a>
    <a href="projections" class="subcategory"> Projections</a>
    <a href="slacksheet" class="subcategory"> Slack Sheet</a>
    <a href="dailyvariance" class="subcategory"> Daily Variance</a>
    
    <a href="usage" class="subcategory"> Edit Usage</a>
 <?php if($_SESSION["account_type"]=="Admin") { ?>
<a href=manageusers> <i class="fa-solid fa-users"></i>Manage Users</a>
    <?php } ?>
<a href=accountsettings> <i class="fa-solid fa-gear"></i>Account Settings</a>
<a href=scripts/signout> <i class="fa-solid fa-arrow-right-from-bracket"></i>Sign Out</a>
</div>
</div>

<div class="upper-menu">
<div class="upper-menu-options">
  <a href="accountsettings"> <?php echo "Hi, ".ucwords($_SESSION["fname"])." ".ucwords($_SESSION["lname"]); ?></a>
</div>
</div>

<div class="upper-menu">
<div class="upper-menu-options">
   PROJECTIONS
</div>
<div class="upper-menu-filter">
   
    <form class="filter-form" action="projections" method="get">
        <select name="location" id="location" placeholder="Location">

          <?php   if($_SESSION["account_type"] == "Admin" || $_SESSION["account_type"] == "Manager-Canton") { ?>  <option value="Canton" <?php if($location=="Canton") { echo "selected";} ?>>Canton</option> <?php } ?>
          <?php if($_SESSION["account_type"] == "Admin" || $_SESSION["account_type"] == "Manager-Charles Village") { ?> <option value="Charles Village" <?php if ($location == "Charles Village") {echo "selected";} ?>>Charles Village</option> <?php } ?>
          <?php if($_SESSION["account_type"] == "Admin" || $_SESSION["account_type"] == "Manager-Columbia") { ?>  <option value="Columbia" <?php if ($location == "Columbia") {echo "selected";} ?>>Columbia</option><?php } ?>
          <?php if($_SESSION["account_type"] == "Admin" || $_SESSION["account_type"] == "Manager-Owings Mills") { ?> <option value="Owings Mills" <?php if ($location == "Owings Mills") {echo "selected";} ?>>Owings Mills</option><?php } ?>
          <?php if($_SESSION["account_type"] == "Admin" || $_SESSION["account_type"] == "Manager-Timonium") { ?>  <option value="Timonium" <?php if ($location == "Timonium") { echo "selected"; } ?>>Timonium</option><?php } ?>
          <?php if($_SESSION["account_type"] == "Admin" || $_SESSION["account_type"] == "Manager-Towson") { ?>  <option value="Towson" <?php if ($location == "Towson") { echo "selected";  } ?>>Towson</option><?php } ?>
        </select>
    From : <input type="date" id="startdate" name="startdate" class="datepicker" value="<?php echo $startdate?>">
    To : <input type="date" id="enddate" name="enddate" class="datepicker" value="<?php echo $enddate ?>" />
        <input type="submit" value="Filter" class="filterbutton">
    </form>
</div>
</div>


<div class="Projection-Day-Container">
    <div class="Projection-Day">

        <?php


            $projectionquery = "SELECT Date, projected_sales, projected_variation, location,
                                plain, wheat, marble, asiago, egg, raisin, blueberry,choc,lto_1,lto_2,
                                uplain, uwheat, umarble, uasiago, uegg, uraisin, ublueberry,uchoc,ulto_1,ulto_2
                                from daily_projection WHERE location ='{$location}' AND Date between '{$startdate}' and '{$enddate}' ORDER BY DATE DESC";

        $projectionresult = mysqli_query($dbconnect, $projectionquery);


        //GET ARRAY OF SELECTED DATES FROM DB
        $datequery = "SELECT Date from daily_projection WHERE location ='{$location}' AND Date between '{$startdate}' and '{$enddate}' ORDER BY DATE ASC";
        $dateresult = mysqli_query($dbconnect2, $datequery);
        $datearray = array();
        $nativedate = array();





        for($y = $startdate; $y <= $enddate; $y = date('Y-m-d', strtotime("+1 day", strtotime($y))))
        {

            array_push($nativedate, date($y));





        }





        $datecheck = 0;
        $z = 0;
        







        while ($row2 = mysqli_fetch_array($dateresult)) {

                 array_push($datearray, $row2['Date']);




        }

        rsort($nativedate);

        while ($z < count($nativedate)) {
            if (count($datearray) != 0) {
                if (!in_array($nativedate[$z], $datearray) && $nativedate[$z] > $datearray[$datecheck]) { ?>

                                <div class="Projection-Day-Cell">
                                    <?php echo date_format(date_create($nativedate[$z]), "l m/d/Y"); ?><a href="editprojection?<?php echo "date=" . $nativedate[$z] . "&location=" . $location;  ?>"><i class="fa-solid fa-pen"></i></a><h3><?php if ($nativedate[$z] == date("Y-m-d")) {
                                                        echo "(Today)";
                                                    }
                                                    if ($nativedate[$z] > date("Y-m-d")) {
                                                        echo "(Upcoming)";
                                                    }
                                                    if ($nativedate[$z] < date("Y-m-d")) {
                                                        echo "(Previous)";
                                                    } ?></h3>
                                    <form name="applyprojectionchanges" action="scripts/saveprojection" method="GET">
                                        <input type="hidden" value="<?php echo $nativedate[$z]; ?>" name="date" />
                                        <table>
                                            <tr>
                                                <td>
                                                    <b>Projected Sales ($)</b>
                                                </td>

                                                <td>
                                                    <input type="number" value="0" name="projectedsales"/>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <b>Variation (%)</b>
                                                </td>
                                                <td>
                                                    <input type="number" value="0" name="variation"/>
                                                </td>
                                            </tr>
                                            <tr><td></td></tr>
                                            <tr>
                                                <td> Plain
                                                </td>
                                                <td> --
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Wheat
                                                </td>
                                                <td> --
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Marble
                                                </td>
                                                <td> --
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Asiago
                                                </td>
                                                <td> --
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Egg
                                                </td>
                                                <td> --
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Raisin
                                                </td>
                                                <td> --
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Blueberry
                                                </td>
                                                <td> --
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Choc-Chip
                                                </td>
                                                <td> --
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> LTO
                                                </td>
                                                <td> --
                                                </td>
                                            </tr>


                                        </table>
                                        <button type="submit">Apply Changes</button>
                                    </form>
                                </div>
            
        






        <?php if ($datecheck < count($datearray)-1) 
                    {
                        $datecheck++;
                    }
                }

            }
            if(count($datearray)==0)
                { ?>

        <div class="Projection-Day-Cell">
            <?php echo date_format(date_create($nativedate[$z]), "l m/d/Y"); ?><a href=editprojection?<?php echo "date=" . $nativedate[$z] . "&location=" . $location;  ?>><i class="fa-solid fa-pen"></i></a><h3><?php if ($nativedate[$z] == date("Y-m-d")) {
                            echo "(Today)";
                        }
                        if ($nativedate[$z] > date("Y-m-d")) {
                            echo "(Upcoming)";
                        }
                        if ($nativedate[$z] < date("Y-m-d")) {
                            echo "(Previous)";
                        } ?></h3>
            <form name="applyprojectionchanges" action="scripts/saveprojection" method="GET">
                <input type="hidden" value="<?php echo $nativedate[$z]; ?>" name="date" />
                <table>
                    <tr>
                        <td>
                            <b>Projected Sales ($)</b>
                        </td>

                        <td>
                            <input type="number" value="0" name="projectedsales"/>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <b>Variation (%)</b>
                        </td>
                        <td>
                            <input type="number" value="0" name="variation"/>
                        </td>
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <td> Plain
                        </td>
                        <td> --
                        </td>
                    </tr>
                    <tr>
                        <td> Wheat
                        </td>
                        <td> --
                        </td>
                    </tr>
                    <tr>
                        <td> Marble
                        </td>
                        <td> --
                        </td>
                    </tr>
                    <tr>
                        <td> Asiago
                        </td>
                        <td> --
                        </td>
                    </tr>
                    <tr>
                        <td> Egg
                        </td>
                        <td> --
                        </td>
                    </tr>
                    <tr>
                        <td> Raisin
                        </td>
                        <td> --
                        </td>
                    </tr>
                    <tr>
                        <td> Blueberry
                        </td>
                        <td> --
                        </td>
                    </tr>
                    <tr>
                        <td> Choc-Chip
                        </td>
                        <td> --
                        </td>
                    </tr>
                    <tr>
                        <td> LTO
                        </td>
                        <td> --
                        </td>
                    </tr>


                </table>
                <button type="submit">Apply Changes</button>
            </form>
        </div>
        <?php

                }

            $z++;
        }
        while ($row = mysqli_fetch_assoc($projectionresult)) {




        ?>
        
       

             




        <div class="Projection-Day-Cell">
         <?php echo date_format(date_create($row['Date']),"l m/d/Y"); ?><a href=editprojection?<?php echo "date=" . $row['Date'] . "&location=" . $location;  ?>><i class="fa-solid fa-pen"></i></a> <h3><?php if ($row['Date']==date("Y-m-d")) {echo "(Today)";} if ($row['Date']>date("Y-m-d")) {echo "(Upcoming)";} if ($row['Date']<date("Y-m-d")) {echo "(Previous)";} ?></h3>
            <form name="applyprojectionchanges" action="scripts/saveprojection" method="GET">
                <input type="hidden" value="<?php echo $row['Date']; ?>" name="date" />
                <table>
                    <tr>
                        <td>
                            <b>Projected Sales ($)</b>
                        </td>

                        <td>
                            <input type="number" value="<?php echo $row["projected_sales"];?>" name="projectedsales" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <b>Variation (%)</b>
                        </td>
                        <td>
                            <input type="number" value="<?php echo $row["projected_variation"]; ?>" name="variation" />
                        </td>
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <td> Plain
                        </td>
                        <td>
                            <?php echo round($row["uplain"]*($row["projected_sales"]/10000)* $row["projected_variation"]+ $row["plain"]); ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Wheat
                        </td>
                        <td>
                            <?php echo round($row["uwheat"] * ($row["projected_sales"] / 10000) * $row["projected_variation"] + $row["wheat"], 2); ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Marble
                        </td>
                        <td>
                            <?php echo round($row["umarble"] * ($row["projected_sales"] / 10000) * $row["projected_variation"] + $row["marble"], 2); ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Asiago
                        </td>
                        <td>
                            <?php echo round($row["uasiago"] * ($row["projected_sales"] / 10000) * $row["projected_variation"] + $row["asiago"], 2); ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Egg
                        </td>
                        <td>
                            <?php echo round($row["uegg"] * ($row["projected_sales"] / 10000) * $row["projected_variation"] + $row["egg"], 2); ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Raisin
                        </td>
                        <td>
                            <?php echo round($row["uraisin"] * ($row["projected_sales"] / 10000) * $row["projected_variation"] + $row["raisin"], 2); ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Blueberry
                        </td>
                        <td>
                            <?php echo round($row["ublueberry"] * ($row["projected_sales"] / 10000) * $row["projected_variation"] + $row["blueberry"], 2); ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Choc-Chip
                        </td>
                        <td>
                            <?php echo round($row["uchoc"] * ($row["projected_sales"] / 10000) * $row["projected_variation"] + $row["choc"], 2); ?>
                        </td>
                    </tr>
                    <tr>
                        <td> LTO
                        </td>
                        <td>
                            <?php echo round($row["ulto_1"] * ($row["projected_sales"] / 10000) * $row["projected_variation"] + $row["lto_1"], 2); ?>
                        </td>
                    </tr>
                     <tr>
                        <td> LTO
                        </td>
                        <td>
                            <?php echo round($row["ulto_2"] * ($row["projected_sales"] / 10000) * $row["projected_variation"] + $row["lto_2"], 2); ?>
                        </td>
                    </tr>


                </table>
                <button type="submit">Apply Changes</button>
            </form>
        </div>
     
   
        <?php
         }

        $datecheck = 0;
        $z = 0;



                while ($z < count($nativedate)) {
            if (count($datearray) != 0) {
                if (!in_array($nativedate[$z], $datearray) && $nativedate[$z] < $datearray[$datecheck]) {
                    $_SESSION["date"] = $nativedate[$z]; ?>

                    <div class="Projection-Day-Cell">
                        
                        <?php echo date_format(date_create($nativedate[$z]), "l m/d/Y"); ?><a href=editprojection?<?php echo "date=" . $nativedate[$z] . "&location=" . $location;  ?>><i class="fa-solid fa-pen"></i></a><h3><?php if ($nativedate[$z] == date("Y-m-d")) {
                                            echo "(Today)";
                                        }
                                        if ($nativedate[$z] > date("Y-m-d")) {
                                            echo "(Upcoming)";
                                        }
                                        if ($nativedate[$z] < date("Y-m-d")) {
                                            echo "(Previous)";
                                        } ?></h3>
                        <form name="applyprojectionchanges" action="scripts/saveprojection" method="GET">
                            <table>
                                <input type="hidden" value="<?php echo $nativedate[$z]; ?>" name="date"/>
                                <tr>
                                    <td>
                                        <b>Projected Sales ($)</b>
                                    </td>

                                    <td>
                                        <input type="number" value="0" name="projectedsales"/>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <b>Variation (%)</b>
                                    </td>
                                    <td>
                                        <input type="number" value="0" name="variation"/>
                                    </td>
                                </tr>
                                <tr><td></td></tr>
                                <tr>
                                    <td> Plain
                                    </td>
                                    <td> --
                                    </td>
                                </tr>
                                <tr>
                                    <td> Wheat
                                    </td>
                                    <td> --
                                    </td>
                                </tr>
                                <tr>
                                    <td> Marble
                                    </td>
                                    <td> --
                                    </td>
                                </tr>
                                <tr>
                                    <td> Asiago
                                    </td>
                                    <td> --
                                    </td>
                                </tr>
                                <tr>
                                    <td> Egg
                                    </td>
                                    <td> --
                                    </td>
                                </tr>
                                <tr>
                                    <td> Raisin
                                    </td>
                                    <td> --
                                    </td>
                                </tr>
                                <tr>
                                    <td> Blueberry
                                    </td>
                                    <td> --
                                    </td>
                                </tr>
                                <tr>
                                    <td> Choc-Chip
                                    </td>
                                    <td> --
                                    </td>
                                </tr>
                                <tr>
                                    <td> LTO
                                    </td>
                                    <td> --
                                    </td>
                                </tr>


                            </table>
                            <button type="submit">Apply Changes</button>
                        </form>
                    </div>








                    <?php if ($datecheck < count($datearray) - 1) {
                        $datecheck++;
                    }
                }

            }
           

            $z++;
        }






        ?>
       
    
    
       
    </div>
    
</div>



</body>

</html>