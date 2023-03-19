<?php
   echo "<div style='display: block; margin: auto; width: 350px; '>";
   echo "<form enctype='multipart/form-data' action='../logic/create_post.php' method='post'>";
   echo "<label for='name'>Name</label><br>";
   echo "<input type='text' id='name' name='name' value=$username><br>";
   echo "<label for='title'>Title</label><br>";
   echo "<input type='text' id='title' name='title'><br>";
   echo "<label for='body'>Body</label><br>";
   echo "<textarea name='body' rows='20' cols='50'></textarea><br>";
   echo "<label for='attachment'>File</label>";
   echo "<input type='file' name='attachment' accept='.gif, .jpg, .png .jpeg'>";
   echo "<input type='hidden' id='topicID' name='topicID' value='$topicID'>"; //this will hold the value of the board the post came from. temp just says tec
   echo "<input type='hidden' id ='refID' name='refID' value='$refID'>";
   echo "<input type='submit' value='Post'>";
   echo "</form>";
   echo "</div>";
?>
