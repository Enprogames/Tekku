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
$db_interface_u = (new UserTable($db_PDO))
?>

<!DOCTYPE html>

<html>
<head>
    <title>Tekku</title>
    <link href="../../css/base_colors.css" rel="stylesheet" />
    <link href="../../css/post_style.css" rel="stylesheet">
    <link href="../../css/settings_style.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../../favicon.ico" />

    <style>
       a.postBoxNoLink{
         text-decoration: none;
         color: black;
         margin: auto;
       }
    </style>

   <?php include 'include/header.php' ?>

</head>

<body>

    <?php
    function post_format($post_obj, $db_interface_u){
       $username = ($post_obj->userID) ? $db_interface_u->get($post_obj->userID)->name : "Anonymous";
       echo "<div class='comment-container'>"; //$username = ($post_obj->userID) ? $db_interface_u->get($post_obj->userID)->name : "Anonymous";
       echo "<p>" . $username . " || " . $post_obj->createdAt . " || " . $post_obj->postID . "</p><br>";
       if($post_obj->image){
         echo "<img style='max-width: 500px; max-width:500px; padding: 5px;' src='../../../user_posted_images/" . $post_obj->image . "'><br>";
       }
       echo "<p>" . $post_obj->title . "</p>";
       echo "<p>" . $post_obj->content . "</p>";
       echo "</div>";
    }
    ?>

    <div class="content">


        <?php try {
            $post = $db_interface->read($postID, $topicID);
            ?>
            <div class="post-container">
                <!-- Get post content from database -->
                <div class="post-header">
                    <h1 class="post-header-item"><?=$post->postID?>
                    <h2 class="post-header-item"><?=$post->createdAt?>
                    <h2 class="post-header-item"><?=$post->title?>
                    <!--deal with name -->
                    <h3 class="post-header-item">user: <?=($post->userID) ? $db_interface_u->get($post->userID)->name : "Anonymous"?><br>
                </div>
                <div class="post-content">
                    <img style='max-width: 500px; max-width:500px; padding: 5px;' src='../../../user_posted_images/<?=$post->image?>'>
                    <p><?=$post->content?></p>
                </div>
            </div>

            <?php
               $refID = $postID;

               if(!$db_interface->comment_count_n($topicID, $refID)){
                  if(isset($_POST['post_button'])){
                     include 'include/post_box.php';
                  }
                  else{
                     echo "<div style='display: block; margin: auto; width: 100px; '>";
                     echo "<form method='post'>";
                     echo "<input type='submit' name='post_button' value='Create Post' />";
                     echo "</form>";
                     echo "</div>";
                  }
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
                      post_format($post, $db_interface_u);
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
