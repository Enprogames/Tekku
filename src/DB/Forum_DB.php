<?php
// Class interfaces for interacting with the site database

class Post {
    private $db;
  
    /**
     * Pass in a database connection
     * @param $db mysqli The database connection to use for interacting with the 'post' table.
     */
    public function __construct($db) {
      $this->db = $db;
    }
  
    /**
     * Creates a new row in the 'post' table with the given parameters.
     * @param int $userID The ID of the user who created the post.
     * @param string $topicID The ID of the topic the post belongs to.
     * @param string $createdAt The creation date of the post in 'Y-m-d H:i:s' format.
     * @param binary $image The image data for the post.
     * @param string $content The text content for the post.
     * @param string $title The title of the post.
     */
    public function create($userID, $topicID, $createdAt, $image, $content, $title) {
      $stmt = $this->db->prepare("INSERT INTO post (userID, topicID, createdAt, image, content, title) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("isssss", $userID, $topicID, $createdAt, $image, $content, $title);
      $stmt->execute();
      $stmt->close();
    }

    /**
     * Reads a row from the 'post' table with the given post ID and topic ID.
     * @param int $postID The ID of the post to read.
     * @param string $topicID The ID of the topic the post belongs to.
     * @return array|null An associative array representing the row in the 'post' table, or null if no such row exists.
     */
    public function read($postID, $topicID) {
      $stmt = $this->db->prepare("SELECT * FROM post WHERE postID = ? AND topicID = ?");
      $stmt->bind_param("is", $postID, $topicID);
      $stmt->execute();
      $result = $stmt->get_result();
      $stmt->close();
      return $result->fetch_assoc();
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
      $stmt = $this->db->prepare("UPDATE post SET image = ?, content = ?, title = ? WHERE postID = ? AND topicID = ?");
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
        $stmt = $this->db->prepare("DELETE FROM post WHERE postID = ? AND topicID = ?");
        $stmt->bind_param("is", $postID, $topicID);
        $stmt->execute();
        $stmt->close();
    }
}
