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

4. Database and tables \
I used migrations to table without blog_id. \
To test, there are a setup that seed some values each time \
To uses directly in browser, there are a route called /comments/fill that seed the table with some values \

5. Routes

GET /comments           -> return array with comments until 3rd level \
PUT /comments           -> create a new comment. Parameters (name=>string, message=>string and (OPTIONAL) parent_id=>number ) \
PUT /comments/ID        -> update a comment. Parameters (name=>string, message=>string and (OPTIONAL) parent_id=>number ) \
DELETE /comments/ID     -> delete a comment. 


GET /comments/fill      -> fill table with dummy value to test GET in browser



