<!DOCTYPE html>
<html>
<head>
<title>Template</title>
<link rel="stylesheet" href="scripts/StyleSheet.css" />
<link rel="icon" type="image/x-icon" href="img/icon.ico" />
    <?php include 'scripts/validate.php';

    session_start();

    if (!isset($_SESSION["username"]) || !isset($_SESSION["fname"]) || !isset($_SESSION["lname"]) || !isset($_SESSION["account_type"])) {
        header("Location: login");
        return;
    }





    if(isset($_GET["location"]) && isset($_GET["startdate"]) && isset($_GET["enddate"]))
    {
        $filterlocation = $_GET["location"];
        $filterstartdate = $_GET["startdate"];
        $filterenddate = $_GET["enddate"];
    }

    else
    {
         $filterlocation = "Canton";
        $filterstartdate = date('Y-m-d', strtotime("-14 day", strtotime(date("Y-m-d"))));
        $filterenddate = date('Y-m-d', strtotime("+14 day", strtotime(date("Y-m-d"))));
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
        <a href=manageusers><i class="fa-solid fa-users"></i>Manage Users</a>
    <?php } ?>
    <a href=accountsettings><i class="fa-solid fa-gear"></i>Account Settings</a>
    <a href=scripts/signout><i class="fa-solid fa-arrow-right-from-bracket"></i>Sign Out</a>
</div>
</div>

<div class="upper-menu">
<div class="upper-menu-options">
    <a href="accountsettings"> <?php echo "Hi, " . ucwords($_SESSION["fname"]) . " " . ucwords($_SESSION["lname"]); ?></a>
</div>
</div>

<div class="upper-menu">
<div class="upper-menu-options">
   USAGE
</div>
<div class="upper-menu-filter">
   
</div>
</div>


<div class="Projection-Day-Container">
    <div class="Projection-Day">
        <div class="Projection-Day-Cell">
         PROJECT USAGE 
            <form class="editprojection-form" action="scripts/saveusage">
                <?php if(isset($_GET["error"]) && $_GET["error"] == "2302")
                      { ?>
                          
                <div class="errormessage">Error 2302 : <br />Projected Usage Already Exists. </div>
                <?php } ?>
            <table>
                 <tr>
                   <td>Start Date</td>
                   <td><input type="date" name="startdate" required></td>
               </tr>
                 <tr>
                   <td>Location</td>
                    <td>
                   <select name="location" id="location" placeholder="Location">
                     <option value="Canton">Canton</option>
                     <option value="Charles Village">Charles Village</option>
                     <option value="Columbia">Columbia</option>
                     <option value="Owings Mills">Owings Mills</option>
                     <option value="Timonium">Timonium</option>
                     <option value="Towson">Towson</option>
                   </select>
                        </td>
               </tr>
                 <tr>
                   <td>Plain</td>
                   <td><input type="number" name="plain" step="0.01" min="0" required /></td>
                   
               </tr>
                <tr>
                   <td>Wheat</td>
                   <td><input type="number" name="wheat" step="0.01" min="0" required /></td>
                  
               </tr>
                <tr>
                   <td>Marble</td>
                   <td><input type="number" name="marble" step="0.01" min="0" required /></td>
                   
               </tr>
                <tr>
                   <td>Asiago</td>
                   <td><input type="number" name="asiago" step="0.01" min="0" required /></td>
                  
               </tr>
                <tr>
                   <td>Egg</td>
                   <td><input type="number" name="egg" step="0.01" min="0" required /></td>
                   
               </tr>
                <tr>
                   <td>Raisin</td>
                   <td><input type="number" name="raisin" step="0.01" min="0" required /></td>
                   
               </tr>
                <tr>
                   <td>Blueberry</td>
                   <td><input type="number" name="blueberry" step="0.01" min="0" required /></td>
                   
               </tr>
                <tr>
                   <td>Choc-Chip</td>
                   <td><input type="number" name="choc" step="0.01" min="0" required /></td>
                 
               </tr>
                <tr>
                   <td>LTO</td>
                   <td><input type="number" name="LTO_1" step="0.01" min="0" required /></td>
                   
               </tr>
                <tr>
                    <td>LTO</td>
                    <td><input type="number" name="LTO_2" step="0.01" min="0" required /></td>

                </tr>
                
            </table>
               
            <button type="submit">Save</button>
            <button onclick = "window.location.href='projections';">Cancel</button>
                 </form>
        </div>
        <br />
       
         <div class="Projection-Day-Cell">
              FILTER SETTINGS
              
              <form class="editfiltersettings">
                  <table>
                      <tr> 
                      <td>Location</td>
                      <td>
                  <select name="location" id="location">
  
                      <option value="Canton" <?php if($filterlocation=="Canton"){ echo "selected";}?>>Canton</option>
                      <option value="Charles Village" <?php if ($filterlocation == "Charles Village") {echo "selected"; } ?>>Charles Village</option>
                      <option value="Columbia" <?php if ($filterlocation == "Columbia") { echo "selected";} ?>>Columbia</option>
                      <option value="Owings Mills" <?php if ($filterlocation == "Owings Mills") {  echo "selected"; } ?>>Owings Mills</option>
                      <option value="Timonium" <?php if ($filterlocation == "Timonium") {echo "selected"; } ?>>Timonium</option>
                      <option value="Towson" <?php if ($filterlocation == "Towson") {echo "selected";} ?>>Towson</option>

                  </select>
                          </td>
                          </tr>
                      
                      <tr>
                          <td>
                              Start Date
                          </td>
                          <td><input type="date" name="startdate" value="<?php echo $filterstartdate; ?>" /></td>
                      </tr>
                       <tr>
                          <td>
                              End Date
                          </td>
                          <td><input type="date" name="enddate" value="<?php echo $filterenddate; ?>"/></td>
                      </tr>
                      <tr>
                          <td><button>Apply</button></td>
                      </tr>

                    </table>

              </form>
          </div>
      
        <?php
        $usagelistquery = "SELECT * from usage_list WHERE location = '{$filterlocation}' AND DATE BETWEEN '{$filterstartdate}' and '{$filterenddate}' ORDER BY DATE DESC";
        $usagelistresult = mysqli_query($dbconnect, $usagelistquery);

        ?>
      
        <div class="Projection-Day-Cell">
            PROJECTED USAGE

            <table>
                <tr>
                    <td><b>Date</b></td>
                    <td><b>Location</b></td>
                    <td><b>Plain</b></td>
                    <td><b>Wheat</b></td>
                    <td><b>Marble</b></td>
                    <td><b>Asiago</b></td>
                    <td><b>Egg</b></td>
                    <td><b>Raisin</b></td>
                    <td><b>Blueberry</b></td>
                    <td><b>Choc-Chip</b></td>
                    <td><b>LTO</b></td>
                    <td><b>LTO</b></td>
                    
                    
                </tr>

                <?php
                while ($usagerow = mysqli_fetch_assoc($usagelistresult))
                {
                    
                   
               

                ?>

                <tr>
                    
                        <td><?php echo date_format(date_create($usagerow['date']), "m/d/Y") ; ?></td>
                        <td><?php echo $usagerow['location']; ?></td>
                        <td><?php echo $usagerow['uplain']; ?></td>
                        <td><?php echo $usagerow['uwheat']; ?></td>
                        <td><?php echo $usagerow['umarble']; ?></td>
                        <td><?php echo $usagerow['uasiago']; ?></td>
                        <td><?php echo $usagerow['uegg']; ?></td>
                        <td><?php echo $usagerow['uraisin']; ?></td>
                        <td><?php echo $usagerow['ublueberry']; ?></td>
                        <td><?php echo $usagerow['uchoc']; ?></td>
                        <td><?php echo $usagerow['ulto_1']; ?></td>
                        <td><?php echo $usagerow['ulto_2']; ?></td>
                        <td><a href="scripts/deleteusage?date=<?php echo $usagerow['date']."&location=". $usagerow['location']; ?>">Delete</a></td>

                </tr>
               <?php } ?>
            </table>
        </div>

      
    </div>
    
</div>



</body>

</html>