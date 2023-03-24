<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once ("../DB/DBConnection.php");
require_once ("../DB/Forum_DB.php");

$db = (new DBConnection());
$db_PDO = $db->connect();

$db_interface = (new TopicTable($db_PDO));
?>
<!DOCTYPE html>

<head>
   <title>Tekku</title>

   <link href="../../css/base_colors.css" rel="stylesheet" />
   <link rel="icon" type="image/x-icon" href="../../favicon.ico" />

   <style>

      .boardBox{
         border: 2px solid #AA4926;
         width: 50%;
         margin: auto;
      }

      ul li{
         color: #AA4926;
      }

   </style>

</head>
<body>
   <h1 style="text-align: center;">Tekku</h1>

   <div class="boardBox">
      <div style="background-color: lightcoral;"><h2>Boards</h2></div>
      <?php

      $topics = $db_interface->get_all();

      ?>
      <ul>
         <?php foreach ($topics as $topic): ?>
            <li><a class="postBoxNoLink" href="view_topic.php?t=<?=$topic->topicID ?>"><?=$topic->name ?></a></li>
         <?php endforeach ?>
      </ul>
   </div>

</body>

</html>
