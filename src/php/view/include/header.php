<?php
      if (session_id() === '')
      {
         session_start();
      }
   ini_set('display_errors', '1');
   ini_set('display_startup_errors', '1');
   error_reporting(E_ALL);

   require_once ("../DB/DBConnection.php");
   require_once ("../DB/Forum_DB.php");

   $db = (new DBConnection());
   $db_PDO = $db->connect();

   $db_header = (new TopicTable($db_PDO));

   $topics_header = $db_header->get_all();
   ?> / <?php
   foreach ($topics_header as $topic_header): ?>
            <a href="view_topic.php?t=<?=$topic_header->topicID ?>"><?=$topic_header->topicID ?></a> /
   <?php endforeach?>

<h6 style='text-align: right'>
   <div class="dropdown">
         <button>settings</button>
            <div class="dropdown-content">
               <?php
                  if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
                     echo "<a href=\"include/usr_logout.php\">Log Out</a>";
                  }
                  else
                  {
                     echo "<a href=\"include/usr_login.php\">Log In</a>";
                  }
               ?>
               
               <a href="#">FAQ</a>
               <a href="#">Rules</a>
            </div>
   </div>

   <a href="index.php">home</a> </h6>