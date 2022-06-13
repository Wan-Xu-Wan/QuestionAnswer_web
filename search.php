<?php 
	include "header.php";
	include "class/User.php";
	include "class/Question.php";
	include "class/Post.php";
	include "class/Answer.php";
	
	//$_SESSION['qid']=$qid;

?>
<?php 
    $q_array=array();
    $res="";
    $counter=0;
    $search_text="";
    $q_count=0;
	if ( isset($_GET['search_text'])) {
		$search_text= strip_tags($_GET['search_text']);

        $answer_q= mysqli_query($connect,"SELECT* FROM Question WHERE q_id IN (SELECT distinct q_id FROM Answer WHERE a_description LIKE '%$search_text%' ORDER BY a_timestamp DESC ) ORDER BY q_timestamp DESC");
        $title_query=mysqli_query($connect,"SELECT * FROM Question WHERE q_title LIKE '%$search_text%' ORDER BY q_timestamp DESC");
        $q_description_query=mysqli_query($connect,"SELECT * FROM Question WHERE q_description LIKE '%$search_text%' ORDER BY q_timestamp DESC");

        if(mysqli_num_rows($title_query) > 0) {


            while ($row= mysqli_fetch_array($title_query)) {
 
                $userid= $row['user_id'];
                $user_query = mysqli_query($connect, "SELECT user_name from Users WHERE user_id='$userid' ");
                $userFetch= mysqli_fetch_array($user_query);
                $username = $userFetch['user_name'];
                $title = $row['q_title'];
                $description= $row['q_description'];
                $q_time= $row['q_timestamp'];
                $qid= $row['q_id'];

                $answer_query= mysqli_query($connect, "SELECT a_id from Answer WHERE q_id='$qid' ");
                $answer_count = mysqli_num_rows($answer_query);


                if (in_array("$qid", $q_array)) {

                } else {
                    array_push($q_array, "$qid");
                    $counter++;
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

        }

        if(mysqli_num_rows($q_description_query) > 0) {


            while ($row= mysqli_fetch_array($q_description_query)) {
 
                $userid= $row['user_id'];
                $user_query = mysqli_query($connect, "SELECT user_name from Users WHERE user_id='$userid' ");
                $userFetch= mysqli_fetch_array($user_query);
                $username = $userFetch['user_name'];
                $title = $row['q_title'];
                $description= $row['q_description'];
                $q_time= $row['q_timestamp'];
                $qid= $row['q_id'];

                $answer_query= mysqli_query($connect, "SELECT a_id from Answer WHERE q_id='$qid' ");
                $answer_count = mysqli_num_rows($answer_query);

                if (in_array("$qid", $q_array)) {

                } else {
                    array_push($q_array, "$qid");
                    $counter++;

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

        }

        if(mysqli_num_rows($answer_q) > 0) {


            while ($row= mysqli_fetch_array($answer_q)) {
 
                $userid= $row['user_id'];
                $user_query = mysqli_query($connect, "SELECT user_name from Users WHERE user_id='$userid' ");
                $userFetch= mysqli_fetch_array($user_query);
                $username = $userFetch['user_name'];
                $title = $row['q_title'];
                $description= $row['q_description'];
                $q_time= $row['q_timestamp'];
                $qid= $row['q_id'];

                $answer_query= mysqli_query($connect, "SELECT a_id from Answer WHERE q_id='$qid' ");
                $answer_count = mysqli_num_rows($answer_query);

                if (in_array("$qid", $q_array)) {

                } else {
                    array_push($q_array, "$qid");
                    $counter++;

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

        }

        $q_count= array_count_values($q_array);


	}

?>

	<div class="center column">

		<div class="recentpost">

		</div>
        <div id="resultcount">
            <?php echo $counter.' result(s)';?>
        </div>
        <br>
        <div>
        <?php
            echo $res;

        ?>

        </div>


	</div>





</div>
</body>
</html>