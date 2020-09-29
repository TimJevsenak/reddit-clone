
CREATE TABLE `users`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `username` Varchar(20) NOT NULL,
  `email` Varchar(100) NOT NULL,
  `pass` Varchar(255) NOT NULL,
  `avatar` Varchar(255),
  `displayname` Varchar(50),
  `description` Varchar(255),
  `dateCreated` Timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateUpdated` Timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `coins` Int NOT NULL DEFAULT 0,
  `karma` Int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
)
;

CREATE TABLE `communities`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `name` Varchar(50) NOT NULL,
  `description` Varchar(255) NOT NULL,
  `title` Varchar(50) NOT NULL,
  `icon` Varchar(255),
  `dateCreated` Timestamp NOT NULL,
  `dateUpdated` Timestamp NOT NULL,
  `user_id` Int,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship5` ON `communities` (`user_id`)
;

CREATE TABLE `comments`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `text` Varchar(255) NOT NULL,
  `date` Timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_id` Int,
  `user_id` Int,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship3` ON `comments` (`post_id`)
;

CREATE INDEX `IX_Relationship18` ON `comments` (`user_id`)
;

CREATE TABLE `posts`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `title` Varchar(50) NOT NULL,
  `post` Text NOT NULL,
  `date` Timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `community_id` Int,
  `image` Char(255),
  `user_id` Int,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship4` ON `posts` (`community_id`)
;

CREATE INDEX `IX_Relationship17` ON `posts` (`user_id`)
;

CREATE TABLE `post_votes`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `user_id` Int,
  `post_id` Int,
  `date` Timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upvote` Bool NOT NULL,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship1` ON `post_votes` (`user_id`)
;

CREATE INDEX `IX_Relationship2` ON `post_votes` (`post_id`)
;

CREATE TABLE `subscriptions`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `community_id` Int,
  `user_id` Int,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship6` ON `subscriptions` (`community_id`)
;

CREATE INDEX `IX_Relationship7` ON `subscriptions` (`user_id`)
;

CREATE TABLE `awards`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `name` Varchar(50) NOT NULL,
  `icon` Varchar(255),
  PRIMARY KEY (`id`)
)
;

CREATE TABLE `awards_posts`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `date` Timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_id` Int,
  `award_id` Int,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship8` ON `awards_posts` (`post_id`)
;

CREATE INDEX `IX_Relationship9` ON `awards_posts` (`award_id`)
;

CREATE TABLE `awards_comments`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `date` Timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `award_id` Int,
  `comment_id` Int,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship12` ON `awards_comments` (`award_id`)
;

CREATE INDEX `IX_Relationship13` ON `awards_comments` (`comment_id`)
;

CREATE TABLE `comment_votes`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `date` Timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` Int,
  `comment_id` Int,
  `upvote` Bool NOT NULL,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship14` ON `comment_votes` (`user_id`)
;

CREATE INDEX `IX_Relationship16` ON `comment_votes` (`comment_id`)
;

ALTER TABLE `post_votes` ADD CONSTRAINT `Relationship1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `post_votes` ADD CONSTRAINT `Relationship2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `comments` ADD CONSTRAINT `Relationship3` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `posts` ADD CONSTRAINT `Relationship4` FOREIGN KEY (`community_id`) REFERENCES `communities` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `communities` ADD CONSTRAINT `Relationship5` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `subscriptions` ADD CONSTRAINT `Relationship6` FOREIGN KEY (`community_id`) REFERENCES `communities` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `subscriptions` ADD CONSTRAINT `Relationship7` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `awards_posts` ADD CONSTRAINT `Relationship8` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `awards_posts` ADD CONSTRAINT `Relationship9` FOREIGN KEY (`award_id`) REFERENCES `awards` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `awards_comments` ADD CONSTRAINT `Relationship12` FOREIGN KEY (`award_id`) REFERENCES `awards` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `awards_comments` ADD CONSTRAINT `Relationship13` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `comment_votes` ADD CONSTRAINT `Relationship14` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `comment_votes` ADD CONSTRAINT `Relationship16` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `posts` ADD CONSTRAINT `Relationship17` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `comments` ADD CONSTRAINT `Relationship18` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;


