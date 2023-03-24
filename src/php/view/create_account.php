<?php
         require_once ("../DB/DBConnection.php");
         require_once ("../DB/Forum_DB.php");
         // Creating a new instance of the DBConnection class
         $db = (new DBConnection());
         // Creating a PDO connection to the database
         $db_PDO = $db->connect();
?>

<!DOCTYPE html>
   <head>
      <link href="../../css/base_colors.css" rel="stylesheet" />
      <link rel="icon" type="image/x-icon" href="../../favicon.ico" />

      <title>Create Account - Tekku</title>
   </head>

   <body>
      <h1 style="text-align: center;">Tekku</h1><hr>

      <?php
         // The user was not redirected so the account creation failed, prompt for a new username
         if($_SERVER["REQUEST_METHOD"] == "POST")
         {
            echo "<h3 style = \"color:red; text-align: center\">Account creation failed. Username already taken</h3>";
         }
      ?>

      <div style="margin: auto; width: 300px;">
         <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <label for="name">User Name</label><br/>
            <input type="text" id="name" name="name"><br/>
            <label for="pw">Password</label><br/>
            <input type="password" id="pw" name="pw"><br/>
            <label for="email">Email</label><br/>
            <input type="text" id="email" name="email"><br/><br/>
            <input type="submit" value="Create Account"><br/>
            <hr>
         </form>
      </div>

   </body>
</html>

<?php
      if($_SERVER["REQUEST_METHOD"] == "POST")
      { 
         // Getting input data from the user through POST method
         $name = $_POST['name'];
         $password = $_POST['pw'];
         $email = $_POST['email'];

         // Creating a new instance of the UserTable class
         $db_interface = (new UserTable($db_PDO));

         // Using the create_account method of UserTable class to create a new user account
         $success = $db_interface->create_account($name, $password, $email);

         // The username was not a duplicate, allow the user to create the account
         if ($success)
         {
            header("Location: usr_login.php?new_account=true");
         }
      }
?>