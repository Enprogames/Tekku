create table topic (
  topicID varchar(4) primary key,
  name varchar(100) not null,
  description text,
  rules text
);

create table user (
  userID integer primary key,
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
  postID integer not null,
  userID integer references user,
  topicID varchar(4) references topic,
  createdAt timestamp not null,
  image blob, 
  content text, 
  title varchar(100)
  primary key(topicID, postID)
);

create table comment (
  postID integer primary key references post,
  parentPost integer references post
);


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
