<!DOCTYPE html>

<html>
<head>
    <title>Tekku</title>
    <link href="../css/base_colors.css" rel="stylesheet" />
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

      require_once ("../../src/DB/DBConnection.php");

      try{
         $db = (new DBConnection()); //db is now a new DBconnection object
         $db_PDO = $db->connect(); //db_PDO is the returned PDO after successful connection


         //get the post info
         $name = $_POST["name"]; //gets the name of the user who posted
         $body = $_POST["body"]; //gets the contents of the body
         $board = $_POST["topicID"]; //gets the board the post is coming from
         $title = $_POST["title"]; //get the title of the post
         $file = null; //this will, in the future, be used to hold the file

         require_once ("../../src/DB/Forum_DB.php"); //include the forum class info

         //if the name is NULL, means they do not have an account. in which case make userID null. otherwise, get the ID of the user making the post
         $userID = null;

         $curr_post = (new PostTable($db_PDO)); // Interface to post table in database
         $curr_post->create($userID, $board, null, $file, $body, $title); //create post: $userID, $topicID, $createdAt, $image, $content, $title. time is null so it defaults to current time of post

         $db_PDO = null;
         echo "<p>Post successful!</p>";
      }
      catch (PDOException $e){
         echo "Error: " . $e->getMessage();
         echo "<br><p>Post failed.</p><br>"
      }


   ?>

</body>

</html>