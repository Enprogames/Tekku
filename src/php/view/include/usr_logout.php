<?php

session_start();
// Unset all the session variables
session_unset();
// Kill the session
session_destroy();

// Redirect logged out user back to main page
header("Location: ../index.php");
?>