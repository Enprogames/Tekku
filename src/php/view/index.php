<?php
// Start session at top of file
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

$db_interface = (new TopicTable($db_PDO));
?>
<!DOCTYPE html>

<head>
   <title>Tekku</title>

   <?php include 'include/head.php'; ?>

</head>
<body>
   <?php include 'include/header.php' ?>
   <div class="boardBoxContainer">
      <div class="boardBox">
         <div class="board_box_title"><h2>Boards</h2></div>
         <?php

         $topics = $db_interface->get_all();

         ?>
         <ul class="topic_columns">
            <?php foreach ($topics as $topic): ?>
               <li><a class="clickable" href="view_topic.php?t=<?=$topic->topicID ?>"><?=$topic->name ?></a></li>
            <?php endforeach ?>
         </ul>
      </div>
   </div>

</body>

</html>
