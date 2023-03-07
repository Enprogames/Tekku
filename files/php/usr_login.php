<!DOCTYPE html>
   <head>
      <link href="../css/base_colors.css" rel="stylesheet" />
      <link rel="icon" type="image/x-icon" href="../favicon.ico" />

      <title>Login - Tekku</title>
   </head>

      <h1 style="text-align: center;">Tekku</h1><hr>

      <div style="margin: auto; width: 300px;">
         <form action="login.inc.php" method="post">
            <label for="name">User Name</label><br/>
            <input type="text" id="name" name="name" required><br/>
            <label for="pw">Password</label><br/>
            <input type="text" id="pw" name="pw" required><br/>
            <input type="submit" id="submit" value="Log in"><br/>
            <hr>
            <a href="create_account.php">Create account</a>
         </form>
      </div>

   </body>
</html>
