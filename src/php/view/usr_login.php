<?php

include ("include/session_init.php");

// load environment variables
require ("../DB/LoadEnv.php");
load_dotenv();

if (array_key_exists('DEBUG', $_ENV) && strtolower($_ENV['DEBUG']) == 'true') {
   // Display errors for debugging
   ini_set('display_errors', '1');
   ini_set('display_startup_errors', '1');
   error_reporting(E_ALL);
}

// if not logged in, redirect to login page
if (array_key_exists('loggedIn', $_SESSION)):
   
   header ("Location: ./usr_profile.php?u=" . $_SESSION['userID']);
else:  // ######################### ONLY GO PAST HERE IF LOGGED IN #########################
?>

<!DOCTYPE html>
   <head>
   <?php include 'include/head.php'; ?>

      <title>Login - Tekku</title>
   </head>

      <?php

         include 'include/header.php';
         echo "<hr>";
         // Inform new users that their account has been created successfully
         if (array_key_exists('new_account', $_GET) && $_GET['new_account'] == "true")
         {
            echo "<h3 style = \"color:green; text-align: center\">Account creation successful!</h3>";
         }
      ?>

      <div style="margin: auto; width: 300px;">
         <form action="../logic/validate_login.php" method="post">
            <label for="name">User Name</label><br/>
            <input type="text" id="name" name="name" required><br/>
            <label for="pw">Password</label><br/>
            <input type="password" id="pw" name="pw" required><br/>
            <input type="submit" id="submit" value="Log in"><br/>
            <hr>
            <a href="create_account.php">Create account</a>
         </form>
      </div>

   </body>
</html>

<?php endif; ?>
