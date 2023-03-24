<?php

include ("include/session_init.php");

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
            <textarea id="description" name="description"><?= (!is_null($user->profilePic)) ? ($user->description) : ("") ?></textarea>
            <br><input type="submit" value="Change profile description">
        <form>
    </p>

</body
<?php endif ?>
