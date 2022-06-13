<?php
class Answer {
	private $user;
	private $connect;

	public function __construct($connect, $email, $password){
		$this->connect = $connect;
		$this->user = new User($connect, $email, $password);

	}


    public function loadAnswers($qid) {
        $res="";
        $answers = mysqli_query($this->connect, "SELECT t1.a_id AS a_id,  t1.user_id AS a_user_id, t1.a_timestamp AS a_timestamp, t1.a_description AS a_description, IFNULL(count(T2.user_id),0)as like_count
                                                    from answer t1 LEFT OUTER JOIN likes t2 on t1.a_id = t2.a_id  WHERE t1.q_id='$qid' GROUP BY t1.a_id ORDER BY like_count DESC, a_timestamp DESC ") or die(die('error'.mysqli_error($this->connect)));

        $num_row = mysqli_num_rows($answers);

        $logged_userid=$_SESSION['userid'];


        if(mysqli_num_rows($answers) > 0) {

            while ($row= mysqli_fetch_array($answers)) {
 
                $userid= $row['a_user_id'];
                $user_query = mysqli_query($this->connect, "SELECT user_name from Users WHERE user_id='$userid' ");
                $userFetch= mysqli_fetch_array($user_query);
                $username = $userFetch['user_name'];
               
                $description= $row['a_description'];
                $a_time= $row['a_timestamp'];
                $aid= $row['a_id'];
                $like_count= $row['like_count'];
                $_SESSION['a_like_id']=$aid;

                $youlike_query=mysqli_query($this->connect,"SELECT a_id, user_id, like_timestamp from likes where user_id = '$logged_userid' AND a_id='$aid'");


                if(mysqli_num_rows($youlike_query)>0) {
                    $youlike_fetch=mysqli_fetch_array($youlike_query);
                    $like_time= $youlike_fetch['like_timestamp'];
                    $res .="<div class='question_post'>
                            <div class='posted_by' style='color:#ACACAC;'> Answer posted by 
                                 $username &nbsp;&nbsp;&nbsp;&nbsp;$a_time 
                            </div>
                            <br>
                            <div id='post_body'>
                                $description
                                
                            </div>
                            <br>
                            <div id='like_contaniner'>
                                <div class='answer_count' id='like1'>Likes ($like_count)</div>
                                <div class='posted_by' style='color:#ACACAC;' id='like2'> you Liked on $like_time </div>   
                            </div>
                                                        
                        </div>
                        <hr>
                
                ";

                } else {
                    $res .="<div class='question_post'>
                            <div class='posted_by' style='color:#ACACAC;'> Answer posted by 
                                 $username &nbsp;&nbsp;&nbsp;&nbsp;$a_time 
                            </div>
                            <br>
                            <div id='post_body'>
                                $description
                                
                            </div>
                            <br>

                            
                            <form action='Questionpage.php? question=".$qid."' method='Post' >
                                <div class='answer_count'>
                                <input type='submit' class='Like_button' name='Like_button' id='Like_button' value='Likes'>
                                ($like_count)
                                <div>
                                    <input type='hidden' name='a_id' value='$aid'> 
                                </div>
                                </div>
                                
                                

                            </form>
                        </div>
                        <hr>
                
                ";

                }


                
            }

        }


        echo $res;
        $answers.exit();
    }

	public function addAnswer($qid, $a_body) {

		$body = strip_tags($a_body);
		//$userid = $this->user->getUserid();
		$userid=$_SESSION['userid'];

		$body = str_replace('\r\n', '\n', $body);
		$body = nl2br($body);

		$body = mysqli_real_escape_string($this->connect, $body);
		$body_check_empty= preg_replace('/\s+/', '', $body);


		if($body_check_empty !="" ) { 
			//$userid = $this->user->getUserid();

			//insert answer
			$insert_query = mysqli_query($this->connect, "INSERT INTO answer VALUES('', '$qid', '$userid', now(), '$body')") or die('error'.mysqli_error($this->connect));
			$returned_id = mysqli_insert_id($this->connect) or die('error'.mysqli_error($this->connect)) ;

			//update user number of answers
			$num_a_query = mysqli_query($this->connect, "SELECT user_id, count(a_id) as a_count FROM answer WHERE user_id = '$userid'");
			$num_a_array = mysqli_fetch_array($num_a_query);
			$num_answers = $num_a_array['a_count'];

			$update_query = mysqli_query($this->connect, "UPDATE users SET num_answers='$num_answers' WHERE user_id='$userid'");
		}
	}



    public function loadYourAnswers() {
        $res="";
        
        $logged_userid=$_SESSION['userid'];
        
        $answers = mysqli_query($this->connect, "SELECT t1.a_id AS a_id,  t1.user_id AS a_user_id, t1.a_timestamp AS a_timestamp, t1.a_description AS a_description, t1.q_id AS q_id, IFNULL(count(T2.user_id),0)as like_count
                                                    from answer t1 LEFT OUTER JOIN likes t2 on t1.a_id = t2.a_id  WHERE t1.user_id='$logged_userid' GROUP BY t1.a_id ORDER BY like_count DESC, a_timestamp DESC ") or die(die('error'.mysqli_error($this->connect)));

        $num_row = mysqli_num_rows($answers);

        $logged_userid=$_SESSION['userid'];


        if(mysqli_num_rows($answers) > 0) {

            while ($row= mysqli_fetch_array($answers)) {
 
                $userid= $row['a_user_id'];
                $user_query = mysqli_query($this->connect, "SELECT user_name from Users WHERE user_id='$userid' ");
                $userFetch= mysqli_fetch_array($user_query);
                $username = $userFetch['user_name'];
               
                $description= $row['a_description'];
                $a_time= $row['a_timestamp'];
                $aid= $row['a_id'];
                $like_count= $row['like_count'];
                $_SESSION['a_like_id']=$aid;
                $qid=$row['q_id'];

               // $youlike_query=mysqli_query($this->connect,"SELECT a_id, user_id, like_timestamp from likes where user_id = '$logged_userid' AND a_id='$aid'");
                $question = mysqli_query($this->connect, "SELECT * from Question WHERE q_id='$qid' ");
                $questionFetch= mysqli_fetch_array(($question));
                $title= $questionFetch['q_title'];

               // $youlike_fetch=mysqli_fetch_array($youlike_query);
               // $like_time= $youlike_fetch['like_timestamp'];
                $res .="<div class='question_post'>
                            <div id='post_title'>
                            <a href='Questionpage.php? question=".$qid."'>$title</a>
                        
                            </div>
                            <br>
                            <div id='post_body'>
                                $description
                                
                            </div>
                            <br>
                            <div id='like_contaniner'>
                                <div class='answer_count' id='like1'>Likes ($like_count)</div>
                               
                            </div>
                                                    
                    </div>
                    <hr>
            
                 ";

            }

        }


        echo $res;
        $answers.exit();
    }

    public function loadFiveAnswers() {
        $res="";
        
        $logged_userid=$_SESSION['userid'];
        
        $answers = mysqli_query($this->connect, "SELECT t1.a_id AS a_id,  t1.user_id AS a_user_id, t1.a_timestamp AS a_timestamp, t1.a_description AS a_description, t1.q_id AS q_id, IFNULL(count(T2.user_id),0)as like_count
                                                    from answer t1 LEFT OUTER JOIN likes t2 on t1.a_id = t2.a_id  WHERE t1.user_id='$logged_userid' GROUP BY t1.a_id ORDER BY like_count DESC, a_timestamp DESC LIMIT 5") or die(die('error'.mysqli_error($this->connect)));

        $num_row = mysqli_num_rows($answers);

        $logged_userid=$_SESSION['userid'];


        if(mysqli_num_rows($answers) > 0) {

            while ($row= mysqli_fetch_array($answers)) {
 
                $userid= $row['a_user_id'];
                $user_query = mysqli_query($this->connect, "SELECT user_name from Users WHERE user_id='$userid' ");
                $userFetch= mysqli_fetch_array($user_query);
                $username = $userFetch['user_name'];
               
                $description= $row['a_description'];
                $a_time= $row['a_timestamp'];
                $aid= $row['a_id'];
                $like_count= $row['like_count'];
                $_SESSION['a_like_id']=$aid;
                $qid=$row['q_id'];

               // $youlike_query=mysqli_query($this->connect,"SELECT a_id, user_id, like_timestamp from likes where user_id = '$logged_userid' AND a_id='$aid'");
                $question = mysqli_query($this->connect, "SELECT * from Question WHERE q_id='$qid' ");
                $questionFetch= mysqli_fetch_array(($question));
                $title= $questionFetch['q_title'];

               // $youlike_fetch=mysqli_fetch_array($youlike_query);
               // $like_time= $youlike_fetch['like_timestamp'];
                $res .="<div class='question_post'>
                            <div id='post_title'>
                            <a href='Questionpage.php? question=".$qid."'>$title</a>
                        
                            </div>
                            <br>
                            <div id='post_body'>
                                $description
                                
                            </div>
                            <br>
                            <div id='like_contaniner'>
                                <div class='answer_count' id='like1'>Likes ($like_count)</div>
                               
                            </div>
                                                    
                    </div>
                    <hr>
            
                 ";

            }

        }


        echo $res;
        $answers.exit();
    }




}

?>