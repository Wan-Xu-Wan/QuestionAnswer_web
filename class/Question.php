<?php
class Question {
	private $user;
	private $connect;

	public function __construct($connect, $email, $password){
		$this->connect = $connect;
		$this->user = new User($connect, $email, $password);

	}

	public function addQuestion($title, $body, $topic1, $topic2, $topic3) {
		$title = strip_tags($title);
		$body = strip_tags($body);
		//$userid = $this->user->getUserid();
		$userid=$_SESSION['userid'];

		$body = str_replace('\r\n', '\n', $body);
		$body = nl2br($body);

		$title = mysqli_real_escape_string($this->connect, $title);
		$body = mysqli_real_escape_string($this->connect, $body);
		$title_check_empty= preg_replace('/\s+/', '', $title);
		$body_check_empty= preg_replace('/\s+/', '', $body);


		if($body_check_empty !="" AND $title_check_empty !="") { 
			//$userid = $this->user->getUserid();

			//insert question
			$insert_query = mysqli_query($this->connect, "INSERT INTO question VALUES('', '$userid', '$title', now(), '$body')") or die('error'.mysqli_error($this->connect));
			$returned_id = mysqli_insert_id($this->connect) or die('error'.mysqli_error($this->connect)) ;

			$topicid1_query = mysqli_query($this->connect, "SELECT topic_id FROM topic WHERE topic_name = '$topic1'") or die('error'.mysqli_error($this->connect));
			$topicid1_array= mysqli_fetch_array($topicid1_query);
			$topicid1=$topicid1_array['topic_id'];

			$topicid2_query = mysqli_query($this->connect, "SELECT topic_id FROM topic WHERE topic_name = '$topic2'");
			$topicid2_array= mysqli_fetch_array($topicid2_query);
			$topicid2=$topicid2_array['topic_id'];

			//insert question topic ids
			
			if($topic3 == null) {
				$topic_query =  mysqli_query($this->connect, "SELECT th_id FROM topicHierarchy WHERE higherLevel_topic_id = '$topicid2' AND highestLevel_topic_id='$topicid1'") or die('error'.mysqli_error($this->connect));
				$topicHierarchy = mysqli_fetch_array($topic_query);
				$th_id=$topicHierarchy['th_id'];
				$question_topic_query = mysqli_query($this->connect, "INSERT INTO questiontopic VALUES('$returned_id', '$th_id')") or die('error'.mysqli_error($this->connect));
			} else {
				$topicid3_query = mysqli_query($this->connect, "SELECT topic_id FROM topic WHERE topic_name = '$topic3'");
				$topicid3_array= mysqli_fetch_array($topicid3_query);
				$topicid3=$topicid3_array['topic_id'];

				$topic_query =  mysqli_query($this->connect, "SELECT th_id FROM topicHierarchy WHERE topic_id = '$topicid3' AND higherLevel_topic_id='$topicid2' AND highestLevel_topic_id = '$topicid1'") or die('Could not connect:'.mysqli_error($this->connect));
				$topicHierarchy = mysqli_fetch_array($topic_query);
				$th_id=$topicHierarchy['th_id'];

				$question_topic_query = mysqli_query($this->connect, "INSERT INTO questiontopic VALUES('$returned_id', '$th_id')") or die('error'.mysqli_error($this->connect));
			}

			

			//update user number of questions
			$num_q_query = mysqli_query($this->connect, "SELECT user_id, count(q_id) as q_count FROM question WHERE user_id = '$userid'");
			$num_q_array = mysqli_fetch_array($num_q_query);
			$num_questions = $num_q_array['q_count'];

			$update_query = mysqli_query($this->connect, "UPDATE users SET num_questions='$num_questions' WHERE user_id='$userid'");
		}
	}




}

?>