<?php

   try{
        // Starts a session, allowing access to username over multiple pages
        session_start();

        // Store user login info
        $name = $_POST['name'];
        $password = $_POST['pw'];

        // Importing necessary classes
        require_once ("../DB/DBConnection.php");
        require_once ("../DB/Forum_DB.php"); //include the forum class info
        require_once ("validate_input.php");

        if(!clean_name_input($name)){ //if the name is bad data
           echo "<h1 class='post_notif'>Username has illegal characters.<h1>";
        }
        else{

           // Create connection to database
           $db = (new DBConnection());
           $db_PDO = $db->connect();

           // Provide direct interaction with usertable
           $db_interface = (new UserTable($db_PDO));

           // Check if login credentials are valid
           $userID = $db_interface->validate_login($name, $password);

           // (TEMP) tell user if login worked
           if ($userID)
           {
               $_SESSION["loggedIn"] = true;
               $_SESSION["username"] = $name;
               $_SESSION["userID"] = $userID;
               // Redirect logged in user to landing page
               header("Location: ../view/index.php");
           }
           else
           {
               $_SESSION["loggedIn"] = false;
           }
        }
   }
   catch (PDOException $e){
      echo "Error: " . $e->getMessage();
      echo "<br><h1 class='post_notif'>Post failed.</h1>";
   }
?>


<!DOCTYPE html>
<html>
<head>
   <link href="../../css/base_colors.css" rel="stylesheet" />
</head>
<body>
   <?php
      if ($userID) {
         echo "<p class='post_notif'>Login Success</p>";
      } else {
         echo "<p class='post_notif'>Login Failed</p>";
      }
   ?>
</body>
</html>