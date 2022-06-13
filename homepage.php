<?php 
	include "header.php";
	include "class/User.php";
	include "class/Question.php";
	include "class/Post.php";

?>
	<div class="userinfo column">
		<a href="<?php echo $userinfo['user_name']; ?>">
			<img src="<?php echo $userinfo['head_img'];?>">
		</a>
		<div class="userinfo_left">
			<a href="<?php echo $userinfo['user_name']; ?>">
				<?php 
					echo $userinfo['user_name'];
				?>
			</a>
			<br>
			<?php
			
				echo "Status: ".$userinfo['user_status']."<br>";
				
				echo "Likes: ".$userinfo['num_likes'];
			
			?>
		</div>

	</div>

	<div class="center column">
		<div class="btn-group">
			<button class="btn" onclick="window.location.href='addQuestion.php'">Ask Question</button>
			<br>
		</div>
		<div>
			<br>
		</div>

		<div class="recentpost">
			Recent Questions

			<br>
			<br>
		</div>

		<?php 
			$post = new Post($connect, $_SESSION['email'], $_SESSION['password']);
			$post->loadQuestions();

		?>

	</div>


	</div>
</body>
</html>