<?php
/*
   usr_profile.php: shows a given users account information. Whether a user is viewing their own page or another users, it will redirect to this page.
*/

include ("include/session_init.php");

require_once ("../DB/DBConnection.php");
require_once ("../DB/Forum_DB.php");

$db = (new DBConnection());
$db_PDO = $db->connect();
$db_interface = (new PostTable($db_PDO));
$db_interface_u = (new UserTable($db_PDO));

$user = $db_interface_u->get($_GET['u']); //get the info about this user

?>

<!DOCTYPE html>
<html>

<head>
   <title>Tekku - <?=$user->name?>'s Profile</title>

   <link href="../../css/base_style.css" rel="stylesheet" />
   <link href="../../css/post_style.css" rel="stylesheet" />
   <link href="../../css/settings_style.css" rel="stylesheet" />
   <link rel="icon" type="image/x-icon" href="../../favicon.ico" />
</head>
<body>
   <header>
        <?php include 'include/header.php';
        include 'include/post_format_func.php'; ?>
   </header>
   <hr />
   <?php if (!is_null($user->profilePic)): ?> <!-- Show profile pic, if it exists -->
      <img id="profile_pic" alt="profile picture" src="<?=$usr_img_dir . '/' . $user->profilePic ?>" />
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