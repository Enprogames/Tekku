<!DOCTYPE html>

<head>
    <title>Tekku</title>
    <link href="../../css/base_colors.css" rel="stylesheet" />
    <style>
      p {
         text-align: center;
      }
    </style>
</head>

<body>

   <?php

      ini_set('display_errors', '1');
      ini_set('display_startup_errors', '1');
      error_reporting(E_ALL);

      require_once ("../DB/DBConnection.php");
      require_once ("validate_input.php");
      require_once ("../DB/Forum_DB.php"); //include the forum class info

      try{
         $db = (new DBConnection()); //db is now a new DBconnection object
         $db_PDO = $db->connect(); //db_PDO is the returned PDO after successful connection


         //get the post info
         $name = clean_input($_POST["name"]); //gets the name of the user who posted
         $body = clean_input($_POST["body"]); //gets the contents of the body
         $board = $_POST["topicID"]; //gets the board the post is coming from
         $title = clean_input($_POST["title"]); //get the title of the post
         $file = null; //this will, in the future, be used to hold the file
         $refID = $_POST["refID"]; //if this is a main post, it has no reference ID
         //if the userID is NULL, means they do not have an account
         $userID = null;

         $curr_post = (new PostTable($db_PDO)); //create post object

         if($refID == NULL){ //if the incoming post is a main post, i.e. no refID, it needs a file to post

            if($file != NULL){ //if there is an image attached, proceed as normal

               $curr_post->create($userID, $board, null, $file, $body, $title, $refID); //create post: $userID, $topicID, $createdAt, $image, $content, $title. time is null so it defaults to current time of post

               echo "<h1 class='post_notif'>$file was successfully posted!</h1>"; //tell the user the post succeeded
            }
            else{ //otherwise no image. error
               echo "<h1 class='post_notif'>Error: No file attached.</h1>";
            }
         }else{ //otherwise it's a comment, in which case it needs text to post
            if($curr_post->comment_count_n($board, $refID)){ //if the limit is reached
               echo "<h1 class='post_notif'>[Thread Locked]</h1>";
            }
            else{ //otherwise limit has not been reached
               if($body != NULL || $file != NULL){ //if there is something in the body

                  $curr_post->create($userID, $board, null, $file, $body, $title, $refID); //create post: $userID, $topicID, $createdAt, $image, $content, $title. time is null so it defaults to current time of post
                  echo "<h1 class='post_notif'>Comment success</h1>";
               }
               else{//otherwise do nothing
                  if($content == NULL){
                     echo "<h1 class='post_notif'>Error: No text entered.</h1>";
                  }
                  else{
                     echo "<h1 class='post_notif'>Error: No file attached.</h1>";
                  }
               }
            }
         }
      }
      catch (PDOException $e){
         echo "Error: " . $e->getMessage();
         echo "<br><h1 class='post_notif'>Post failed.</h1>";
      }
   ?>
</body>

</html>
