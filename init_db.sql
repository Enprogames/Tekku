create table topic (
  topicID varchar(4) primary key,
  name varchar(100) not null,
  description text,
  rules text
);

create table user (
  userID integer primary key auto_increment,
  name varchar(40) not null,
  password varchar(256) not null,
  email varchar(256),
  profilePic blob,
  description text,
  creationTime timestamp not null
);


-- post requires image, comment does not
-- post requires text, comment does not. but needs one or the other
create table post (
  postID integer not null primary key auto_increment,
  userID integer references user,
  topicID varchar(4) not null references topic,
  createdAt timestamp not null,
  image blob, 
  content text, 
  title varchar(100),
  postRef integer references post.postID
);

--create table comment (
--  postID integer primary key references post,
--  parentPost integer references post
--);
-- creates the insertion trigger which increments the postID based on what topic it's in, so we have different topic/post id keys

--DELIMITER $$

--CREATE TRIGGER topic_post_inc
--BEFORE INSERT ON post
--FOR EACH ROW BEGIN
--   set NEW.postID = (
--      select IFNULL(MAX(postID), 0) + 1
--      FROM post
--      WHERE topicID = NEW.topicID
--   );
--END $$

--DELIMITER ;
   

create table banned (
  userID integer not null references user,
  topicID varchar(4) not null references topic,
  givenAt timestamp not null,
  duration timestamp,
  primary key(userID, topicID)
);

create table admin (
  userID integer not null references user,
  topicID varchar(4) not null references topic,
  givenAt timestamp not null
);
