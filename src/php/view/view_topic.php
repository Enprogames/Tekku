<?php
// start session at top of file
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

if (!array_key_exists('t', $_GET)) {
      die("Provide a topic");
}

$topicID = $_GET['t'];
// refID is used to reference the parent of a post for a comment. for regular posts, this will be set to null.
// this goes into post_box.php, which calls comment.php
$refID = null;

$topic_table = (new TopicTable($db_PDO));
$user_table = (new UserTable($db_PDO));
$post_table = (new PostTable($db_PDO));
$usr_img_dir = $_ENV['USER_POST_IMAGE_DIR'];

$topic = $topic_table->get($topicID);

?>

<!DOCTYPE html>

<head>
   <?php include 'include/head.php'; ?>

   <title>/<?=$topic->topicID ?> / - <?=$topic->name ?></title>
</head>

<body>
   <header>
      <?php
      include 'include/header.php';

      if(array_key_exists('del', $_GET) && $_GET['del'] == "true") { 
         echo "<p style='color: red; text-align: ceneter;'>POST DELETED</p>";
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

      $posts = $topic_table->get_posts($topicID);

      $index = 0;

      for($i = 0; $i < 100 && $index < count($posts); $i++){
         $post_obj = $posts[$index];
         $shortened_content = first_part($post_obj->content);
         // if this post has no user, then the value is null and thus evaluated to false
         $username = ($post_obj->userID) ? $user_table->get($post_obj->userID)->name : "Anonymous";
         $comment_count = $post_table->comment_count($topicID, $post_obj->postID);
         echo "<a class='nolink' href='view_post.php?t=$topic->topicID&p=$post_obj->postID'>
               <div class='postBox'>
               <img style='max-height:200 px; max-width: 200px; padding: 5px;' src='../../{$usr_img_dir}/$post_obj->image'><br>
               <p>{$username} - {$post_obj->createdAt} - {$post_obj->postID} </p>
               <p>Posts: {$comment_count}</p>
               <p>{$shortened_content}</p>
            </div></a>";
         $index++;
      }

      ?>
   </div>
</body>

</html>
