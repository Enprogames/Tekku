<!DOCTYPE html>

<head>
    <title>Tekku</title>
    <link href="../../css/base_colors.css" rel="stylesheet" />
</head>

<body>

   <?php

      /*
         On call, create and insert a main post into the DB

         $file, name of the file to be inserted
         $curr_post, post object for post creation
         $db_pdo, the database PDO object
         $userID, ID of the user creating the post
         $board, the board ID the post belongs to
         $body, the text body of the post
         $title, the title of the post

         returns nothing on completion. will show error screens if user does not enter the required info, or success screen if post was a success.
      */
      function create_post($file, $curr_post, $db_PDO, $userID, $board, $body, $title){
            if ($file != NULL) {  // if there is an image attached, proceed as normal

               $curr_post = (new PostTable($db_PDO));  //create post object
               $file_name = upload_post_image();
               $maxAc = $curr_post->get_max_activity($board) + 1; //get the highest activity counter. add 1 for this post
               $usr_img_dir = $_ENV['USER_POST_IMAGE_DIR'];
               if ($file_name && chmod("../../{$usr_img_dir}/" . $file_name, 0777)) {
                  $post_obj = $curr_post->create($userID, $board, null, $file_name, $body, $title, null, $maxAc); //create post: $userID, $topicID, $createdAt, $image, $content, $title. time is null so it defaults to current time of post
                  $postID = $db_PDO->lastInsertID();
                  echo "<h1 class='post_notif'>$file_name was successfully posted!</h1>"; //tell the user the post succeeded
                  echo "<meta http-equiv='refresh' content=\"2; url='../view/view_post.php?t={$board}&p=$postID'\">";
               } else {
                  echo "<h1 class='post_notif'>Error: File not uploaded.</h1>";
                  echo "<meta http-equiv='refresh' content=\"2; url='../view/view_topic.php?t=$board'\">";
               }
            } else { //otherwise no image. error
               echo "<h1 class='post_notif'>Error: No file attached.</h1>";
               echo "<meta http-equiv='refresh' content=\"2; url='../view/view_topic.php?t=$board'\">";
            }
      }

      /*
         On call, create and insert a comment into the DB

         $file, name of the file to be inserted
         $curr_post, post object for post creation
         $db_pdo, the database PDO object
         $userID, ID of the user creating the post
         $board, the board ID the post belongs to
         $body, the text body of the post
         $title, the title of the post
         $refID, the ID of the post the comment belongs to

         returns nothing on completion. will show error screens if user does not enter the required info, or success screen if post was a success.
      */

      function create_comment($file, $curr_post, $db_PDO, $userID, $board, $body, $title, $refID){
         
         
         if($curr_post->comment_count_n($board, $refID)){ //if the limit is reached
               echo "<h1 class='post_notif'>[Thread Locked]</h1>";
            } else {
               if ($body != NULL || $file != NULL) { //if there is something in the body or there's a file
                  $curr_post = (new PostTable($db_PDO)); //create post object
                  if ($file != NULL) { //if file
                     $file_name = upload_post_image();
                     $usr_img_dir = $_ENV['USER_POST_IMAGE_DIR'];
                     if ($file_name && chmod("../../{$usr_img_dir}/" . $file_name, 0777)) {
                        $curr_post->create($userID, $board, null, $file_name, $body, $title, $refID, null); //create post: $userID, $topicID, $createdAt, $image, $content, $title. time is null so it defaults to current time of post
                        $curr_post->increase_activity($refID); //increase the activity for this comments REF post
                        echo "<h1 class='post_notif'>Image comment success.</h1>";
                     } else {
                        echo "<h1 class='post_notif'>Error: File invalid.</h1>";
                     }
                  } else {
                     $curr_post->create($userID, $board, null, null, $body, $title, $refID, null); //create post: $userID, $topicID, $createdAt, $image, $content, $title. time is null so it defaults to current time of post
                     $curr_post->increase_activity($refID); //increase the activity for this comments REF post
                     echo "<h1 class='post_notif'>Comment success</h1>";
                  }
               }
               else{//otherwise do nothing
                  echo "<h1 class='post_notif'>Error: No text entered.</h1>";
               }
            }
            echo "<meta http-equiv='refresh' content=\"2; url='../view/view_post.php?t={$board}&p=$refID'\">";
      }

      ini_set('display_errors', '1');
      ini_set('display_startup_errors', '1');
      error_reporting(E_ALL);

      require_once ("../DB/DBConnection.php");
      require_once ("validate_input.php");
      require_once ("../DB/Forum_DB.php"); //include the forum class info
      require_once ("upload_file.php");

      try{
         $db = (new DBConnection()); //db is now a new DBconnection object
         $db_PDO = $db->connect(); //db_PDO is the returned PDO after successful connection

         //get the post info
         $name = clean_name_input($_POST["name"]); //gets the name of the user who posted
         $body = htmlspecialchars($_POST["body"]); //gets the contents of the body
         $board = $_POST["topicID"]; //gets the board the post is coming from
         $title = htmlspecialchars($_POST["title"]); //get the title of the post
         // if a file was uploaded, store its name. otherwise, null
         if (!array_key_exists("attachment", $_FILES) || $_FILES['attachment']['error'] == 4 || ($_FILES['attachment']['size'] == 0 && $_FILES['attachment']['error'] == 0)) {
            // cover_image is empty (and not an error), or no file was uploaded
            $file = NULL;
         } else {
            $file = $_FILES['attachment'];
         }
         // $file = (array_key_exists("attachment", $_FILES)
         //          && array_key_exists("attachment", $_FILES["attachment"])) ? $_FILES["attachment"] : null;

         $refID = $_POST["refID"]; //if this is a main post, it has no reference ID
         //if the userID is NULL, means they do not have an account
         $userID = $_POST["userID"];

         $curr_post = (new PostTable($db_PDO)); //create post object

         if($refID == NULL){ //if the incoming post is a main post, i.e. no refID, it needs a file to post

            create_post($file, $curr_post, $db_PDO, $userID, $board, $body, $title); //create post function

         } else { //otherwise it's a comment, in which case it needs text to post

            create_comment($file, $curr_post, $db_PDO, $userID, $board, $body, $title, $refID);
         }
      }
      catch (PDOException $e){
         echo "Error: " . $e->getMessage();
         echo "<br><h1 class='post_notif'>Post failed.</h1>";
      }
   ?>
</body>

</html>
