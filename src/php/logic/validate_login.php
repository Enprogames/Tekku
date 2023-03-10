<?php
        // Starts a session, allowing access to username over multiple pages
        session_start();

        // Store user login info
        $name = $_POST['name'];
        $password = $_POST['pw'];

        $_SESSION["username"] = $name;

        // Importing necessary classes
        require_once ("../DB/DBConnection.php");
        require_once ("../DB/Forum_DB.php"); //include the forum class info  
                                        
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
            $_SESSION["loggedIn"] = true;
            // Redirect logged in user to landing page
            header("Location: ../view/index.php");
            echo "<p>Login Success</p>";
        }
        else
        {
            $_SESSION["loggedIn"] = false;
            echo "<p>Login Failed</p>";
        }

?>