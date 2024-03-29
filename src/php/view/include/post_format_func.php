<?php
function post_format($post_obj, $db_interface_u, $db_interface, $usr_prof_check = 0){

       $usr_img_dir = $_ENV['USER_POST_IMAGE_DIR'];
       $username = ($post_obj->userID) ? $db_interface_u->get($post_obj->userID)->name : "Anonymous";
       echo "<div id='{$post_obj->postID}' class='comment-container'>"; //make each div of a bookmark
         echo "<div>";

            echo "<div style='display: flex; flex-direction: row; justify-content: space-between'>";
               echo "<div>";

               if ($username != "Anonymous"){
                  echo "<img src='../../{$usr_img_dir}/" . $db_interface_u->get($post_obj->userID)->profilePic ."' style='height:25px; width: 25px;'>&nbsp";
                  echo "<a class='linkAdjacent' href='usr_profile.php?u=" . $post_obj->userID . "'><strong>" . $db_interface_u->get($post_obj->userID)->name . "</strong></a>";
               }
                  else {
                  echo "<img src='../../default_images/anon.jpg' style='height:25px; width: 25px;'>&nbsp";
                  echo "Anonymous";
               }

               echo " || " . $post_obj->createdAt . " || " . $post_obj->postID;
               if($usr_prof_check == 0){ //if the call is NOT from a user profile, do not show the reply button
                  echo " <button onclick='comment_reply({$post_obj->postID})'>reply</button>";

               echo "</div>";
               // Gets the ID of the current topic we are in
               $topicID = $post_obj->topicID;

               echo "<div>";
               if(isset($_POST['delete'])){
                  $toDelete = $_POST['toDelete'];
                  // Delete the comment from the database
                  $db_interface->delete($toDelete, $topicID);
                  // Reload page to show changes (removed post)
                  echo "<meta http-equiv='refresh' content='0;'>";
               }

               // If you are an admin, allow deletion of post
               if(isset($_SESSION["loggedIn"]) && $db_interface_u->is_admin($_SESSION["userID"], $topicID)) { //if the user is logged in and is an admin, enter admin mode
                  echo "<form method='post'>";
                  echo "<input type='hidden' name='toDelete' value='$post_obj->postID' />";
                  echo "<input type='submit' name='delete' style='float:right' value='Delete Comment' />";
                  echo "</form>";
               }
               echo "</div>";
            }
            else{
               echo "</div>";
            }

            echo "</div>";
            echo "<br>";

         if($post_obj->image){
            echo "<img style='max-width: 500px; max-width:500px; padding: 5px;' src='../../{$usr_img_dir}/" . $post_obj->image . "'><br>";
         }
         echo "<p>" . $post_obj->title . "</p>";
         echo "<p>" . post_regex($post_obj, $db_interface)  . "</p>";
         echo "</div>";
      echo "</div>"; //closed by first
   }


function post_regex($post_obj, $db_interface) {
    $patterns = array();
    $patterns[0] = '/@([0-9]+)/'; //pattern to search for in a comment referencing another local post
    $patterns[1] = '/@([a-z]{1,4})\/([0-9]+)/'; //pattern to search for in a comment referencing an external post
    $patterns[2] = '/(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[-A-Z0-9+&@#\/%=~_|$?!:,.])*(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[A-Z0-9+&@#\/%=~_|$])/im';
    $patterns[3] = "/\r\n|\r|\n/";  // pattern for detecting newlines from
    //pattern for detecting links ^^ source from https://stackoverflow.com/a/29288898

    return preg_replace_callback_array( //replaces instances of @pID or @tID/pID with their href counterparts for clickable referencing
       [
         $patterns[0] => function ($matches) use ($post_obj, $db_interface) {
            return "<a href='view_post.php?t={$post_obj->topicID}&p={$db_interface->refPostMainPost($matches[1])}#$matches[1]'>@$matches[1]</a>";
         },
         $patterns[1] => function ($matches) use ($db_interface) {
            return "<a href='view_post.php?t=$matches[1]&p={$db_interface->refPostMainPost($matches[2])}#$matches[2]'>@$matches[1]/$matches[2]</a>";
         },
         $patterns[2] => function ($matches) {
            return "<a target='_blank' href='$matches[0]'>$matches[0]</a>";
         },
         $patterns[3] => function ($matches) {
            return "<br>";
         }
       ],
       $post_obj->content)  . "</p>";
    }

?>