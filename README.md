# QuestionAnswer_web

## Brief Description

This project is to build a United States Tax 101 Q&A web-based system called U.S. Tax 101. It is designed to allow people to post U.S. tax related questions and answer other users’ questions. The users can be both tax professionals and nonprofessionals. 
Visitors need to register with the website and log into it in order to use the website functions such as browsing questions, searching and posting questions. 
The topics are divided into to three levels. The highest level consists of various tax topics such “individual income tax”, “corporate tax”, “capital gain tax”, “gift tax” and so on. The second level is to break each topic into to three subcategories: “federal tax”, “state tax” and “others”. And the third level is to list all the states for “state tax” because each state may have different rules on one tax concept. For example, if someone wants to know what the state tax rate for salary above 100k is and he is lives in NJ, he can choose topics from high to low  – “individual income tax” -> “state tax” -> “NJ”. The topics “federal tax” and “others” do not have a third level.
Standards to update the user status:

![image](https://user-images.githubusercontent.com/91846138/173264246-8dab89c8-c7c7-4e94-8dc6-7bab9d59b0a8.png)


The criteria numbers above are a little bit low because we would only prepare some sample data for testing. If it is for a real website, we can definitely raise the bar.
PHP is used in the codes to connect the backend database.

## E-R diagram

![image](https://user-images.githubusercontent.com/91846138/173264469-ac4ee12e-454f-4535-8463-367728efdfbe.png)

## Relational Schema

UserStatusCrit(**user_status**, min_num_likes, max_num_likes)

User (**user_id**, user_name, email, password, city, state, country, user_description, head_img, register_date, num_questions, num_likes, num_answers, user_status)

- Foreign key user_status refers to UserStatusCrit(user_status)

Question( **q_id**, user_id, q_title, q_timestamp, q_description)

- Foreign key user_id refers to User(user_id)

Answer(**a_id**, q_id, user_id, a_timestamp, a_description)

- Foreign key q_id refers to Question(q_id)

- Foreign key user_id refers to User(user_id)

likes(**user_id, a_id**, like_timestamp)

- Foreign key q_id refers to Question(q_id)
-	Foregin key a_id refers to Answer(a_id)

Topic(**topic_id**, topic_name)

TopicHierarchy(**th_id**, topic_id, higherLevel_topic_id, highestLevel_topic_id)

-	Foreign key topic_id refers to Topic(topic_id)
-	Foreign key higherLevel_topic_id refers to Topic(topic_id)
- Foreign key highestLevel_topic_id refers to Topic(topic_id)

QuestionTopic(**q_id, th_id**)
-	Foreign key q_id refers to Question(q_id)
- Foreign key th_id refers to TopicHierarchy(th_id)

## Assumptions
1. user_status for a particular user will be updated after other users hit likes on his answers. 
2. user_id in Question refers to the user who post this question.
3. user_id in Answer refers to the user who posted this answer.
4. Likes stores which user likes which answer. One user can only like one answer once. No dislike is allowed. Therefore number of likes for one answer is always equal to or greater than zero. Only users under login- in status can hit like. 
5. topic_id, higherLevel_topic_id and highestLevel_topic_id in TopicHierarchy all refer to Topic(topic_id). For example, “individual income tax”’s topic_id is T01, “state”’s topic_id is T02, “NJ” topic_id is T03. Then a topic about NJ individual income tax will have topic hierachy: T03 as topic_id, T02 as higherLevel_topic_id, and T01 as highestLevel_topic_id. 
6. When posting a question, the user will need to select a first level topic, a second level topic, and a third level topic if it is about state tax. No multiple same level topics is allowed. If some same level topics are not exclusive relationship such as questions about capital gain tax rules for individuals, users can either choose “individual income tax” or “capital gain tax” as the first level topic based on their own judgement.
7. if a sub topic doesn’t have a deepest level topic, then the absent topic_id may show as null in TopicHierarchy. For example, for topic “federal tax” with topic id T03, it only has one upper level “individual income tax” with topic id T02, then its topic hierarchy entry will be – null, T03, T02. The highest level topics will not be stored in TopicHierarchy table alone with topic id and higher level topic value as NULL because the way the system designed is to have at least two levels of topics.
8. users can use whatever user name they prefer. It doesn’t have to be their real names. However user names have to be unique which means if someone registers a user name which is already used, then he/she will get an error message.
9. any users can hit likes on any answers even if that answer is posted by themselves. They can also hit likes on different answers to the same question. But they can only hit like on one answer once. No multiple likes on the same answer by the same user are allowed. Users can hit likes on their own answers too.
10. note that all the primary keys for all the tables (except UsertatusCrit, likes and Question topics) are set as auto increment to so that the database can generate the primary key values automatically.
11. number of questions posted by a user, number of likes he/she received, and number of answers posted by him/her are stored in User table. It may seem to create some redundancy since those numbers can be calculated by making queries to the database but it would make the system run more efficiently by avoiding scanning the question, likes and answer tables for a small piece of information if the database keeps growing. 
12. any logged-in user can post his answer to a particular question once or multiple times. The author who posts the question can also answer his own questions. Because from time to time, people may have new thoughts on the same question.

## Register and login

Visitors will need to register with the website and sign in to use the website functions. The first-time visitor can click on “Or create account” to register. He will need to enter a unregistered username, an unregistered email address, a password, city, state, country and description for registration. None of these fields can be blank. The system will show error messages if any field is blank, or username is used already, or email address is registered already, or the visitor failed to confirm the password or the email address . After filling in all the fields, the visitor then click on “Register” button. If all the fields meet the critierias mentioned above, the system will show registered successfully message, then the visitor can click on “Return to sign in page” and sign in. The system set user status as “basic”  by default and will also set user profile image.

![image](https://user-images.githubusercontent.com/91846138/173265161-3927f861-c863-4ee3-8f08-1cbc48fcc5a6.png)

![image](https://user-images.githubusercontent.com/91846138/173265168-221233dd-3fc0-4041-a0ed-6fcd2243c44d.png)

To prevent cross-site scripting, I used strip_tags() function to store all the field information entered by the user. 

To show corresponding error messages, I used an array to store different errors when making queries to the database. For example, to check if the username is registered already, the system will make a query to the database to see if any record returns where user_name equals to the username the visitor entered. If there is a record, then the system will push a error message ”Username registered already” to the error array and echo it after the visitor hit Register button.

## Connect to database and keep user session state

Connect to database code is stored in connectDB.php file. Function session_start() is added there to allow keeping state for a user session. 

In login.php file, once the user hits login button, the system first will use strip_tags() function to store the user email address to prevent cross-site scripting. Then the email address will be saved as a session variable for future use. After making a query to the database to return the user information, any useful information such as username and user id will be saved as session variables too.

## Homepage

![image](https://user-images.githubusercontent.com/91846138/173265408-1ffecb25-dc27-4b5e-a49f-9cadc6fa17d8.png)

After a user logins successfully, he/she will come to a homepage.

On the left the page shows his/her profile image, her username, user status, and how many likes recevied. Users can click on the profile image or the username to go to their profile pages.

A “class” folder is created to store different classes for ease of use. User class is used to retrieve user information such as username, user status, number of likes received from the database. Here the functions in User class are called to show the user information.

In the center, there is a add question button to post new questions, and there are also a list of newly posted questions by all users (from new to old). The list is limited to 15 questions considering the database may grow and it becomes time consuming to loading all the quesitons. The user can click on the question title or answer count to come to the question page where it shows the details of a question and all its answers.

Post class are used to retrieve a list of question information from the database. Functions are created in Post class to load one or various numbers of questions with different constraints. Those functions use while loop to dynamically concatenate question titles and question detail descriptions together in a string and return the string when calling. The constraints are for example, to show a list of questions posted by all the users, by the logged in user, or by a particular user.

On the top, there is a header which will also show on all pages once a user logs in. Users can click on “Tax 101” on the left to return back to the homepage. There is a search box in the middle of the header where users can type in keyword for searching. On the right side of the header, there are three links – “All Questions” will lead to a page where users can view all the questions and select specific topics to get a list of related questions in reverse chronological order, “Profile” will lead to the user’s own profile page, “Logout” will destroy the session and return back to the login page. 

## Ask question page

![image](https://user-images.githubusercontent.com/91846138/173265525-9ec56fd2-d874-425a-8594-26cf67e5d1cc.png)

The logged-in user can click on “Ask Question” button to post his new question.

![image](https://user-images.githubusercontent.com/91846138/173265560-3c10c33c-fcd8-4ac5-bfb7-4f83f3f21c15.png)

There are three level of topics. As mentioned in the beginning, a user at least has to select topic level 1 and topic level 2 to post a question. They are set as required. If “state tax” is selected for topic level 2 and the user does not select a option for topic level 3, then he/she will receive an error message after the submit button is hitted. Title and Body fields are also set as required before a user can hit the submit button. 

See error message below for the situation when “state tax” is selected while topic level 3 is left as blank.

![image](https://user-images.githubusercontent.com/91846138/173265606-50b2d1a1-276e-4e0c-8031-c00eac25e2db.png)

“Addquestion.php” file is used to set up the frame of ask question page.  In order to return dynamic topic lists (lower level topic list values are returned based on the selection of higher level topic), javascript functions and jquery are implemented here to help sending selected topic name to PHP to make querries and to receive lower level topic list back. “ajax_topic.php” and “ajax_topic2.php” are used as bridges to connect between selected topic data stored in javascript and the database via PHP codes. “Topic.php” in the class folder are used in those two ajax_topic php files to make topic name queries and return the results.

When topic level 1 option is selected, in javascript code, the onchange function is called to send selecte topic 1 data to “ajax_topic.php” and in “ajax_topic.php”, the system will initialize a topic class and call the topic selection function stored in topic class. Frome there, a query is made to the database to return the corresponding topic level 2 list. Once the jquery receives a response from PHP, it uses a for loop to build a dynamic topic level 2 list.

After the submit button is clicked, the system will execute codes in “PostQuestion.php”. That php file will show error message if “state tax” is selected and topic level 3 is not selected. And if everything goes well, it will initialize a question class and call the “addquestion()” function in question class to insert the question into the question table and update the number of questions in the user table in the database. 

As mentioned before, since the user id is saved in SESSION(), now we can use that information for insertion query into the question table. The topics, title and question body are passed as parameters in “addquestion()” function. This function will also update the number of questions in the user table for the logged-in user.

After the question is inserted, the system will show a message to tell the user that the question is posted successfully and he/she can click on “Return to homepage” link to go back to the home page.

![image](https://user-images.githubusercontent.com/91846138/173265722-6b7eb64d-807b-42b5-acba-92e487647a1c.png)

## Question detail page

On the homepage “Recent Questions” section, the user can click on either the question title or the answer count to go to the detail question page. “Quesitonpage.php” is used as a frame for this part.

On the question detail page, users can view the question title, question description, when and by whom the question is posted. They can also see how many answers are posted to the question, the answer details, when and by whom the answers are posted, the likes received by each answer, and if the user likes the answer or not. There is a text box too where the user can post his answer to the question. Every user can post one or multiple answers to one question, even if he/she is the author of that question.

![image](https://user-images.githubusercontent.com/91846138/173265783-a5f2f2a9-f76d-4f49-8e80-c11392e6988c.png)

To load a particular question, the system will initialize a Post class and call the load one question function in Post class to connect to the database and select that question information. In order to allow bookmarking the question detail page, the question id is sent over from homepage through the href path, which can be retrieved via SESSION function call. This allows bookmarking a question page since the url itself contains the question id which we will need to use for selecting a particular question from the database. When we bookmark the question page, we save the question id too.

If the user wants to post his answer to the question, he/she can type it in the text box and click on the “Post your answer” button. “addAnswer.php” will take care of inserting the answer into the database. The answer will be firstly cleaned by strip_tags() function and then the system will initialize an Answer class and call the “addAnswer()” function to connect to the database and to insert the answer. 

“Answer.php” in the class folder is used to handle answer related operations. There are functions in Answer class to insert answers into the database and load different number of answers. We will see it again in the profile page part.

Once the answer is inserted into the database, the system will show an “Answer posted!” message to the user and the user can click on “Return to question page” to go back to the previous page.

![image](https://user-images.githubusercontent.com/91846138/173265864-ce99ad9f-2f04-4864-870a-cefb9cedb497.png)


As mentioned previously, users can hit like on others’ answers and their own answers too. Meanwhile they can only like an answer once. Once they click on the likes, they cannot undo it. The question page will be refreshed to show the date and the time when the user liked the answer, and make the like button unclickable. “Answer.php” is used to check if the user has liked the answer or not by making a selection query to the likes table in the database. If the database shows the user liked the answer already, then the system will not show the like button but the detail information when the user liked the answer. When “Answer.php” loads all the answers, it will dynamically concatenate the likes information below each answer. 

Once the user hits the like, the code in  “Questionpage.php” will make queries to insert the like information into the likes table and update the number of likes and the user status in the user table if required. 

The screenshot below shows two answers. The first one is liked by the logged-in user and the second one is not liked.

![image](https://user-images.githubusercontent.com/91846138/173265917-50346d41-cbfb-4e51-8609-500a62e7a35d.png)


## All questions page

This page is used to browse all the questions stored in the database. As the question table size is still small yet (just include a few sample questions), I didn’t add the infinite scrolling function to keep loading batches of questions from the database but we can definitely add this functionality when the database is large. 

![image](https://user-images.githubusercontent.com/91846138/173265995-f4998665-603c-490a-902d-cf87956a4a5f.png)

There two ways to browse the questions. One is to just click on the question title or the answer count and it will guide to the question page which is discussed already. The second way to browse the questions is to browse the related questions for a particular topic hierarchy by selecting each level of topics and then hit the search button. This functionality is very similar to the one I used in the add question page. “browseTopic.php” is used to handle this functionality and to show all the related questions. 

Below the screenshot shows the returned page after users select the topic levels. The layout is similar to the all questions page. Users can still click on the question title or the answer count to head for the question detail page.

![image](https://user-images.githubusercontent.com/91846138/173266037-83250d37-bb2c-4683-984a-421e47e12eb7.png)

## Profile page

Users can click on the “Profile” on the right side of the header, the profile image on the homepage, or the username on the homepage to go to their own profile page.

On the profile page, the system shows the user’s registered information on the left. In the center part, the system shows the most rent five questions and the most recent five answers posted by the user. “Profile.php” is used to show the profile page. 

![image](https://user-images.githubusercontent.com/91846138/173266094-f57925ef-6887-40e6-be5a-a574105faad5.png)

If a user wants to see all the questions he/she posted, he/she can click on “Your questions” which links to a “All your questions” page where it shows all the questions posted by the user in reverse chronological order. Again, it is a similar page to the pages with a list of questions discussed before. “userQuestion.php” helps to show this all your questions page.  On the top of the page, there is also a link to the previous page which is the profile page.

![image](https://user-images.githubusercontent.com/91846138/173266125-aab63e45-a458-4182-82ce-1fe7ed60b1b7.png)


Similarly, a user can also click on “Your answers” to see all the answers she/he posted . “userAnswer.php” is used to show “All your answers” page. The system will initialize a new Answer class and call the “loadYourAnswers()” function to show the list of all the answers posted by the user in reverse chronological order.

![image](https://user-images.githubusercontent.com/91846138/173266156-b978fafb-1857-4600-bf33-a4cccab737b0.png)

## Search by keyword page

The search function is embedded in the center of the header for every page after a user logs in. Users can type keyword in the search text box and hit the search button for searching. “search.php” will take over the job from there. 

For the search method, three queries are made to generate the list of questions which contain the keyword. Question titles have the highest relevancy, next is question description and the last is the corresponding answers:

1.	Select the questions in reverse chronological order of which the question titles contain the keyword – most relevant
2.	Select the questions in reverse chronological order of which the question description contains the keyword – lower relevant
3.	Select the questions in reverse chronological order of which the corresponding answers contain the keyword – lowest relevant

Here I use while loops and a string to concatenate all the result from each query in the order above so the result is listed by the chosen relevancy order. To avoid same questions showing up multiple times, I use an array to store the question ids met already. If the array contains the question id, then system will simply pass on it. The result count is also calculated when generating the result list. Below is the example and the keyword is “NJ”. Similar to other question list pages, users can click on the question title or the answer count to go to the question detail page.

![image](https://user-images.githubusercontent.com/91846138/173266230-719b9fc1-05fb-4ca8-913b-86500a500815.png)

## Log out

Users can simply click on the “Logout” on the right corner of the header. “Logout.php” will call the session destroy() function to end the current status and return back to the login page.



