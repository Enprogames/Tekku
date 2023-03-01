<!-- view_post.php
Presents a single post to a user. They will likely reach this page after being on a topic and clicking a post.
Also shows comments for the post.

Since a post is associated with a topic, the URL for a post will look like the following:
    `example.com/view_post.php/t="tec"&p=5`
This will give post number 5 in the Technology topic.
 -->

 <!DOCTYPE html>

<html>
<head>
    <title>Tekku</title>
    <link href="../css/base_colors.css" rel="stylesheet" />

    <!-- ## Temporary style for this page. Should be put into separate stylesheet when we reach that phase. ## -->
    <style>
        .content {

        }
        .post-container {
            border: 1px solid black;
        }
        .post-header {
            display: flex;
            justify-content: space-between;
            margin: 10px;
            padding: 10px;
        }
        .post-header-item {
            margin: 10px;
        }
        .post-content {
            margin: 10px;
            padding: 10px;
        }
        .comments-container {
            margin: 10px;
            border: 1px solid black;
            padding: 10px;
        }
        .comment-container {
            margin: 10px;
            border: 1px solid black;
            padding: 10px;
        }
        .comment-user {

        }
    </style>

</head>

<body>

    <?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

    require_once ("../../src/DB/DBConnection.php");
    require_once ("../../src/DB/Forum_DB.php");

    $db = (new DBConnection());
    $db_PDO = $db->connect();
    
    if (!(array_key_exists('t', $_GET) or array_key_exists('p', $_GET))) {
        die("Provide a topic and post");
    }

    $topicID = $_GET['t'];
    $postID = $_GET['p'];

    $db_interface = (new PostTable($db_PDO));
    ?>

    <div class="content">


        <?php try {
            $post = $db_interface->read($postID, $topicID);
            ?>
            <div class="post-container">
                <!-- Get post content from database -->
                <div class="post-header">
                    <h1 class="post-header-item"><?=$post->postID?>
                    <h2 class="post-header-item"><?=$post->title?>
                    <!-- TODO: After we create users, we should use joins to retrieve the user and return their username or NULL -->
                    <h3 class="post-header-item">user: <?=$post->userID?>
                    <!-- TODO: Figure out how to show images. -->
                    <!-- <h3 class="post-header-item"><?=$post->image?> -->
                </div>
                <div class="post-content">
                    <p><?=$post->content?></p>
                </div>
            </div>

            <h3 class="comments-title">Comments</h3>

            <!-- TODO: Get comments for this post and return all of them -->
            <div class="comments-container">
                <?php for ($i=0; $i<10; $i++): ?>
                    <div class="comment-container">
                        <p class="comment-user">User <?=$i?></p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                <?php endfor ?>
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