<?php
/** view_post.php
 * Presents a single post to a user. They will likely reach this page after being on a topic and clicking a post.
 * Also shows comments for the post.

 * Since a post is associated with a topic, the URL for a post will look like the following:
 *     `example.com/view_post.php/t="tec"&p=5`
 * This will give post number 5 in the Technology topic.
 */

// Start session at top of file
include ("include/session_init.php");

// Display errors for debugging
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once ("../DB/DBConnection.php");
require_once ("../DB/Forum_DB.php");

$db = (new DBConnection());
$db_PDO = $db->connect();

if (!(array_key_exists('t', $_GET) or array_key_exists('p', $_GET))) {
    die("Provide a topic and post");
}

$topicID = $_GET['t'];
$postID = $_GET['p'];

$db_interface = (new PostTable($db_PDO));
$db_interface_u = (new UserTable($db_PDO));
$usr_img_dir = $_ENV['USER_POST_IMAGE_DIR'];

?>

<!DOCTYPE html>

<html>
<head>
    <title>Tekku</title>
    <link href="../../css/base_style.css" rel="stylesheet" />
    <link href="../../css/post_style.css" rel="stylesheet">
    <link href="../../css/settings_style.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../../favicon.ico" />

    <style>
       #commentFlex {
         display: flex;
         justify-content:space-between;
       }
    </style>

   <?php include 'include/header.php';
   include 'include/post_format_func.php'; ?>

</head>

<body>
    <script>

       function comment_reply(postID){
         var post_box = document.getElementById('float_post'); //get the ID of the floating post
         var display_opt = post_box.style.display;

         var post_body = document.getElementById('body');
         var at = "@";
         post_body.value = at.concat(postID);

         if (display_opt == 'none') {
            post_box.style.display = 'block';
         }
       }

       function new_comment() {
       	var post_box = document.getElementById('page_post');
       	var display_opt = post_box.style.display;

       	if(display_opt == 'none'){
       	   post_box.style.display = 'block';
       	}
       }

    </script>

    <div class="content">

        <?php try {
            $post = $db_interface->read($postID, $topicID);
            echo "<div id='{$postID}' class='post-container'>";
            ?>

                <!-- Get post content from database -->
                <div class="post-header">
                    <h1 class="post-header-item"><?=$post->postID?>
                    <h2 class="post-header-item"><?=$post->createdAt?>
                    <h2 class="post-header-item"><?=$post->title?>
                    <h3 class="post-header-item">user:
                    <?php if ($post->userID){
                        echo "<a class='linkAdjacent' href='usr_profile.php?u=" . $post->userID . "'>" . $db_interface_u->get($post->userID)->name . "</a>";
                        }
                        else { echo "Anonymous";
                     }?><br>
                </div>
                <div class="post-content">
                    <img style='max-width: 500px; max-width:500px; padding: 5px;' src='../../<?=$usr_img_dir ?>/<?=$post->image?>'>
                    <?php
                      echo "<p>" . post_regex($post, $db_interface)  . "</p>";
                    ?>
                </div>
            </div>

            <?php
               $refID = $postID;

               echo "<div id='float_post' style='display:none; background-color:#F3F6BC; z-index: 1; position: fixed; right: 0; bottom: 0;>";
                  include 'include/post_box.php';
               echo "</div>";

               if(!$db_interface->comment_count_n($topicID, $refID)){
                  echo "<div style='display: block; margin: auto; width: 100px;'>";
                  echo "<button onclick='new_comment()'>Create Post</button>";
                  echo "<div style='display: none;' id='page_post'>";
                  include 'include/post_box.php';
                  echo "</div>";
                  echo "</div>";
               }
               else{
                  echo "<h1 class='post_notif'>[Thread locked]</h1>";
               }
            ?>

            <h3 class="comments-title">Comments</h3>
            <div class="comments-container">
                <?php
                   $posts = $db_interface->read_comment($postID, $topicID);

                   foreach ($posts as $post) {
                      post_format($post, $db_interface_u, $db_interface);
                   }
                ?>
            </div>

        <?php } catch (ItemNotFoundException $e) { ?>
            <p><?=$e->getMessage()?></p>
        <?php } ?>
        <?php
        $db_PDO = null;
        ?>
    </div>
</body>

</html>
