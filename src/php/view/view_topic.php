<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// start session at top of file
include ("include/session_init.php");

require_once ("../DB/DBConnection.php");
require_once ("../DB/Forum_DB.php");

$db = (new DBConnection());
$db_PDO = $db->connect();

if (!array_key_exists('t', $_GET)) {
      die("Provide a topic");
}

$topicID = $_GET['t'];
// refID is used to reference the parent of a post for a comment. for regular posts, this will be set to null.
// this goes into post_box.php, which calls comment.php
$refID = null;

$db_interface = (new TopicTable($db_PDO));
$db_interface_u = (new UserTable($db_PDO));
$usr_img_dir = $_ENV['USER_POST_IMAGE_DIR'];

$topic = $db_interface->get($topicID);

?>

<!DOCTYPE html>

<head>
   <link href="../../css/settings_style.css" rel="stylesheet" />
   <link href="../../css/base_style.css" rel="stylesheet" />
   <link rel="icon" type="image/x-icon" href="../../favicon.ico" />

   <style>

    .postBox{
         padding: 2px;
         height: auto;
         width: 250px;
         text-align: center;
    }

    .midPostBox{
         padding: 10px;
         display: flex;
    }

    .grandPostBox{
         padding: 2px;
         display: flex;
         flex-wrap: wrap;
    }

   </style>

   <title>/<?=$topic->topicID ?> / - <?=$topic->name ?></title>
</head>

<body>
   <header>
      <?php
      include 'include/header.php';

      if(isset($_SESSION["loggedIn"]) && $db_interface_u->is_admin($_SESSION["userID"], $topicID)) { //if the user is logged in and is an admin, enter admin mode
         echo "<p style='color: red; text-align: right;'>!! ADMIN MODE !!</p>";
      }
      ?>

      <script>
         function new_comment() {
          	var post_box = document.getElementById('page_post');
          	var display_opt = post_box.style.display;

          	if(display_opt == 'none'){
          	   post_box.style.display = 'block';
          	}
          }
      </script>
   </header>
   <hr/>
   <h1 style="text-align: center; text-decoration: underline;">/<?=$topic->topicID ?>/ - <?=$topic->name ?></h1>
   <p><?=$topic->description ?></p>
   <hr/>
      <?php
         echo "<div style='display: block; margin: auto; width: 100px;'>";
         echo "<button onclick='new_comment()'>Create Post</button>";
         echo "<div style='display: none;' id='page_post'>";
         include 'include/post_box.php';
         echo "</div>";
         echo "</div>";
      ?>
   <hr/>

   <div class="grandPostBox">
      <?php

      /**
        * Given a string, return the first $limit characters of it
     * @param int $str The string to
     * @param int $limit How many characters of the string to return. Defaults to 200.
     * @return string First $limit characters of the given string
     */
      function first_part($str, $limit = 200) {
         if (strlen($str) <= $limit) {
            return $str;
         } else {
            return substr($str, 0, $limit-3) . "...";
         }
      }

      $posts = $db_interface->get_posts($topicID);

      $index = 0;

      for($i = 0; $i < 100 && $index < count($posts); $i++){
         $post_obj = $posts[$index];
         $shortened_content = first_part($post_obj->content);
         // if this post has no user, then the value is null and thus evaluated to false
         $username = ($post_obj->userID) ? $db_interface_u->get($post_obj->userID)->name : "Anonymous";
         echo "<a class='clickable' href='view_post.php?t=$topic->topicID&p=$post_obj->postID'>
               <div class='postBox'>
               <img style='max-height:200 px; max-width: 200px; padding: 5px;' src='../../{$usr_img_dir}/$post_obj->image'><br>
               <p>{$username} - {$post_obj->createdAt} - {$post_obj->postID}</p>
               <p>{$shortened_content}</p>
            </div></a>";
         $index++;
      }

      ?>
   </div>
</body>

</html>
