<!DOCTYPE html>
<html>
<head>
<title>Template</title>
<link rel="stylesheet" href="scripts/StyleSheet.css" />
<link rel="icon" type="image/x-icon" href="img/icon.ico" />
    <?php include 'scripts/validate.php';




    session_start();

    if(!isset($_SESSION["username"]) || !isset($_SESSION["fname"]) || !isset($_SESSION["lname"]) || !isset($_SESSION["account_type"]))
    {
        header("Location: login");
        return;
    }




        if($_SESSION["account_type"]!="Admin")
        {
            header("Location: login");
        return;
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
    <a href="accountsettings"><?php echo "Hi, " . ucwords($_SESSION["fname"]) . " " . ucwords($_SESSION["lname"]); ?></a>
</div>
</div>

<div class="upper-menu">
<div class="upper-menu-options">
   MANAGE USERS
</div>

</div>


<div class="Projection-Day-Container">
    <div class="Projection-Day">
        <div class="Projection-Day-Cell">
         Create An Account

            <form action="scripts/createaccount" method="POST">
            <table>
                <tr>
                    <td>Username</td>
              <td> <input name="username" required/></td>
                </tr>
                 <tr>
                    <td>First Name</td>
              <td> <input name="fname" required /></td>
                </tr>
                 <tr>
                    <td>Last Name</td>
              <td> <input name="lname" required /></td>
                </tr>
                <tr>
                    <td>Password</td>
              <td> <input name="password" type="password" maxlength="16" minlength="8" required /></td>
                </tr>
                 <tr>
                    <td>Account Type</td>
              <td>
                  <select name="account_type" required>
                      <option name="Admin">Admin</option>
                      <option name="Canton">Manager-Canton</option>
                      <option name="Charles Village">Manager-Charles Village</option>
                      <option name="Columbia">Manager-Columbia</option>
                      <option name="Owings Mills">Manager-Owings Mills</option>
                      <option name="Timonium">Manager-Timonium</option>
                      <option name="Towson">Manager-Towson</option>
                  </select>
              </td>
                </tr>
                <tr>
                    <td></td>
                    <td> <button type="submit">Create</button></td>
                </tr>
              


            </table>
                </form>
        </div>

         <div class="Projection-Day-Cell">
             ACCOUNT LIST
              <table>
                <tr>
                    <td><b>Username</b></td>
                    <td><b>First Name</b></td>
                    <td><b>Last Name</b></td>
                    <td><b>Change Password</b></td>
                    <td><b>Account Type</b></td>
                    <td>      </td>
                    <td>      </td>
                </tr>
                  <?php
                     $listquery = "SELECT * FROM users";
                     $listresult = mysqli_query($dbconnect, $listquery);


                     while($row = mysqli_fetch_assoc($listresult))
                     {
                  ?>
                 <tr>
                     

                    <td><?php echo $row["username"]; ?></td>
                    <td><?php echo ucwords($row["fname"]); ?></td>
                    <td><?php echo ucwords($row["lname"]); ?></td>
                    <td><input type="password" /></td>
                      <td>
                  <select>
                      <option name="Admin" <?php if($row["account_type"]=="Admin") { echo "selected"; }?>>Admin</option>
                      <option name="Canton" <?php if ($row["account_type"] == "Manager-Canton") { echo "selected";} ?>>Manager-Canton</option>
                      <option name="Charles Village" <?php if ($row["account_type"] == "Manager-Charles Village") { echo "selected";} ?>>Manager-Charles Village</option>
                      <option name="Columbia" <?php if ($row["account_type"] == "Manager-Columbia") {
                              echo "selected";
                          } ?>>Manager-Columbia</option>
                      <option name="Owings Mills" <?php if ($row["account_type"] == "Manager-Owings Mills") {
                              echo "selected";
                          } ?>>Manager-Owings Mills</option>
                      <option name="Timonium" <?php if ($row["account_type"] == "Manager-Timonium") {
                              echo "selected";
                          } ?>>Manager-Timonium</option>
                      <option name="Towson" <?php if ($row["account_type"] == "Manager-Towson") {
                              echo "selected";
                          } ?>>Manager-Towson</option>
                  </select>
              </td>
                    <td><a href="#">Save</a></td>
                    <td><a href="#">Delete</a></td>
                </tr>
               
                <?php } ?>
            </table>

         </div>



        
    </div>
    
</div>



</body>

</html>