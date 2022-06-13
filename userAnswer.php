<?php 
include "header.php";
include "class/User.php";
include "class/Question.php";
include "class/Post.php";
include "class/Answer.php";

 ?>

	<div class="profile_info column">
	<a href="<?php echo $userinfo['user_name']; ?>">
		<img src="<?php echo $userinfo['head_img'];?>">
	</a>
	<br>
	<br>
	<div class="profile_left">
		
			<?php 
				echo "Username: ".$userinfo['user_name'];
			?>
		
		
	</div>
	<br>
	<br>
	<div class="profile_left_info">
		<?php
			echo "Email: ".$userinfo['email']."<br>";
			echo "City: ".$userinfo['city']."<br>";
			echo "State: ".$userinfo['state']."<br>";
			echo "Country: ".$userinfo['country']."<br>";
			echo "Status: ".$userinfo['user_status']."<br>";
			echo "Questions: ".$userinfo['num_questions']."<br>";
			echo "Answers: ".$userinfo['num_answers']."<br>";
			echo "Likes: ".$userinfo['num_likes']."<br>";
			echo "Self Introduction: ".$userinfo['user_description'];
		
		?>
	</div>

	</div>

	<div class="center column">
		<div>
			<a href="<?php echo $userinfo['user_name']; ?>"> ← Return to previous page</a>
		</div>
		<br>
		<div class="profile_title">
			
			<a href="#">All your answers</a>

		</div>
		<br>
		<?php 
			$postAnswer = new Answer($connect, $_SESSION['email'], $_SESSION['password']);
			$postAnswer->loadYourAnswers();

		?>



	</div>




	</div>
</body>
</html>