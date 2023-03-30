<?php

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
      increases a given posts activity counter

      @param postID, the ID of the post whose activity counter is being increased by 1
   **/

   public function increase_activity($postID){

      try{
         $stmt = $this->db_PDO->prepare("UPDATE post SET activity = activity + 1 WHERE
            postID = :postID");

         $stmt->bindParam(':postID', $postID);
         $stmt->execute();
      }
      catch (PDOException $e){
         echo "Error: " . $e->getMessage();
      }

   }

    /**
      returns the max activity number from the posts in a given topic

      @param topicID, the ID of the topic we are finding the current highest max counter. we return that number
    **/
    public function get_max_activity($topicID){

      try{
         $stmt = $this->db_PDO->prepare("SELECT MAX(activity) AS maxAc FROM post
            WHERE topicID = :topicID");

         $stmt->bindParam(':topicID', $topicID);
         $stmt->execute();
         $post_obj = $stmt->fetchObject();

         return $post_obj->maxAc;
      }
      catch (PDOException $e){
         echo "Error: " . $e->getMessage();
      }
    }

    /**
     * Creates a new row in the 'post' table with the given parameters.
     * @param int $userID The ID of the user who created the post.
     * @param string $topicID The ID of the topic the post belongs to.
     * @param string $createdAt null, which makes the database default to current time
     * @param string $image Name of image in upload folder.
     * @param string $content The text content for the post.
     * @param string $title The title of the post.
     */
    public function create($userID, $topicID, $createdAt, $image, $content, $title, $refID, $maxAc) {

      try{
         //prepare the pdo statement and bind all the params
         $stmt = $this->db_PDO->prepare("INSERT INTO post (postID, userID, topicID, createdAt, image, content, title, postRef, activity)
            VALUES (:postID, :userID, :topicID, :createdAt, :image, :content, :title, :refID, :activity)");

         $postID = NULL; //by leaving this as null, auto_increment works and gets the largest post id and adds 1 to it

         $stmt->bindParam(':postID', $postID);
         $stmt->bindParam(':userID', $userID);
         $stmt->bindParam(':topicID', $topicID);
         $stmt->bindParam(':createdAt', $createdAt);
         $stmt->bindParam(':image', $image);
         $stmt->bindParam(':content', $content);
         $stmt->bindParam(':title', $title);
         // make mysql database row for postRef null if refID is null
          if ($refID == null) { //it's a main post
            $stmt->bindParam(':activity', $maxAc); //main posts have activity counters
            $stmt->bindValue(':refID', $refID, PDO::PARAM_NULL);
          } else { //it's a comment
            $stmt->bindParam(':refID', $refID);
            $stmt->bindParam(':activity', $maxAc, PDO::PARAM_NULL); //comments do not track activity
          }

         $stmt->execute();
      }
      catch (PDOException $e){
         echo "Error: " . $e->getMessage();
      }
    }

    /**
      * Reads the number of rows (comments) relating to a given post and it's board.
      @param string $topicID the id of the board the post is from
      @param int $refID the id of the post we are counting our comments from
      @param $limit the number of comments we consider the limit to be, and determines if the thread is locked.

      If the post has >= the number of comments allowed, we return false.
      Otherwise it is less than the limit, return true;


    */
    public function comment_count_n($topicID, $refID, $limit = 350){

      try{

         $stmt = $this->db_PDO->prepare("SELECT COUNT(*) AS comment_num FROM post
            WHERE postRef = :refID
              AND topicID = :topicID");

         $stmt->bindParam(':refID', $refID);
         $stmt->bindParam(':topicID', $topicID);
         $stmt->execute();
         $post_obj = $stmt->fetchObject();

         if($post_obj->comment_num >= $limit){
            return true;
         }
         else{
            return false;
         }

         $stmt->close();
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
    }*/

    /**
     * Reads a row from the 'post' table with the given post ID and topic ID, that is in reference to a main post
     * @param int $postID The ID of the post to read.
     * @param string $topicID The ID of the topic the post belongs to.
     * @param int $refID the ID of the post the comment is referring to.
     * @return array|null An associative array representing the row in the 'post' table, or null if no such row exists.
     */
    public function read_comment($postID, $topicID) {
      try{
         //prepare the pdo statement
         $stmt = $this->db_PDO->prepare("SELECT * FROM post WHERE topicID=:topicID and postRef=:postID ORDER BY createdAt");

         $stmt->bindParam(':topicID', $topicID);
         $stmt->bindParam(':postID', $postID);
         //execute the select statement
         $stmt->execute();

         $post_obj = $stmt->fetchAll(PDO::FETCH_CLASS);

         return $post_obj;
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


class TopicTable {
   private $db_PDO;

   /**
    * Pass in a database connection
    * @param $db_PDO pdo The database connection to use for interacting with the 'topic' table.
    */
   public function __construct($db_PDO) {
     $this->db_PDO = $db_PDO;
   }

   /**
       * Reads a row from the 'topic' table with the given topicID and returns all attributes
    * @param int $topicID e.g. 'tec'
    * @return Topic PDO object storing all attributes for a single post table
    */

   public function get($topicID) {

     try{
        $stmt = $this->db_PDO->prepare("
          SELECT topicID, name, description, rules
          FROM topic
          WHERE topicID = :topicID
        ");
        $stmt->bindParam(':topicID', $topicID);
        $stmt->execute();
        $topic_obj = $stmt->fetchObject();
        # throw error if no topic is returned
        if (!$topic_obj) {
          throw new ItemNotFoundException("No topic {$topicID}");
        }

        return $topic_obj;

     }
     catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
     }
   }

   /**
       * Reads a row from the 'topic' table with the given topicID and returns all attributes
    * @param int $limit How many to return. Give -1 for all (defaults to -1).
    * @return array[Topic] Array of topic PDO objects.
    */
   public function get_all($limit = -1) {
     try{
       $query = "
       SELECT topicID, name, description, rules
          FROM topic
     ";
       if ($limit >= 0) {
         $query = $query . " LIMIT :limit";
       }
       $stmt = $this->db_PDO->prepare($query);
       if ($limit >= 0) {
         $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
       }
       $stmt->execute();
       $topics = $stmt->fetchAll(PDO::FETCH_CLASS);

       return $topics;
    }
    catch (PDOException $e) {
       echo "Error: " . $e->getMessage();
    }
   }

   public function get_posts($topicID, $limit = 100) {
     try{
      # get a certain number of posts for this topic.
      # also make sure this isn't a comment, meaning postRef is null.
       $query = "
       SELECT p.postID, p.userID, p.topicID, p.createdAt, p.image, p.content, p.title, p.postRef, p.activity
       FROM post p
       WHERE p.topicID = :topicID
         and p.postRef is null
       ORDER BY p.activity DESC
       LIMIT :limit
     ";
       $stmt = $this->db_PDO->prepare($query);
       $stmt->bindParam(':topicID', $topicID);
       $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
       $stmt->execute();
       $posts = $stmt->fetchAll(PDO::FETCH_CLASS);

       return $posts;
    }
    catch (PDOException $e) {
       echo "Error: " . $e->getMessage();
    }
   }



}

class UserTable
{
   private $db_PDO;

     /**
      * Pass in a database connection
      * @param $db_PDO pdo The database connection to use for interacting with the 'user' table.
     */
    public function __construct($db_PDO) {
      $this->db_PDO = $db_PDO;
    }

    public function create_account($name, $password, $email)
    {
      try{

         require_once "LoadEnv.php";

        // Using a PDO prepared statement to insert user data into the 'user' table
        // Ignore will not insert if there is a duplicate field
        $stmt = $this->db_PDO->prepare("INSERT IGNORE INTO user (name, password, email) VALUES (:name, :password, :email)");

        // Hash the password
        $hashedPass = password_hash(hash_hmac('sha256', $_ENV['PHRASE'] ,$password), PASSWORD_DEFAULT); //we have the .env file loaded for this

	      //look into salting and peppering our passwords using https://www.php.net/manual/en/function.hash-hmac.php
        // Binding variables to the placeholders
        // The variables $name, $password, and $email contain user input data
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':password', $hashedPass);
        $stmt->bindParam(':email', $email);

        // Executing the prepared statement
        $stmt->execute();

        // If there were no fields modified in the table (it was a duplicate user) do something about it
        if ($stmt->rowCount() == 0)
        {
          return false;
          header ("Location: ../view/index");
        }
        return true;
      }
      catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
    }

    public function validate_login($name, $password)
    {
      try
      {

        require_once "LoadEnv.php";
        // Using a PDO prepared statement to find a user with the given name and password in the 'user' table
        $stmt = $this->db_PDO->prepare("SELECT count(userID) as userCount, userID, password from user WHERE name=:name");

        // Binding user input data to the placeholders in the prepared statement
        $stmt->bindParam(':name', $name);

        // Executing the prepared statement
        $stmt->execute();

        // Fetching the first row of the result set as an associative array
        $users = $stmt->fetchAll(PDO::FETCH_CLASS);

        $count = $users[0]->userCount;
        if ($count > 0) {
          // loop through all returned users and see if one has a matching password
          // if a password match is found, return the user id
          foreach ($users as $user) {
            // This user exists
            // Store the username and hashed password
            $userID = $user->userID;
            $hashedPass = $user->password;
            // Check the password matches the hash
            if (password_verify(hash_hmac('sha256', $_ENV['PHRASE'], $password), $hashedPass)) {
              return $userID;
            }
          }
        } else {  // If the user doesn't exist, return null
          return null;
        }
        return null;
      }
      catch (PDOException $e) {
        throw new Exception("Login error: " . $e->getMessage());
      }
    }

    /**
       * Reads a row from the 'user' table with the given userID and returns all attributes
    * @param int $userID Database primary key for user table
    * @return User user PDO object.
    */
    function get($userID) {
      try {
        $stmt = $this->db_PDO->prepare("
          select name, password, email, profilePic, description, creationTime
          from user
          where userID = :userID"
        );

        // Binding user input data to the placeholders in the prepared statement
        $stmt->bindParam(':userID', $userID);

        // Executing the prepared statement
        $stmt->execute();

        return $stmt->fetchObject();
      }
      catch (PDOException $e) {
        throw new Exception("Login error: " . $e->getMessage());
      }
    }

}
