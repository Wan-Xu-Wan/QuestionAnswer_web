<?php
class Post {
	private $user;
	private $connect;

	public function __construct($connect, $email, $password){
		$this->connect = $connect;
		$this->user = new User($connect, $email, $password);

	}

    public function loadQuestions() {
        $res="";
        $questions = mysqli_query($this->connect, "SELECT * from Question ORDER BY q_timestamp DESC LIMIT 15");

        if(mysqli_num_rows($questions) > 0) {


            while ($row= mysqli_fetch_array($questions)) {
 
                $userid= $row['user_id'];
                $user_query = mysqli_query($this->connect, "SELECT user_name from Users WHERE user_id='$userid' ");
                $userFetch= mysqli_fetch_array($user_query);
                $username = $userFetch['user_name'];
                $title = $row['q_title'];
                $description= $row['q_description'];
                $q_time= $row['q_timestamp'];
                $qid= $row['q_id'];

                $answer_query= mysqli_query($this->connect, "SELECT a_id from Answer WHERE q_id='$qid' ");
                $answer_count = mysqli_num_rows($answer_query);

                $res .="<div class='question_post'>

                            <div class='posted_by' style='color:#ACACAC;'> posted by 
                               $username &nbsp;&nbsp;&nbsp;&nbsp;$q_time
                            </div>
                            <div id='post_title'>
                                <a href='Questionpage.php? question=".$qid."'>$title</a>
                               
                            </div>
                            
                            <div id='post_body'>
                                $description
                                
                            </div>
                            <br>
                            <div class='answer_count'>
                                <a href='Questionpage.php? question=".$qid."'>Answers ($answer_count)</a>
                            </div>
                        </div>
                        <hr>
                
                
                ";
            }

        }

        echo $res;
    }

    public function loadOneQ($q_id) {
        $res="";
        $qid=$q_id;
        //$_GET['question'];
        $questions = mysqli_query($this->connect, "SELECT * from Question WHERE q_id= '$qid' ORDER BY q_timestamp DESC ");
        $row= mysqli_fetch_array($questions);

        $userid= $row['user_id'];
        $user_query = mysqli_query($this->connect, "SELECT user_name from Users WHERE user_id='$userid' ");
        $userFetch= mysqli_fetch_array($user_query);
        $username = $userFetch['user_name'];
        $title = $row['q_title'];
        $description= $row['q_description'];
        $q_time= $row['q_timestamp'];
        $qid= $row['q_id'];

        $answer_query= mysqli_query($this->connect, "SELECT a_id from Answer WHERE q_id='$qid' ");
        $answer_count = mysqli_num_rows($answer_query);

        $res .="<div class='question_post'>

                    
                    <div class='oneQ' id='oneQ_title'>

                    
                    $title
                        
                        
                    </div>
                    <br>
                    <div id='post_body'>
                        $description
                        
                    </div>
                    <br>
                    <div class='posted_by' style='color:#ACACAC;'> posted by 
                        $username &nbsp;&nbsp;&nbsp;&nbsp;$q_time
                    </div>
                    <br>
                    <div class='answer_count'>
                        <a href='Questionpage.php? question=".$qid."'>Answers ($answer_count)</a>
                    </div>
                </div>
                <hr>
        
        
        ";
    

        echo $res;
    }

    public function loadFiveQuestions() {
        $res="";
        $userid=$_SESSION['userid'];
        $questions = mysqli_query($this->connect, "SELECT * from Question WHERE user_id ='$userid' ORDER BY q_timestamp DESC LIMIT 5");

        if(mysqli_num_rows($questions) > 0) {


            while ($row= mysqli_fetch_array($questions)) {
 
                $title = $row['q_title'];
                $description= $row['q_description'];
                $q_time= $row['q_timestamp'];
                $qid= $row['q_id'];

                $answer_query= mysqli_query($this->connect, "SELECT a_id from Answer WHERE q_id='$qid' ");
                $answer_count = mysqli_num_rows($answer_query);

                $res .="<div class='question_post'>


                            <div id='post_title'>
                                <a href='Questionpage.php? question=".$qid."'>$title</a>
                               
                            </div>
                            
                            <div id='post_body'>
                                $description
                                
                            </div>
                            <br>
                            <div class='answer_count'>
                                <a href='Questionpage.php? question=".$qid."'>Answers ($answer_count)</a>
                            </div>
                        </div>
                        <hr>
                
                
                ";
            }

        }

        echo $res;
    }
    public function loadAllYourQuestions() {
        $res="";
        $userid=$_SESSION['userid'];
        $questions = mysqli_query($this->connect, "SELECT * from Question WHERE user_id ='$userid' ORDER BY q_timestamp DESC ");

        if(mysqli_num_rows($questions) > 0) {


            while ($row= mysqli_fetch_array($questions)) {
 
                $title = $row['q_title'];
                $description= $row['q_description'];
                $q_time= $row['q_timestamp'];
                $qid= $row['q_id'];

                $answer_query= mysqli_query($this->connect, "SELECT a_id from Answer WHERE q_id='$qid' ");
                $answer_count = mysqli_num_rows($answer_query);

                $res .="<div class='question_post'>


                            <div id='post_title'>
                                <a href='Questionpage.php? question=".$qid."'>$title</a>
                               
                            </div>
                            
                            <div id='post_body'>
                                $description
                                
                            </div>
                            <br>
                            <div class='answer_count'>
                                <a href='Questionpage.php? question=".$qid."'>Answers ($answer_count)</a>
                            </div>
                        </div>
                        <hr>
                
                
                ";
            }

        }

        echo $res;
    }

}

?>