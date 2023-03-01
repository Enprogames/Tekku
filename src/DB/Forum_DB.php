<?php

class ItemNotFoundException extends Exception {
  public function __construct($message, $code = 0, Exception $previous = null) {
      parent::__construct($message, $code, $previous);
  }

  public function __toString() {
      return __CLASS__ . ": [{$this->code}]: {$this->message}";
  }
}


class Post {
    private $db_PDO;
  
    /**
     * Pass in a database connection
     * @param $db_PDO pdo The database connection to use for interacting with the 'post' table.
     */
    public function __construct($db_PDO) {
      $this->db_PDO = $db_PDO;
    }
  
    /**
     * Creates a new row in the 'post' table with the given parameters.
     * @param int $userID The ID of the user who created the post.
     * @param string $topicID The ID of the topic the post belongs to.
     * @param string $createdAt null, which makes the database default to current time
     * @param binary $image The image data for the post.
     * @param string $content The text content for the post.
     * @param string $title The title of the post.
     */
    public function create($userID, $topicID, $createdAt, $image, $content, $title, $refID) {

      try{
         //prepare the pdo statement and bind all the params
         $stmt = $this->db_PDO->prepare("INSERT INTO post (postID, userID, topicID, createdAt, image, content, title, postRef)
            VALUES (:postID, :userID, :topicID, :createdAt, :image, :content, :title, :refID)");

         $postID = NULL; //by leaving this as null, auto_increment works and gets the largest post id and adds 1 to it

         $stmt->bindParam(':postID', $postID);
         $stmt->bindParam(':userID', $userID);
         $stmt->bindParam(':topicID', $topicID);
         $stmt->bindParam(':createdAt', $createdAt);
         $stmt->bindParam(':image', $image);
         $stmt->bindParam(':content', $content);
         $stmt->bindParam(':title', $title);
         $stmt->bindParam(':refID', $refID);
         
         $stmt->execute();
      }
      catch (PDOException $e){
         echo "Error: " . $e->getMessage();
      } 
    }

    /**
        * Reads a row from the 'post' table with the given post ID and topic ID.
     * @param int $postID The ID of the post to read.
     * @param string $topicID The ID of the topic the post belongs to.
     * @return Post Object holding values of this forum post.
     */

    public function read($postID, $topicID) {

      try{
         $stmt = $this->db_PDO->prepare("
           SELECT postID, topicID, userID, createdAt, image, content, title
           FROM post
           WHERE postID = :postID
             AND topicID = :topicID
         ");
         $stmt->bindParam(':postID', $postID);
         $stmt->bindParam(':topicID', $topicID);
         $stmt->execute();
         $post_obj = $stmt->fetchObject();
         # throw error if no post is returned
         if (!$post_obj) {
           throw new ItemNotFoundException("No post found in {$topicID} with ID {$postID}");
         }
         return $post_obj;

         $stmt->close();
      }
      catch (PDOException $e) {
         echo "Error: " . $e->getMessage();
      }
    }

    /**
     * Reads a row from the 'post' table with the given post ID and topic ID, that is in reference to a main post
     * @param int $postID The ID of the post to read.
     * @param string $topicID The ID of the topic the post belongs to.
     * @param int $refID the ID of the post the comment is referring to.
     * @return array|null An associative array representing the row in the 'post' table, or null if no such row exists.
   */
    public function read_main($postID, $topicID) {
      try{
         //prepare the pdo statement
         $stmt = $this->db_PDO->prepare("SELECT * FROM post WHERE postID=:postID and topicID=:topicID");

         $stmt->bindParam(':postID', $postID);
         $stmt->bindParam(':topicID', $topicID);
         //execute the select statement
         $stmt->execute();

         //set the resulting array to associative
         $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      }
      catch (PDOException $e){
            echo "Error: " . $e->getMessage();
      }
    }

    /**
     * Reads a row from the 'post' table with the given post ID and topic ID, that is in reference to a main post
     * @param int $postID The ID of the post to read.
     * @param string $topicID The ID of the topic the post belongs to.
     * @param int $refID the ID of the post the comment is referring to.
     * @return array|null An associative array representing the row in the 'post' table, or null if no such row exists.
     */
    public function read_comment($postID, $topicID, $refID) {
      try{
         //prepare the pdo statement
         $stmt = $this->db_PDO->prepare("SELECT * FROM post WHERE postID=:postID and topicID=:topicID and postRef=:refID");

         $stmt->bindParam(':postID', $postID);
         $stmt->bindParam(':topicID', $topicID);
         $stmt->bindParam(':refID', $refID);
         //execute the select statement
         $stmt->execute();

         //set the resulting array to associative
         $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      }
      catch (PDOException $e){
            echo "Error: " . $e->getMessage();
      }
   }
  
    /**
     * Updates a row in the 'post' table with the given post ID and topic ID, setting the image, content, and title to the given values.
     * @param int $postID The ID of the post to update.
     * @param string $topicID The ID of the topic the post belongs to.
     * @param binary $image The new image data for the post.
     * @param string $content The new text content for the post.
     * @param string $title The new title of the post.
     
    public function update($postID, $topicID, $image, $content, $title) {
      $stmt = $this->db_PDO->prepare("UPDATE post SET image = ?, content = ?, title = ? WHERE postID = ? AND topicID = ?");
      $stmt->bind_param("sssis", $image, $content, $title, $postID, $topicID);
      $stmt->execute();
      $stmt->close();
    }*/
  
    /**
     * Deletes a row from the 'post' table with the given post ID and topic ID.
     * Also deletes all comments in reference to this post.
     * @param int $postID The ID of the post to delete.
     * @param string $topicID The ID of the topic the post belongs to.
     */
     
    public function delete($postID, $topicID)
    {
        try{
           //prepare the statement for comment deletion. Deletes comments referencing post for deletion, and that is of the same topic
           $stmt = $this->db_PDO->prepare("DELETE FROM post WHERE postRef=:postID and topicID=:topicID");
           //bind params
           $stmt->bindParam(':postID', $postID);
           $stmt->bindParam(':topicID', $topicID);
           //execute the statement
           $stmt->execute();

           //now delete the main post
           $stmt = $this->db_PDO->prepare("DELETE FROM post WHERE postID=:postID and topicID=:topicID");
           //bind params
           $stmt->bindParam(':postID', $postID);
           $stmt->bindParam(':topicID', $topicID);
           //execute the statement
           $stmt->execute();
        }
        catch (PDOException $e){
           echo "Error: " . $e->getMessage();
        }
    }
}

?>
