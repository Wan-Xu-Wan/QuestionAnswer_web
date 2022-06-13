<?php 
	include "header.php";
	include "class/User.php";
	include "class/Question.php";
	include "class/Post.php";
	include "class/Answer.php";
	$qid = $_GET['question'];
	//$_SESSION['qid']=$qid;

?>
<?php 
	if (isset($_POST['Like_button'])) {
		$logged_userid=$_SESSION['userid'];
		$answerid=$_POST['a_id'];
		$like_query=mysqli_query($connect, "INSERT INTO likes VALUES('$logged_userid', '$answerid', now())") or die('error'.mysqli_error($connect));
		$likecount_query=mysqli_query($connect,"SELECT t1.user_id as userid, count(*) as likecount FROM answer t1 JOIN likes t2 WHERE t1.a_id=t2.a_id AND t1.user_id in 
												(SELECT user_id from answer WHERE a_id='$answerid')
												GROUP BY t1.user_id ") or die('error'.mysqli_error($connect));
		$likecount_array=mysqli_fetch_array($likecount_query);
		$numLike=$likecount_array['likecount'];
		$answer_user=$likecount_array['userid'];

		$platinum_query= mysqli_query($connect,"SELECT* FROM userStatusCrit WHERE user_status='platinum'")or die('error'.mysqli_error($connect));
		$platinum_array= mysqli_fetch_array($platinum_query);
		$golden_query= mysqli_query($connect,"SELECT* FROM userStatusCrit WHERE user_status='golden'")or die('error'.mysqli_error($connect));
		$golden_array= mysqli_fetch_array($golden_query);
		$silver_query= mysqli_query($connect,"SELECT* FROM userStatusCrit WHERE user_status='silver'")or die('error'.mysqli_error($connect));
		$silver_array= mysqli_fetch_array($silver_query);


		$set_status_query=mysqli_query($connect, "UPDATE users SET num_likes='$numLike' WHERE user_id='$answer_user'");
		if ($numLike >= $platinum_array['min_num_likes']) {
			$set_status_query=mysqli_query($connect, "UPDATE users SET user_status='platinum' WHERE user_id='$answer_user'");
		} else if ($numLike >= $golden_array['min_num_likes'] AND $numLike <=$golden_array['max_num_likes']) {
			$set_status_query=mysqli_query($connect, "UPDATE users SET user_status='golden' WHERE user_id='$answer_user'");
		} else if ($numLike >= $silver_array['min_num_likes'] AND $numLike <=$silver_array['max_num_likes']) {
			$set_status_query=mysqli_query($connect, "UPDATE users SET user_status='silver' WHERE user_id='$answer_user'");
		}
	}

?>

	<div class="center column">

		<div class="recentpost">

		</div>

		<div>
		<?php 
			$post = new Post($connect, $_SESSION['email'], $_SESSION['password']);
			$q_id=$_GET['question'];
			$post->loadOneQ($q_id);

		?>

		</div>

		<div>
            <form  action="addanswer.php? question=<?php echo $qid; ?>" name="postAnswer" method="POST">
            <textarea name="answerbody" id="answerbody"></textarea>
            <br>
            <input type="submit" name="postAnswerBtn" value="Post your answer">
            <br>
            </form>
        </div>
        <div>

        </div>
        
        <div>
        <?php
        $answers = new Answer($connect, $_SESSION['email'], $_SESSION['password']);
        $answers->loadAnswers($qid);
        ?>

        </div>


	</div>





</div>
</body>
</html>