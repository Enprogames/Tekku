<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

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

$topic = $db_interface->get($topicID);

?>

<!DOCTYPE html>

<head>
   <link href="../../css/settings_style.css" rel="stylesheet" />
   <link href="../../css/base_colors.css" rel="stylesheet" />
   <link rel="icon" type="image/x-icon" href="../../favicon.ico" />

   <style>

   .postBox{
         border: 2px solid #AA4926;
         height: 250px;
         width: 250px;
         text-align: center;
      }

    .midPostBox{
         padding: 10px;
         display: flex;
    }

    .grandPostBox{
         border: 2px solid brown;
    }

    a.postBoxNoLink{
      text-decoration: none;
      color: black;
      margin: auto;
    }

   </style>

   <title>/<?=$topic->topicID ?> / - <?=$topic->name ?></title>
</head>

<body>
   <header>
      <?php include 'include/header.php' ?>

   </header>
   <hr/>
   <h1 style="text-align: center; text-decoration: underline;">/<?=$topic->topicID ?>/ - <?=$topic->name ?></h1>
   <p><?=$topic->description ?></p>
   <hr />
      <?php
         include 'include/post_box.php';
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
      for($i = 0; $i < 25 && $index < count($posts); $i++){
         echo "<div class='midPostBox'>";
         for($j = 0; $j < 4 && $index < count($posts); $j++){
            $post_obj = $posts[$index];
            $shortened_content = first_part($post_obj->content);
            // if this post has no user, then the value is null and thus evaluated to false
            $username = ($post_obj->userID) ? $post_obj->userID : "Anonymous";
            echo "<a class='postBoxNoLink' href='view_post.php?t=$topic->topicID&p=$post_obj->postID'>
                  <div class='postBox'>
                  <p>{$post_obj->postID} - {$username} - {$post_obj->createdAt}</p>
                  <p>{$shortened_content}</p>
               </div></a>";
            $index++;
         }
         echo "</div>";
      }

      ?>
   </div>
</body>

</html>