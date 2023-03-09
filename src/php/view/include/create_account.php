<!DOCTYPE html>
   <head>
      <link href="../../../css/base_colors.css" rel="stylesheet" />
      <link rel="icon" type="image/x-icon" href="../../../favicon.ico" />

      <title>Create Account - Tekku</title>
   </head>

   <body>
      <h1 style="text-align: center;">Tekku</h1><hr>

      <div style="margin: auto; width: 300px;">
         <form action="../account_success.php" method="post">
            <label for="name">User Name</label><br/>
            <input type="text" id="name" name="name"><br/>
            <label for="pw">Password</label><br/>
            <input type="text" id="pw" name="pw"><br/>
            <label for="email">Email</label><br/>
            <input type="text" id="email" name="email"><br/><br/>
            <input type="submit" value="Create Account"><br/>
            <hr>
         </form>
      </div>

   </body>
</html>