<?php
/*
   usr_profile.php: shows a given users account information. Whether a user is viewing their own page or another users, it will redirect to this page.
*/

include ("include/session_init.php");

// load environment variables
require ("../DB/LoadEnv.php");
load_dotenv();

if (array_key_exists('DEBUG', $_ENV) && strtolower($_ENV['DEBUG']) == 'true') {
   // Display errors for debugging
   ini_set('display_errors', '1');
   ini_set('display_startup_errors', '1');
   error_reporting(E_ALL);
}

require_once ("../DB/DBConnection.php");
require_once ("../DB/Forum_DB.php");

$db = (new DBConnection());
$db_PDO = $db->connect();
$db_interface = (new PostTable($db_PDO));
$db_interface_u = (new UserTable($db_PDO));

if (!array_key_exists('u', $_GET)) {
   die("Provide a user ID");
}

$user = $db_interface_u->get($_GET['u']); //get the info about this user
$usr_img_dir = $_ENV['USER_POST_IMAGE_DIR'];

?>

<!DOCTYPE html>
<html>

<head>
   <?php include 'include/head.php'; ?>

   <title>Tekku - <?=$user->name?>'s Profile</title>
</head>
<body>
   <header>
        <?php include 'include/header.php';
        include 'include/post_format_func.php'; ?>
   </header>
   <hr />
   <?php if (!is_null($user->profilePic)): ?> <!-- Show profile pic, if it exists -->
      <img id="profile_pic" alt="profile picture" src="<?='../../' . $usr_img_dir . '/' . $user->profilePic ?>" />
   <?php endif ?>

   <h1 class="main_title" style="text-align: left;"><?=$user->name?>'s Profile</h1>
   <h5 style="text-align: left; position: relative; bottom: 20px;">User since <?=$user->creationTime?></h5>

   <?php if (!is_null($user->description)): ?> <!-- Show description, if it exists -->
      <p> Description: <br> <?=$user->description ?> </p>
   <?php endif ?>

   <h2 class="main_title" style="text-align: left;">Post feed:</h2>

   <div class="comments-container">
   <?php
      $posts = $db_interface->get_post_user($_GET['u']);

      foreach ($posts as $post) {
         post_format($post, $db_interface_u, $db_interface);
      }
   ?>
   </div>



</body>

</html>