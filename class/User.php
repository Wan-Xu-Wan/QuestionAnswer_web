<?php
class User {
	private $user;
	private $connect;

	public function __construct($connect, $email, $password){
		$this->connect = $connect;
		$userinfo_query = mysqli_query($connect, "SELECT * FROM users WHERE email='$email' AND password='$password'");
		$this->user = mysqli_fetch_array($userinfo_query);
	}

	public function getUsername() {
		return $this->user['user_name'];
	}

    public function getUserid() {
		return  $this->user['user_id'];
	}


	public function getNumLikes() {
		$userid = $this->user['user_id'];
		$query = mysqli_query($this->connect, "SELECT num_likes FROM users WHERE user_id='$userid'");
		$row = mysqli_fetch_array($query);
		return $row['num_likes'];
	}

    public function getNumQuestions() {
		$userid = $this->user['user_id'];
		$query = mysqli_query($this->connect, "SELECT num_questions FROM users WHERE user_id='$userid'");
		$row = mysqli_fetch_array($query);
		return $row['num_questions'];
	}

    public function getNumAnswers() {
		$userid = $this->user['user_id'];
		$query = mysqli_query($this->connect, "SELECT num_answers FROM users WHERE user_id='$userid'");
		$row = mysqli_fetch_array($query);
		return $row['num_answers'];
	}




}

?>