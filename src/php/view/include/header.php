<?php
   ini_set('display_errors', '1');
   ini_set('display_startup_errors', '1');
   error_reporting(E_ALL);

   require_once ("../DB/DBConnection.php");
   require_once ("../DB/Forum_DB.php");

   $db = (new DBConnection());
   $db_PDO = $db->connect();

   $db_header = (new TopicTable($db_PDO));

   $topics_header = $db_header->get_all();
   ?>
   <div style="display: flex; flex-direction: row; justify-content: space-between;">
   <div> / <?php
   foreach ($topics_header as $topic_header): ?>
            <a class="clickable" href="view_topic.php?t=<?=$topic_header->topicID ?>"><?=$topic_header->topicID ?></a> /
   <?php endforeach?>
   </div>

<div class="dropdown">
   <button>settings</button>
   <div class="dropdown-content">
      <?php if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]): ?>
            <a href="include/usr_logout.php">Log Out</a>
            <a href="usr_settings.php">Account Settings</a>
            <a href="user_profile.php">Profile</a>
      <?php else: ?>
            <a href="usr_login.php">Log In</a>
      <?php endif ?>

      <a target="_blank" href="https://en.wikipedia.org/wiki/FAQ">FAQ</a>
      <a target="_blank" href="https://en.wikipedia.org/wiki/Regulation">Rules</a>
   </div>
</div>
</div>

<a href="index.php" class="nolink"><h1 style="text-align: center;" class="titleDrop">Tekku</h1></a>