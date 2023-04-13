<?php
   try{
        // Starts a session, allowing access to username over multiple pages
        session_start();

        // load environment variables
        require ("../DB/LoadEnv.php");
        load_dotenv();

        // Store user login info
        $name = $_POST['name'];
        $password = $_POST['pw'];

        // Importing necessary classes
        require_once ("../DB/DBConnection.php");
        require_once ("../DB/Forum_DB.php"); //include the forum class info
        require_once ("validate_input.php");

        ?>
        <head>
            <link href="../../css/base_style.css" rel="stylesheet" />
        </head>
        <?php

        if(!clean_name_input($name)){ //if the name is bad data
           echo "<h1 class='post_notif'>Username has illegal characters.<h1>";
           echo "<meta http-equiv='refresh' content=\"1; url='../view/usr_login.php'\">";
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
               echo "<h1>Login Success</h1>";
               echo "<meta http-equiv='refresh' content=\"1; url='../view/index.php'\">";
           }
           else
           {
               $_SESSION["loggedIn"] = false;
               echo "<h1>Login Fail</h1>";
               echo "<meta http-equiv='refresh' content=\"1; url='../view/usr_login.php'\">";
           }
        }
   }
   catch (PDOException $e){
      echo "Error: " . $e->getMessage();
      echo "<br><h1 class='post_notif'>Post failed.</h1>";
   }
?>