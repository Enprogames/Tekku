<?php

include ("include/session_init.php");

function log_out() {
    // Unset all the session variables
    session_unset();
    // Kill the session
    session_destroy();
}

if (array_key_exists('DEBUG', $_ENV) && strtolower($_ENV['DEBUG']) == 'true') {
    // Display errors for debugging
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

// if not logged in, redirect to login page
if (!array_key_exists('loggedIn', $_SESSION)):
    header ('Location: ./usr_login.php');
else:  // ######################### ONLY GO PAST HERE IF LOGGED IN #########################
$userID = $_SESSION['userID'];
$username = $_SESSION['username'];
$usr_img_dir = $_ENV['USER_POST_IMAGE_DIR'];

require_once ("../DB/DBConnection.php");
require_once ("../DB/Forum_DB.php");

$db = (new DBConnection());
$db_PDO = $db->connect();
$user_table = (new UserTable($db_PDO));

$user = $user_table->get($userID);

?>

<!DOCTYPE html>

<html>
<head>
    <title>Tekku</title>
    
    <link href="../../css/base_colors.css" rel="stylesheet" />
    <link href="../../css/settings_style.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../../favicon.ico" />

</head>
<body>
    <header>
        <?php include 'include/header.php' ?>
   </header>
    <hr />
    <h1 class="main_title">Account Settings</h1>
    <?php
    // ################################ Change account details if a form was submitted #########################

    // #### USERNAME CHANGE
    if (array_key_exists('uname', $_POST)) {
        // try to change username. return whether it was successful.
        $new_name = $_POST['uname'];
        $name_exists = $user_table->name_exists($new_name);
        if ($new_name != $username && !$name_exists && $user_table->change_name($userID, $new_name)) {
            $_SESSION['username'] = $new_name;
            $username = $_SESSION['username'];
            echo "<p>Successfully changed username. You are now {$new_name}.</p>";
        } else if ($new_name == $username) {
            echo "<p>{$new_name} is already your username.</p>";
        } else if ($name_exists) {
            echo "<p>The username {$new_name} is already taken by another user whose name is {$new_name}.</p>";
        } else {
            echo "<p>Error occurred while changing username.</p>";
        }
    }
    if (array_key_exists('passwd', $_POST) && array_key_exists('passwd_conf', $_POST)) {
        $password = $_POST['passwd'];
        $pass_conf = $_POST['passwd_conf'];
        if ($password == $pass_conf && $user_table->change_password($userID, $password)) {
            echo "<h1 style=\"color: red\">Password successfully changed. You will now be logged out.</h1>";
            log_out();
            header("Refresh:3");

        } else if ($password != $pass_conf) {
            echo "<p style=\"color: red\">Passwords don't match</p>";
        } else {
            echo "<p style=\"color: red\">Error occurred while changing password.</p>";
        }
    } else if (array_key_exists('passwd', $_POST) || array_key_exists('passwd_conf', $_POST)){
        echo "<p>Passwords don't match.</p>";
    }
    ?>


    <p>Currently logged in as <?=$username ?></p>
    <p>
        <form action="<?=$_SERVER['PHP_SELF'] ?>" method="post">
            <label for="uname">Username: </label>
            <input type="username" id="uname" name="uname">
            <input type="submit" value="Change username">
        </form>
    </p>
    <p>
        <form action="<?=$_SERVER['PHP_SELF'] ?>" method="post">
            <label for="passwd">Password: </label>
            <input type="password" id="passwd" name="passwd"><br>
            <label for="passwd">Confirm: </label>
            <input type="password" id="passwd_conf" name="passwd_conf">
            <input type="submit" value="Change password">
        </form>
    </p>
    <hr>
    <p>
        <p>Profile picture:</p>
        <?php if (!is_null($user->profilePic)): ?>
            <img id="profile_pic" alt="profile picture" src="<?=$usr_img_dir . '/' . $user->profilePic ?>" />
        <?php endif ?>
        <form action="<?=$_SERVER['PHP_SELF'] ?>" method="post">
            <label for="attachment">Upload image: </label>
            <input type='file' name='attachment' accept='.gif, .jpg, .png .jpeg' /><br>
            <input type="submit" value="Change profile picture" />
        </form>
    </p>
    <hr>
    <p>
        <p>Profile description: </p>
        <form action="<?=$_SERVER['PHP_SELF'] ?>" method="post">
            <textarea id="description" name="description"><?= ((!is_null($user->description)) ? ($user->description) : ("")) ?></textarea>
            <br><input type="submit" value="Change profile description">
        <form>
    </p>

</body
<?php endif ?>
