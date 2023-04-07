<?php

include ("include/session_init.php");

// load environment variables
require ("../DB/LoadEnv.php");
load_dotenv();

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
require_once ("../logic/upload_file.php");

$db = (new DBConnection());
$db_PDO = $db->connect();
$user_table = (new UserTable($db_PDO));

$user = $user_table->get($userID);

?>

<!DOCTYPE html>

<html>
<head>
    <?php include 'include/head.php'; ?>

    <title>Tekku</title>
</head>
<body>
    <header>
        <?php include 'include/header.php' ?>
    </header>

    <hr />
    <h1 class="main_title">Account Settings</h1>
    <?php
    // ################################ Change account details if a form was submitted #########################

    // #### USERNAME CHANGE ####
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

    // #### PASSWORD CHANGE ####
    if (array_key_exists('passwd', $_POST) && array_key_exists('passwd_conf', $_POST)) {
        $password = $_POST['passwd'];
        $pass_conf = $_POST['passwd_conf'];
        if ($password == $pass_conf && $user_table->change_password($userID, $password)) {
            echo "<h1 class=\"alert_text\">Password successfully changed. You will now be logged out.</h1>";
            log_out();
            echo "<meta http-equiv='refresh' content=\"3; url='{$_SERVER['PHP_SELF']}'\">";
        } else if ($password != $pass_conf) {
            echo "<p class=\"alert_text\">Passwords don't match</p>";
        } else {
            echo "<p class=\"alert_text\">Error occurred while changing password.</p>";
        }
    } else if (array_key_exists('passwd', $_POST) || array_key_exists('passwd_conf', $_POST)){
        echo "<p>Passwords don't match.</p>";
    }

    // #### PROFILE PICTURE CHANGE ####
    if (array_key_exists("attachment", $_FILES) && !($_FILES['attachment']['error'] == 4) && !($_FILES['attachment']['size'] == 0 && $_FILES['attachment']['error'] == 0)) {
        $file = $_FILES['attachment'];
        $file_name = upload_profile_image($userID);
        $usr_img_dir = $_ENV['USER_POST_IMAGE_DIR'];
        
        $old_filename = $user->profilePic;
        if ($file_name
                && chmod("../../{$usr_img_dir}/" . $file_name, 0777)
                && $user_table->change_picture_filename($userID, $file_name)) {

            // delete the user's old profile picture if they have done
            if (!is_null($old_filename) && !empty($old_filename)) {
                delete_image($old_filename);
            }
            echo "<p class=\"alert_text\">Profile picture successfully changed.</p>";
            echo "<meta http-equiv='refresh' content=\"2; url='{$_SERVER['PHP_SELF']}'\">";
        } else {
            echo "<p class=\"alert_text\">Error occurred while changing profile picture.</p>";
        }
    } else if (array_key_exists("attachment", $_FILES)) {
        echo "<p class=\"alert_text\">The provided was invalid.</p>";
    }

    // #### PROFILE DESCRIPTION CHANGE ####
    if (array_key_exists('description', $_POST) && !empty($_POST['description'])) {
        $description = htmlspecialchars($_POST['description']);
        if ($user_table->change_description($userID, $description)) {
            echo "<p class=\"alert_text\">Profile description successfully changed.</p>";
        } else {
            echo "<p class=\"alert_text\">Error occurred while changing profile description.</p>";
        }
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
            <img id="profile_pic" alt="profile picture" src="<?= '../../' . $usr_img_dir . '/' . $user->profilePic ?>" />
        <?php endif ?>
        <form enctype='multipart/form-data' action="<?=$_SERVER['PHP_SELF'] ?>" method="post">
            <label for="attachment">Upload image: </label>
            <input type='file' name='attachment' accept='image/*' /><br>
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
