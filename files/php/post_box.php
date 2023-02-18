<?php
   echo "<div style='display: block; margin: auto; width: 30%; '>";
   echo "<form action='comment.php'method='post'>";
   echo "<label for='name'>Name</label><br>";
   echo "<input type='text' id='name' name='name' placeholder='Anonymous'><br>";
   echo "<label for='body'>Body</label><br>";
   echo "<textarea name='body' rows='20' cols='50'></textarea><br>";
   echo "<label for='attachment'>File</label>";
   echo "<input type='file'>";
   echo "<input type='submit' value='Post'>";
   echo "</form>";
   echo "</div>";
?>