<?php
     
        // Store user login info
        $name = $_POST['name'];
        $password = $_POST['pw'];

        // Importing necessary classes
        require_once ("../../src/DB/DBConnection.php");
        require_once ("../../src/DB/Forum_DB.php"); //include the forum class info  
                                        
        // Create connection to database
        $db = (new DBConnection());
        $db_PDO = $db->connect();

        // Provide direct interaction with usertable
        $db_interface = (new UserTable($db_PDO));

        // Check if login credentials are valid
        $valid = $db_interface->login($name, $password);
        
        // (TEMP) tell user if login worked
        if ($valid)
        {
            echo "<p>Login Success</p>";
        }
        else
        {
            echo "<p>Login Failed</p>";
        }

?>