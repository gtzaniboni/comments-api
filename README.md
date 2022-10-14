## Laravel comments api

1. Assumptions \
1.1 There are only one blog post. So, the route will not expect blog/{id}/comments for simplicity, only /comments \
1.2 Do not uses ORM. So, I choose uses only raw SQL. 



2. Comments and decisions \
2.1 I created the database and tables using raw SQL too. of course, migrate is not eloquent, but I prefer do it myself. \
2.2 There are at least 4 ways to nested registers in sql databases. All these ways have benefits. Due the requirement of only 3 levels, the SQL approach is select each level to mount easyly the json output. Using left join and get all information in just one query is, in the real, like make separated querys, but have more complexity in the response json fill process. \
2.3 Delete one comment will delete all child. there are some different approachs, like "up" the childs or if the deleted comment have children, just delete the content. for simplicity, I just delete all child. \
2.4 I dont make all tests. I just put one test to show how to do. Even in this single test, I check only the json structure. In a real world, needs to check all requirements, like the maximum level or bad values passed to create/update/delete. The main idea is show that first the tests needs to be developed BEFORE start to develop the api itself. \
-- execute: php artisan test    and get FAIL! Develop the API and get it PASS! \
2.5 I do not clean the stuff laravel put in the code. I left the unit test, ExampleTest, sail stuff, etc.

3. Time \
3.1 I plan expend about 4 hours to execute the activity\
3.2 I used about 6 hours, because I have some issue with databases, sail, and my local setup. 

4. Database and tables

For this particular example, create a database and table, and fill it. \
In real world, use migration to do that. 

CREATE USER 'comments'@'%' IDENTIFIED WITH mysql_native_password AS '***';GRANT ALL PRIVILEGES ON *.* TO 'comments'@'%' REQUIRE NONE WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;CREATE DATABASE IF NOT EXISTS `comments`;GRANT ALL PRIVILEGES ON `comments`.* TO 'comments'@'%';GRANT ALL PRIVILEGES ON `comments\_%`.* TO 'comments'@'%';

DROP TABLE comment; 

CREATE TABLE comment(
comment_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(60),
parent_id INT UNSIGNED DEFAULT NULL,
comment TEXT,
FOREIGN KEY fk_parent(parent_id)
REFERENCES comment(comment_id)   
ON UPDATE CASCADE
ON DELETE CASCADE);

INSERT INTO `comment` (`comment_id`, `name`, `parent_id`, `comment`) VALUES (NULL, 'nome 1', NULL, 'coment 1');
INSERT INTO `comment` (`comment_id`, `name`, `parent_id`, `comment`) VALUES (NULL, 'nome 2', NULL, 'coment 2');
INSERT INTO `comment` (`comment_id`, `name`, `parent_id`, `comment`) VALUES (NULL, 'nome 3', 1, 'coment 3');
INSERT INTO `comment` (`comment_id`, `name`, `parent_id`, `comment`) VALUES (NULL, 'nome 4', 1, 'coment 4');
INSERT INTO `comment` (`comment_id`, `name`, `parent_id`, `comment`) VALUES (NULL, 'nome 5', NULL, 'coment 5');
INSERT INTO `comment` (`comment_id`, `name`, `parent_id`, `comment`) VALUES (NULL, 'nome 6', 3, 'coment 6');
INSERT INTO `comment` (`comment_id`, `name`, `parent_id`, `comment`) VALUES (NULL, 'nome 7', 3, 'coment 7');
INSERT INTO `comment` (`comment_id`, `name`, `parent_id`, `comment`) VALUES (NULL, 'nome 8', NULL, 'coment 8');
INSERT INTO `comment` (`comment_id`, `name`, `parent_id`, `comment`) VALUES (NULL, 'nome 9', 7, 'coment 9');
INSERT INTO `comment` (`comment_id`, `name`, `parent_id`, `comment`) VALUES (NULL, 'nome 10', 1, 'coment 10');
INSERT INTO `comment` (`comment_id`, `name`, `parent_id`, `comment`) VALUES (NULL, 'nome 11', NULL, 'coment 11');
INSERT INTO `comment` (`comment_id`, `name`, `parent_id`, `comment`) VALUES (NULL, 'nome 12', 10, 'coment 12');
INSERT INTO `comment` (`comment_id`, `name`, `parent_id`, `comment`) VALUES (NULL, 'nome 13', 10, 'coment 13');
INSERT INTO `comment` (`comment_id`, `name`, `parent_id`, `comment`) VALUES (NULL, 'nome 14', 12, 'coment 14');
INSERT INTO `comment` (`comment_id`, `name`, `parent_id`, `comment`) VALUES (NULL, 'nome 15', NULL, 'coment 15');
INSERT INTO `comment` (`comment_id`, `name`, `parent_id`, `comment`) VALUES (NULL, 'nome 16', 14, 'coment 16');
INSERT INTO `comment` (`comment_id`, `name`, `parent_id`, `comment`) VALUES (NULL, 'nome 17', NULL, 'coment 17');
INSERT INTO `comment` (`comment_id`, `name`, `parent_id`, `comment`) VALUES (NULL, 'nome 18', 1, 'coment 18');


