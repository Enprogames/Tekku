<!DOCTYPE html>
   <head>
      <link href="../../css/base_colors.css" rel="stylesheet" />
      <link rel="icon" type="image/x-icon" href="../../favicon.ico" />

      <title>Thank You</title>
   </head>

   <body>

   <p>Welcome <?php echo $_POST['name']; ?> </p>

   <?php
      // Importing necessary classes
      require_once ("../DB/DBConnection.php");
      require_once ("../DB/Forum_DB.php");

      // Creating a new instance of the DBConnection class
      $db = (new DBConnection());

      // Creating a PDO connection to the database
      $db_PDO = $db->connect();

      // Getting input data from the user through POST method
      $name = $_POST['name'];
      $password = $_POST['pw'];
      $email = $_POST['email'];



      // Creating a new instance of the UserTable class
      $db_interface = (new UserTable($db_PDO));

      // Using the create_account method of UserTable class to create a new user account
      $db_interface->create_account($name, $password, $email);
   ?>

   </body>
</html>