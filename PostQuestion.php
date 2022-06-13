<?php 
    	include "header.php";
        include "class/User.php";
        include "class/Question.php";
        include "class/Topic.php";


		if(isset($_POST['q_submit']) && isset($_POST['topic1']) && isset($_POST['topic2'])) {
			$logged_email = $_SESSION['email'];
			$logged_password= $_SESSION['password'];
			$logged_userid=$_SESSION['userid'];
			//$user = new User($connect, $logged_email, $logged_password);

			$title= strip_tags($_POST['question_title']);
			$body= strip_tags($_POST['question_body']);
			$topic1 = $_POST['topic1'];
			$topic2 = $_POST['topic2'];
			$topic3 = $_POST['topic3'];

			if($topic2=="state tax" && $topic3==null) {
				echo "You have to select a topic level 3 since state tax is selected!";
			} else {

				$question = new Question($connect, $logged_email, $logged_password);
				$question->addQuestion($title, $body, $topic1, $topic2, $topic3);

				echo "<div>Posted the question successfully! <br> </div>";

			}

			//header("Location: homepage.php");
		} else {
			echo "You have to select topic levels!";
		}

?>

<div>
    <form >
        <a  href="homepage.php" id= "return" class="return">
            Return to homepage
        </a>

    </form>
    
</div>


</body>
</html>
