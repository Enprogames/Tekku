create table topic (
  topicID varchar(4) primary key,
  name varchar(100) not null,
  description text,
  rules text
);

create table user (
  userID integer primary key auto_increment,
  name varchar(40) not null unique,
  password varchar(256) not null,
  email varchar(256),
  profilePic varchar(256),
  description text,
  creationTime timestamp not null
);


-- post requires image, comment does not
-- post requires text, comment does not. but needs one or the other
create table post (
  postID integer not null auto_increment,
  userID integer references user,
  topicID varchar(4) not null references topic,
  createdAt timestamp not null,
  image varchar(256),
  content text,
  title varchar(100),
  activity int zerofill,
  postRef integer,
  foreign key (postRef) references post (postID),
  primary key(topicID, postID)
) ENGINE=MyISAM;


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
