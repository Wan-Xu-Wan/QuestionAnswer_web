
use tax101_revised;

create table userStatusCrit (
	user_status varchar(20) primary key,
    min_best_answers int,
    max_best_answers int,
    min_num_likes int,
    max_num_likes int);

use tax101_revised;
create table users(
	user_id int primary key auto_increment,
    user_name varchar(50) unique not null,
    email varchar(50),
    password varchar(50),
    city varchar(50),
    state varchar(50),
    country varchar(50),
    user_description varchar(255),
    head_img varchar(255),
	register_date date,
    num_questions int,
    num_likes int,
    num_answers int,
    user_status varchar(20));

INSERT INTO users(user_name, email, password, city, state, country, user_description, head_img, register_date, num_posts, num_likes, num_best_answers, user_status) VALUES ('Paul_Kushal','pk@nyu.edu', 'PK231', 'New York','NY','USA', 'I am a retired tax professor','Project/images/1.img','2017-04-03',0,0,0,'platinum');
INSERT INTO users(user_name, email, password, city, state, country, user_description,head_img, register_date, num_posts, num_likes, num_best_answers, user_status) VALUES ('Kelly_Young','ky@gmail.com', 'KK931', 'New York','NY','USA', 'struggling with tax','Project/images/2.img','2017-04-05',0,0,0,'basic');
INSERT INTO users(user_name, email, password, city, state, country, user_description,head_img, register_date, num_posts, num_likes, num_best_answers, user_status) VALUES ('TaxStudent','ts@gmail.com', '342TS', 'Harrison','NJ','USA', 'learning tax','Project/images/2.img','2017-04-01',0,0,0,'silver');
INSERT INTO users(user_name, email, password, city, state, country, user_description,head_img, register_date, num_posts, num_likes, num_best_answers, user_status) VALUES ('Lily_Kores','lk@gmail.com', 'lklklalala', 'Irvine','CA','USA', 'i love tax!','Project/images/2.img','2017-02-01',0,0,0,'golden');
INSERT INTO users(user_name, email, password, city, state, country, user_description,head_img, register_date, num_posts, num_likes, num_best_answers, user_status) VALUES ('John_Smith','JS@gmail.com', 'JS3366KS', 'Edison','NJ','USA', 'learn to prepare my own tax return','Project/images/2.img','2017-01-01',0,0,0,'basic');

use tax101_revised;
create table question(
	q_id int primary key auto_increment,
    user_id int not null,
    q_title TEXT,
    q_timestamp timestamp,
    q_description LONGTEXT,
    q_status varchar(20),
    foreign key (user_id) references user(user_id));
    
INSERT INTO question(q_id, user_id, q_title, q_timestamp, q_description, q_status) VALUES ('1','2','Urgent! How to file an NJ extension for individual tax return?', '2021-04-01 00:00:01', 'I cannot finish my NJ return before 4/15. Can someone advise how to file a NJ extension?','solved');
INSERT INTO question(q_id, user_id, q_title, q_timestamp, q_description, q_status) VALUES ('2','2','How to receive a federal tax refund if i dont have a U.S. bank account?', '2022-04-05 12:00:01', 'My friend just moved from Mexico last November and she does not have a U.S. banck account yet. How can she get a federal tax refund? Can IRS deposit the refund to a foreign bank account?','solved'); 
INSERT INTO question(q_id, user_id, q_title, q_timestamp, q_description, q_status) VALUES ('3','5','What is the difference betweeen shorterm capital gain and longterm capital gain for tax?', '2021-03-07 16:54:01', 'I am wondering how the tax rules dertermine shortterm vs longterm? What is the tax rate for each?','solved');   
INSERT INTO question(q_id, user_id, q_title, q_timestamp, q_description, q_status) VALUES ('4','5','Why did I receive a tax form called Schedule K-1? What is that?', '2019-03-21 09:40:21', 'Today I just received a Schdeule k1 from a mutual fund I bought through my brokerage account. What should I do with it?','solved');       
INSERT INTO question(q_id, user_id, q_title, q_timestamp, q_description, q_status) VALUES ('5','5','I have an apartment for rent in California but I live in New Jersey. How to report that rental income?', '2020-03-17 08:40:21', 'As stated in the title, I do not want to get double taxed on that rental income. Do I have to file a CA return for it?','solved');  	
INSERT INTO question(q_id, user_id, q_title, q_timestamp, q_description, q_status) VALUES ('6','3','Does anyone know about if we can take deduction for the tuition I paid for graduate school on the federal tax return?', '2022-02-11 20:50:21', 'My tuition is so expensive. Wondering if IRS allows me to reduce some tax for it.','solved');  	
INSERT INTO question(q_id, user_id, q_title, q_timestamp, q_description, q_status) VALUES ('7','4','What is Schedule k3?', '2022-04-11 21:30:54', 'Never saw that form before. Can someone explain what is used for?','unsolved'); 
INSERT INTO question(q_id, user_id, q_title, q_timestamp, q_description, q_status) VALUES ('8','2','Do I have to pay tax on the capital gain of selling my own house?', '2022-02-11 21:26:12', 'Wanted to see how much I will have to pay before listing my house on Zillow','solved');    


create table answer(
	a_id int primary key auto_increment,
    q_id int not null,
    user_id int not null,
    a_timestamp timestamp,
    a_description LONGTEXT,
    a_status varchar(20),
    a_update_time timestamp,
    foreign key (q_id) references question(q_id),
    foreign key (user_id) references user(user_id));

INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('1','1','1', '2021-04-03 22:28:11', 'If you file an extension for federal and have no tax due for NJ, you can get an auto extension for NJ. Just remember to attach the federal extension application to your NJ return when yo file it. If you have a tax due, you can find more details here: https://www.state.nj.us/treasury/taxation/njit17.shtml');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('2','1','3', '2021-04-02 14:03:39', 'NJ allows auto extension');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('3','1','4', '2021-04-02 15:56:41', 'Check the instructions. It will tell you how to file an extension for NJ');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('4','2','1', '2022-04-06 08:01:19', 'You will need a U.S. bank account if you want to receive a direct deposit from IRS. IRS can also send you a tax refund check by US postal mail. In that case, please make sure your name and address info are correct and reachable. If you move or change your address after you submitted your tax return, you will need to file a Form 8822 Change of Address so IRS has the latest address on file to send the check to you');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('5','2','4', '2022-04-07 11:11:26', 'It will take much longer for IRS to mail you a tax refund check. Suggest getting a bank account before filing the return');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('6','3','1', '2021-03-09 12:51:37', 'If you hold an asset for a year or less and sell it, the gain will be treated as short-term. If you hold it for longer than a year, then it can be treated as long-term capital gain. Short-term capital gain will be taxed at the same rate as your ordinary income such as wages.Highest tax rate for short-term can be up to 37%. Whilte the highest Long term capital tax rate is only 20%.');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('7','3','3', '2021-03-08 21:33:35', 'short-term <= 12 months, long-term > 12 months. short-term: no tax benefit; long-term: up to 20% tax rate.');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('8','4','1', '2019-03-23 19:40:34', 'If you invest in a partnership, you will receive a schedule K-1 for tax reporting. You will have to include the taxable income and expenses from the K-1 in your own tax return. I guess the mutual fund you bought may be treated as a public traded partnership so they send you a K-1. Partnership tax rules are complex. You may  consult with a tax advisor or post more detailded questions here so people can help.');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('9','4','4', '2019-03-22 17:12:39', 'Passthrough entities do not pay tax. They use Schedule K-1s to pass the taxable items to investors. You will need to report Schedule K-1 line items on your own individaul tax return.');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('10','5','1', '2020-03-18 06:21:51', 'Rental income from a property located in California is treated as CA state source income. You will have to file a CA state return and pay tax for that rental income to CA if you own that rental property directly. You will also need to report that income on your NJ state return and claim a tax credit for the tax you pay to CA to avoid double taxation');    
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('11','5','3', '2020-03-19 08:11:28', 'You can pay tax to CA and claim a credit on your NJ state return. CA state income tax rate is pretty high. Not a good idea to invest in rental property there.');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('12','6','1', '2022-02-12 14:21:11', 'There is a new rule in 2022 about education credit. You can receive a tax credit for the qualified education expenses and of course you will have to meet certain criteria too. There are two types of education credit: one is the American opportunity tax credit (up to $2500) and the other one is life time learning credit(up to $2000). You can only take one of them. For more details see here: https://www.irs.gov/credits-deductions/individuals/education-credits-aotc-llc#:~:text=An%20education%20credit%20helps%20with,lifetime%20learning%20credit%20(LLC).');       
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('13','6','4', '2022-02-12 16:23:44', 'You may be qualifed to receive a tax credit for the tuition you paid. Check IRS website for the eligibility');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('14','7','3', '2022-04-12 12:21:42', 'Schedule K-3 is new for 2021. It is an extension for Schedule K-1 and is used to reprot items of interational tax relevance from the operation of a partnership.');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('15','8','1', '2022-02-14 09:11:55', 'If you live in a home for a toal of 2 years in hthe past 5 years, you can be exempt from captal gain tax on the first $250,000 if you file as single or $500,000 if you file as married filing jointly.');
    
create table likes(
	user_id int not null,
    a_id int not null,
    like_timestamp timestamp,
    primary key (user_id, a_id),
    foreign key (user_id) references user(user_id),
    foreign key (a_id) references answer(a_id));
    
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('2', '1','2021-04-03 23:28:11' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('2', '2','2021-04-03 21:28:11' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('2', '3','2021-04-03 21:36:22' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('2', '4','2022-04-07 11:32:24' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('2', '5','2022-04-07 22:36:24' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('2', '6','2021-03-11 18:56:21' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('2', '7','2021-03-10 19:33:54' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('2', '8','2019-03-24 20:43:12' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('2', '9','2019-03-24 20:43:12' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('2', '10','2020-03-18 11:02:12' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('2', '11','2020-03-18 11:02:12' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('2', '12','2022-02-13 10:23:28' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('2', '13','2022-02-13 23:23:11' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('2', '14','2022-04-13 21:36:08' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('2', '15','2022-02-16 07:21:31' );


INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('5', '1','2021-04-03 23:57:11' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('5', '2','2021-04-03 22:28:33' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('5', '3','2021-04-03 21:37:13' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('5', '4','2022-04-07 12:34:42' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('5', '5','2022-04-07 23:45:24' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('5', '6','2021-03-11 19:32:21' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('5', '7','2021-03-10 21:31:54' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('5', '8','2019-03-24 22:45:59' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('5', '9','2019-03-24 22:28:21' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('5', '10','2020-03-18 12:52:47' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('5', '11','2020-03-18 12:43:12' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('5', '12','2022-02-13 11:26:28' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('5', '13','2022-02-14 21:27:11' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('5', '14','2022-04-13 22:43:08' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('5', '15','2022-02-16 08:45:35' );


INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('3', '1','2021-04-04 21:52:11' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('3', '3','2021-04-04 06:23:13' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('3', '4','2022-04-08 14:11:49' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('3', '5','2022-04-08 19:36:24' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('3', '6','2021-03-12 10:42:55' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('3', '8','2019-03-25 15:46:30' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('3', '9','2019-03-25 19:19:31' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('3', '10','2020-03-19 16:48:32' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('3', '12','2022-02-14 12:38:11' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('3', '13','2022-02-15 23:27:11' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('3', '14','2022-02-17 09:49:35' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('3', '15','2022-02-17 16:33:37' );

INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('1', '1','2021-04-04 23:52:11' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('1', '3','2021-04-04 06:22:13' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('1', '4','2022-04-08 14:51:49' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('1', '5','2022-04-08 19:36:24' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('1', '6','2021-03-12 10:22:55' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('1', '8','2019-03-25 17:46:30' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('1', '9','2019-03-25 19:23:31' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('1', '10','2020-03-19 21:36:32' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('1', '12','2022-02-14 21:36:11' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('1', '13','2022-02-15 15:22:11' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('1', '14','2022-02-17 11:43:35' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('1', '15','2022-02-17 17:43:37' );

INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('4', '1','2021-04-04 01:52:11' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('4', '3','2021-04-04 23:22:13' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('4', '4','2022-04-08 17:51:50' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('4', '5','2022-04-08 21:36:22' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('4', '6','2021-03-12 11:22:44' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('4', '8','2019-03-25 16:36:30' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('4', '9','2019-03-27 20:23:45' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('4', '10','2020-03-21 21:55:32' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('4', '12','2022-02-14 21:45:11' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('4', '13','2022-02-15 15:36:11' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('4', '14','2022-02-17 11:11:35' );
INSERT INTO likes(user_id, a_id, like_timestamp) VALUES ('4', '15','2022-02-18 17:38:37' );

create table BestAnswer(
	q_id varchar(5) not null,
    a_id varchar(5),
    primary key (q_id, a_id),
    foreign key (q_id) references question(q_id),
    foreign key (a_id) references answer(a_id));

use tax101_revised;    
create table topic(
	topic_id int primary key auto_increment,
    topic_name varchar(50));

create table TopicHierarchy(
	th_id int primary key auto_increment,
	topic_id int,
    higherLevel_topic_id int,
    highestLevel_topic_id int,
    foreign key (topic_id) references topic(topic_id),
    foreign key (higherLevel_topic_id) references topic(topic_id),
    foreign key (highestLevel_topic_id) references topic(topic_id));
    
create table QuestionTopic(
	q_id int,
    th_id int,
    primary key (q_id, th_id),
    foreign key (q_id) references question(q_id),
	foreign key (th_id) references TopicHierarchy(th_id));
    
INSERT INTO topic(topic_id, topic_name) VALUES ('1', 'individual income tax');
INSERT INTO topic(topic_id, topic_name) VALUES ('2', 'partnership tax');
INSERT INTO topic(topic_id, topic_name) VALUES ('3', 'capital gain tax');
INSERT INTO topic(topic_id, topic_name) VALUES ('4', 'estate and gift tax');
INSERT INTO topic(topic_id, topic_name) VALUES ('5', 'other tax topics');
INSERT INTO topic(topic_id, topic_name) VALUES ('6', 'federal tax');
INSERT INTO topic(topic_id, topic_name) VALUES ('7', 'state tax');
INSERT INTO topic(topic_id, topic_name) VALUES ('8', 'others');
INSERT INTO topic(topic_id, topic_name) VALUES ('9', 'NJ');
INSERT INTO topic(topic_id, topic_name) VALUES ('10', 'NY');
INSERT INTO topic(topic_id, topic_name) VALUES ('11', 'CA');

INSERT INTO TopicHierarchy(th_id, topic_id, higherLevel_topic_id, highestLevel_topic_id) VALUES ('1', '11', '7','1');
INSERT INTO TopicHierarchy(th_id, topic_id, higherLevel_topic_id, highestLevel_topic_id) VALUES ('2','11', '7','2');
INSERT INTO TopicHierarchy(th_id, topic_id, higherLevel_topic_id, highestLevel_topic_id) VALUES ('3','11', '7','3');
INSERT INTO TopicHierarchy(th_id, topic_id, higherLevel_topic_id, highestLevel_topic_id) VALUES ('4','11', '7','4');
INSERT INTO TopicHierarchy(th_id, topic_id, higherLevel_topic_id, highestLevel_topic_id) VALUES ('5','11', '7','5');

INSERT INTO TopicHierarchy(th_id, topic_id, higherLevel_topic_id, highestLevel_topic_id) VALUES ('6','10', '7','1');
INSERT INTO TopicHierarchy(th_id, topic_id, higherLevel_topic_id, highestLevel_topic_id) VALUES ('7','10', '7','2');
INSERT INTO TopicHierarchy(th_id, topic_id, higherLevel_topic_id, highestLevel_topic_id) VALUES ('8','10', '7','3');
INSERT INTO TopicHierarchy(th_id, topic_id, higherLevel_topic_id, highestLevel_topic_id) VALUES ('9','10', '7','4');
INSERT INTO TopicHierarchy(th_id, topic_id, higherLevel_topic_id, highestLevel_topic_id) VALUES ('10','10', '7','5');

INSERT INTO TopicHierarchy(th_id, topic_id, higherLevel_topic_id, highestLevel_topic_id) VALUES ('11','9', '7','1');
INSERT INTO TopicHierarchy(th_id, topic_id, higherLevel_topic_id, highestLevel_topic_id) VALUES ('12','9', '7','2');
INSERT INTO TopicHierarchy(th_id, topic_id, higherLevel_topic_id, highestLevel_topic_id) VALUES ('13','9', '7','3');
INSERT INTO TopicHierarchy(th_id, topic_id, higherLevel_topic_id, highestLevel_topic_id) VALUES ('14','9', '7','4');
INSERT INTO TopicHierarchy(th_id, topic_id, higherLevel_topic_id, highestLevel_topic_id) VALUES ('15','9', '7','5');

use tax101_revised;
INSERT INTO TopicHierarchy(th_id, highestLevel_topic_id,higherLevel_topic_id,topic_id) VALUES ('16','1', '6',NULL);
INSERT INTO TopicHierarchy(th_id, highestLevel_topic_id,higherLevel_topic_id,topic_id) VALUES ('17','2', '6',NULL);
INSERT INTO TopicHierarchy(th_id, highestLevel_topic_id,higherLevel_topic_id,topic_id) VALUES ('18','3', '6',NULL);
INSERT INTO TopicHierarchy(th_id, highestLevel_topic_id,higherLevel_topic_id,topic_id) VALUES ('19','4', '6',NULL);
INSERT INTO TopicHierarchy(th_id, highestLevel_topic_id,higherLevel_topic_id,topic_id) VALUES ('20','5', '6',NULL);

INSERT INTO TopicHierarchy(th_id, highestLevel_topic_id,higherLevel_topic_id,topic_id) VALUES ('21','1', '7',NULL);
INSERT INTO TopicHierarchy(th_id, highestLevel_topic_id,higherLevel_topic_id,topic_id) VALUES ('22','2', '7',NULL);
INSERT INTO TopicHierarchy(th_id, highestLevel_topic_id,higherLevel_topic_id,topic_id) VALUES ('23','3', '7',NULL);
INSERT INTO TopicHierarchy(th_id, highestLevel_topic_id,higherLevel_topic_id,topic_id) VALUES ('24','4', '7',NULL);
INSERT INTO TopicHierarchy(th_id, highestLevel_topic_id,higherLevel_topic_id,topic_id) VALUES ('25','5', '7',NULL);

INSERT INTO TopicHierarchy(th_id, highestLevel_topic_id,higherLevel_topic_id,topic_id) VALUES ('26','1', '8',NULL);
INSERT INTO TopicHierarchy(th_id, highestLevel_topic_id,higherLevel_topic_id,topic_id) VALUES ('27','2', '8',NULL);
INSERT INTO TopicHierarchy(th_id, highestLevel_topic_id,higherLevel_topic_id,topic_id) VALUES ('28','3', '8',NULL);
INSERT INTO TopicHierarchy(th_id, highestLevel_topic_id,higherLevel_topic_id,topic_id) VALUES ('29','4', '8',NULL);
INSERT INTO TopicHierarchy(th_id, highestLevel_topic_id,higherLevel_topic_id,topic_id) VALUES ('30','5', '8',NULL);



INSERT INTO QuestionTopic(q_id, th_id) VALUES ('1','11');
INSERT INTO QuestionTopic(q_id, th_id) VALUES ('2','16');
INSERT INTO QuestionTopic(q_id, th_id) VALUES ('3','18');
INSERT INTO QuestionTopic(q_id, th_id) VALUES ('4','16');
INSERT INTO QuestionTopic(q_id, th_id) VALUES ('5','1');
INSERT INTO QuestionTopic(q_id, th_id) VALUES ('6','16');
INSERT INTO QuestionTopic(q_id, th_id) VALUES ('7','17');
INSERT INTO QuestionTopic(q_id, th_id) VALUES ('8','18');
    
INSERT INTO userStatusCrit(user_status, min_best_answers, max_best_answers, min_num_likes, max_num_likes) VALUES ('basic',0,0, 0,0);
INSERT INTO userStatusCrit(user_status, min_best_answers, max_best_answers, min_num_likes, max_num_likes) VALUES ('silver',1,2, 1,4);
INSERT INTO userStatusCrit(user_status, min_best_answers, max_best_answers, min_num_likes, max_num_likes) VALUES ('golden',3,4, 5,8);
INSERT INTO userStatusCrit(user_status, min_best_answers, max_best_answers, min_num_likes, max_num_likes) VALUES ('platinum',5,null, 9,null);
    

INSERT INTO question(q_id, user_id, q_title, q_timestamp, q_description, q_status) VALUES ('1','2','Urgent! How to file an NJ extension for individual tax return?', '2021-04-01 00:00:01', 'I cannot finish my NJ return before 4/15. Can someone advise how to file a NJ extension?','solved');
INSERT INTO question(q_id, user_id, q_title, q_timestamp, q_description, q_status) VALUES ('2','2','How to receive a federal tax refund if i dont have a U.S. bank account?', '2022-04-05 12:00:01', 'My friend just moved from Mexico last November and she does not have a U.S. banck account yet. How can she get a federal tax refund? Can IRS deposit the refund to a foreign bank account?','solved'); 
INSERT INTO question(q_id, user_id, q_title, q_timestamp, q_description, q_status) VALUES ('3','5','What is the difference betweeen shorterm capital gain and longterm capital gain for tax?', '2021-03-07 16:54:01', 'I am wondering how the tax rules dertermine shortterm vs longterm? What is the tax rate for each?','solved');   
INSERT INTO question(q_id, user_id, q_title, q_timestamp, q_description, q_status) VALUES ('4','5','Why did I receive a tax form called Schedule K-1? What is that?', '2019-03-21 09:40:21', 'Today I just received a Schdeule k1 from a mutual fund I bought through my brokerage account. What should I do with it?','solved');       
INSERT INTO question(q_id, user_id, q_title, q_timestamp, q_description, q_status) VALUES ('5','5','I have an apartment for rent in California but I live in New Jersey. How to report that rental income?', '2020-03-17 08:40:21', 'As stated in the title, I do not want to get double taxed on that rental income. Do I have to file a CA return for it?','solved');  	
INSERT INTO question(q_id, user_id, q_title, q_timestamp, q_description, q_status) VALUES ('6','3','Does anyone know about if we can take deduction for the tuition I paid for graduate school on the federal tax return?', '2022-02-11 20:50:21', 'My tuition is so expensive. Wondering if IRS allows me to reduce some tax for it.','solved');  	
INSERT INTO question(q_id, user_id, q_title, q_timestamp, q_description, q_status) VALUES ('7','4','What is Schedule k3?', '2022-04-11 21:30:54', 'Never saw that form before. Can someone explain what is used for?','unsolved'); 
INSERT INTO question(q_id, user_id, q_title, q_timestamp, q_description, q_status) VALUES ('8','2','Do I have to pay tax on the capital gain of selling my own house?', '2022-02-11 21:26:12', 'Wanted to see how much I will have to pay before listing my house on Zillow','solved');    



INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('1','1','1', '2021-04-03 22:28:11', 'If you file an extension for federal and have no tax due for NJ, you can get an auto extension for NJ. Just remember to attach the federal extension application to your NJ return when yo file it. If you have a tax due, you can find more details here: https://www.state.nj.us/treasury/taxation/njit17.shtml');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('2','1','3', '2021-04-02 14:03:39', 'NJ allows auto extension');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('3','1','4', '2021-04-02 15:56:41', 'Check the instructions. It will tell you how to file an extension for NJ');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('4','2','1', '2022-04-06 08:01:19', 'You will need a U.S. bank account if you want to receive a direct deposit from IRS. IRS can also send you a tax refund check by US postal mail. In that case, please make sure your name and address info are correct and reachable. If you move or change your address after you submitted your tax return, you will need to file a Form 8822 Change of Address so IRS has the latest address on file to send the check to you');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('5','2','4', '2022-04-07 11:11:26', 'It will take much longer for IRS to mail you a tax refund check. Suggest getting a bank account before filing the return');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('6','3','1', '2021-03-09 12:51:37', 'If you hold an asset for a year or less and sell it, the gain will be treated as short-term. If you hold it for longer than a year, then it can be treated as long-term capital gain. Short-term capital gain will be taxed at the same rate as your ordinary income such as wages.Highest tax rate for short-term can be up to 37%. Whilte the highest Long term capital tax rate is only 20%.');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('7','3','3', '2021-03-08 21:33:35', 'short-term <= 12 months, long-term > 12 months. short-term: no tax benefit; long-term: up to 20% tax rate.');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('8','4','1', '2019-03-23 19:40:34', 'If you invest in a partnership, you will receive a schedule K-1 for tax reporting. You will have to include the taxable income and expenses from the K-1 in your own tax return. I guess the mutual fund you bought may be treated as a public traded partnership so they send you a K-1. Partnership tax rules are complex. You may  consult with a tax advisor or post more detailded questions here so people can help.');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('9','4','4', '2019-03-22 17:12:39', 'Passthrough entities do not pay tax. They use Schedule K-1s to pass the taxable items to investors. You will need to report Schedule K-1 line items on your own individaul tax return.');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('10','5','1', '2020-03-18 06:21:51', 'Rental income from a property located in California is treated as CA state source income. You will have to file a CA state return and pay tax for that rental income to CA if you own that rental property directly. You will also need to report that income on your NJ state return and claim a tax credit for the tax you pay to CA to avoid double taxation');    
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('11','5','3', '2020-03-19 08:11:28', 'You can pay tax to CA and claim a credit on your NJ state return. CA state income tax rate is pretty high. Not a good idea to invest in rental property there.');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('12','6','1', '2022-02-12 14:21:11', 'There is a new rule in 2022 about education credit. You can receive a tax credit for the qualified education expenses and of course you will have to meet certain criteria too. There are two types of education credit: one is the American opportunity tax credit (up to $2500) and the other one is life time learning credit(up to $2000). You can only take one of them. For more details see here: https://www.irs.gov/credits-deductions/individuals/education-credits-aotc-llc#:~:text=An%20education%20credit%20helps%20with,lifetime%20learning%20credit%20(LLC).');       
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('13','6','4', '2022-02-12 16:23:44', 'You may be qualifed to receive a tax credit for the tuition you paid. Check IRS website for the eligibility');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('14','7','3', '2022-04-12 12:21:42', 'Schedule K-3 is new for 2021. It is an extension for Schedule K-1 and is used to reprot items of interational tax relevance from the operation of a partnership.');
INSERT INTO answer(a_id, q_id, user_id, a_timestamp, a_description) VALUES ('15','8','1', '2022-02-14 09:11:55', 'If you live in a home for a toal of 2 years in hthe past 5 years, you can be exempt from captal gain tax on the first $250,000 if you file as single or $500,000 if you file as married filing jointly.');

use tax101_revised;
create table userStatusCrit (
	user_status varchar(20) primary key,
    min_num_likes int,
    max_num_likes int);
    
use tax101_revised;
INSERT INTO userStatusCrit(user_status, min_num_likes, max_num_likes) VALUES ('basic',0,0);
INSERT INTO userStatusCrit(user_status, min_num_likes, max_num_likes) VALUES ('silver', 1,11);
INSERT INTO userStatusCrit(user_status, min_num_likes, max_num_likes) VALUES ('golden', 12,20);
INSERT INTO userStatusCrit(user_status, min_num_likes, max_num_likes) VALUES ('platinum',21,null);
