<?php
// Class interfaces for interacting with the site database


class ItemNotFoundException extends Exception {
  public function __construct($message, $code = 0, Exception $previous = null) {
      parent::__construct($message, $code, $previous);
  }

  public function __toString() {
      return __CLASS__ . ": [{$this->code}]: {$this->message}";
  }
}


class PostTable {
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
    public function create($userID, $topicID, $createdAt, $image, $content, $title) {

      try {
         //prepare the pdo statement and bind all the params
         $stmt = $this->db_PDO->prepare("INSERT INTO post (postID, userID, topicID, createdAt, image, content, title)
            VALUES (:postID, :userID, :topicID, :createdAt, :image, :content, :title)");

         $postID = 3; //need to write a function that gets the highest ID in the posts for this topic, and make the current post that ID+1

         $stmt->bindParam(':postID', $postID);
         $stmt->bindParam(':userID', $userID);
         $stmt->bindParam(':topicID', $topicID);
         $stmt->bindParam(':createdAt', $createdAt);
         $stmt->bindParam(':image', $image);
         $stmt->bindParam(':content', $content);
         $stmt->bindParam(':title', $title);
         
         $stmt->execute();
      }
      catch (PDOException $e) {
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
    }
  
    /**
     * Updates a row in the 'post' table with the given post ID and topic ID, setting the image, content, and title to the given values.
     * @param int $postID The ID of the post to update.
     * @param string $topicID The ID of the topic the post belongs to.
     * @param binary $image The new image data for the post.
     * @param string $content The new text content for the post.
     * @param string $title The new title of the post.
     */
    public function update($postID, $topicID, $image, $content, $title) {
      $stmt = $this->db_PDO->prepare("UPDATE post SET image = ?, content = ?, title = ? WHERE postID = ? AND topicID = ?");
      $stmt->bind_param("sssis", $image, $content, $title, $postID, $topicID);
      $stmt->execute();
      $stmt->close();
    }
  
    /**
     * Deletes a row from the 'post' table with the given post ID and topic ID.
     * @param int $postID The ID of the post to delete.
     * @param string $topicID The ID of the topic the post belongs to.
     */
    public function delete($postID, $topicID)
    {
        $stmt = $this->db_PDO->prepare("DELETE FROM post WHERE postID = ? AND topicID = ?");
        $stmt->bind_param("is", $postID, $topicID);
        $stmt->execute();
        $stmt->close();
    }
}

?>
