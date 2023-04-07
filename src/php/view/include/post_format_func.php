<?php
function post_format($post_obj, $db_interface_u, $db_interface){

       $usr_img_dir = $_ENV['USER_POST_IMAGE_DIR'];
       $username = ($post_obj->userID) ? $db_interface_u->get($post_obj->userID)->name : "Anonymous";
       echo "<div id='{$post_obj->postID}' class='comment-container'>"; //make each div of a bookmark
       echo "<div>";
       echo "<p>";
       if ($username != "Anonymous"){
         echo "<a class='linkAdjacent' href='usr_profile.php?u=" . $post_obj->userID . "'><strong>" . $db_interface_u->get($post_obj->userID)->name . "</strong></a>";
       }
         else { echo "Anonymous";
      }
       echo " || " . $post_obj->createdAt . " || " . $post_obj->postID . " <button onclick='comment_reply({$post_obj->postID})'>reply</button></p><br>";
       if($post_obj->image){
         echo "<img style='max-width: 500px; max-width:500px; padding: 5px;' src='../../{$usr_img_dir}/" . $post_obj->image . "'><br>";
       }
       echo "<p>" . $post_obj->title . "</p>";
       echo "<p>" . post_regex($post_obj, $db_interface)  . "</p>";
       echo "</div>";
       echo "</div>";
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