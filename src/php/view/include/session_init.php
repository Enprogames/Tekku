<?php
// Starts a session, allowing access to username over multiple pages
if (session_id() === '')
{
   session_start();
}

// Set default username
$username = "Anonymous";

// If we are logged in, change the username
if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
   $username = $_SESSION["username"];
}
