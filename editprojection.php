<!DOCTYPE html>
<html>
<head>
<title>Template</title>
<link rel="icon" type="image/x-icon" href="img/icon.ico">
<link rel="stylesheet" href="scripts/StyleSheet.css" />
    <?php
include 'scripts/validate.php';

    session_start();

    if (!isset($_SESSION["username"]) || !isset($_SESSION["fname"]) || !isset($_SESSION["lname"]) || !isset($_SESSION["account_type"])) {
        header("Location: login");
        return;
    }

    if (isset($_GET["location"]) && isset($_GET["date"])) {
        $location = $_GET["location"];
        $date =  date_format(date_create($_GET["date"]), "l m/d/Y");
        $rawdate = $_GET["date"];
        session_start();
       

    } else {


    }

    ?>

</head>
<body>
<script src="https://kit.fontawesome.com/e281ac63ca.js" crossorigin="anonymous"></script>
<div class="left-menu">
<img src="img/Rec-Logo.png" class="main-logo"/>
<div class="option-container">
<a href=projections> <i class="fa-solid fa-briefcase"></i>Bagel Management</a>
    <a href="projections" class="subcategory"> Projections</a>
    <a href="slacksheet" class="subcategory"> Slack Sheet</a>
    <a href="slacksheet" class="subcategory"> Daily Variance</a>
    
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

<div class="upper-menu">
<div class="upper-menu-options">
   EDIT PROJECTION
</div>
<div class="upper-menu-filter">
   
</div>
</div>


<div class="Projection-Day-Container">
    <div class="Projection-Day">
        <div class="Projection-Day-Cell">
            <?php 

            $dataquery = "SELECT * FROM daily_projection WHERE date = '{$rawdate}' and location = '{$location}'";
            $dataresult = mysqli_query($dbconnect, $dataquery);

            if(mysqli_num_rows($dataresult)==0)
            {
              //  header("Location: projections");
            }


                while($row=mysqli_fetch_assoc($dataresult))
                {


           


                echo $date; ?> 
            <form class="editprojection-form" action="scripts/addboard">
                <input value="<?php echo $row["Date"]; ?>" name="date" type="hidden"/></td>
            <table>
               <tr>
                   <td><b>Item</b></td>
                   <td><b>Added Board</b></td>
                   <td><b>Usage</b></td>
               </tr>
                 <tr>
                   <td>Plain</td>
                   <td><input type="number" name="plain" step="any" value="<?php echo $row["Plain"]; ?>"/></td>
                    <td><?php echo $row["uPlain"]; ?></td>
                   </tr>
                    <tr>
                       <td>Wheat</td>
                       <td><input type="number" name="wheat" step="0.01" min="0" value="<?php echo $row["Wheat"]; ?>"/></td>
                   <td><?php echo $row["uWheat"]; ?></td>
                   </tr>
                    <tr>
                       <td>Marble</td>
                       <td><input type="number" name="marble" step="any" value="<?php echo $row["Marble"]; ?>"/></td>
                   <td><?php echo $row["uMarble"]; ?></td>
                   </tr>
                    <tr>
                       <td>Asiago</td>
                       <td><input type="number" name="asiago" step="any" value="<?php echo $row["Asiago"]; ?>"/></td>
                   <td><?php echo $row["uAsiago"]; ?></td>
                   </tr>
                    <tr>
                       <td>Egg</td>
                       <td><input type="number" name="egg" step="any" value="<?php echo $row["Egg"]; ?>"/></td>
                   <td><?php echo $row["uEgg"]; ?></td>
                   </tr>
                    <tr>
                       <td>Raisin</td>
                       <td><input type="number" name="raisin" step="any" value="<?php echo $row["Raisin"]; ?>"/></td>
                   <td><?php echo $row["uRaisin"]; ?></td>
                   </tr>
                    <tr>
                       <td>Blueberry</td>
                       <td><input type="number" name="blueberry" step="any" value="<?php echo $row["Blueberry"]; ?>"/></td>
                   <td><?php echo $row["uBlueberry"]; ?></td>
                   </tr>
                    <tr>
                       <td>Choc-Chip</td>
                       <td><input type="number" name="choc" step="any" value="<?php echo $row["Choc"]; ?>"/></td>
                   <td><?php echo $row["uChoc"]; ?></td>
                   </tr>
                    <tr>
                       <td>LTO</td>
                       <td><input type="number" name="lto_1" step="any" value="<?php echo $row["LTO_1"]; ?>"/></td>
                   <td><?php echo $row["uLTO_1"]; ?></td>
                   </tr>
                    <tr>
                        <td>LTO</td>
                        <td><input type="number" name="lto_2" step="any" value="<?php echo $row["LTO_2"]; ?>"/></td>
                    <td><?php echo $row["uLTO_2"]; ?></td>
                </tr>
                
            </table>
               
            <button type="submit">Save</button>
            
                 </form>
            <?php } ?>
        </div>
      
    </div>
    
</div>



</body>

</html>