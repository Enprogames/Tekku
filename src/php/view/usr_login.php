<!DOCTYPE html>
   <head>
      <link href="../../css/base_colors.css" rel="stylesheet" />
      <link rel="icon" type="image/x-icon" href="../../favicon.ico" />
      <link href="../../css/settings_style.css" rel="stylesheet" />

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
