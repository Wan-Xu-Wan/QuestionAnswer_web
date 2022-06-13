<?php 
	include "header.php";
	include "class/User.php";
	include "class/Question.php";
	include "class/Topic.php";

	
 ?>

 <?php 
	$firsttopic = new Topic($connect);
	$topic1_name= $firsttopic->topic1_Selection();
	

 ?>
<script>
	var topic1_Object = <?php echo json_encode($topic1_name);?>;
		
	window.onload = function() {
	var topic1Sel = document.getElementById("topic1");
	var topic2Sel = document.getElementById("topic2");
	var topic3Sel = document.getElementById("topic3");


	for (var i = 0; i < topic1_Object.length; i++) {
		var opt = topic1_Object[i];
		topic1Sel.appendChild(new Option(opt, opt));
	}

	topic1Sel.onchange = function() {
		var selected_1 = $(this).find("option:selected").text();
		topic3Sel.length = 1;
 		topic2Sel.length = 1;
		
		$.ajax( {
			url:'ajax_topic.php',
			type:'GET',
			data:{topic1: selected_1},
			dataType:'json',
			cache: false,
			success:function(response) {
				var data= response;
				var test = document.getElementById("topic2");
				for (var i = 0; i < data.length; i++) {
					var opt =data[i];
					test.appendChild(new Option(opt, opt));
				}
			},
				error:function(xhr, textStatus, error){
				alert(textStatus);
				alert(error);
    		}


		});

	}
	topic2Sel.onchange = function() {
		topic3Sel.length = 1;
		var selected_11 = $('#topic1').find("option:selected").text();
		var selected_2 = $('#topic2').find("option:selected").text();		
		$.ajax( {
			url:'ajax_topic2.php',
			type:'GET',
			data:{topic1: selected_11, topic2: selected_2},
			dataType:'json',
			cache: false,
			success:function(response) {
				var data= response;
				var test = document.getElementById("topic3");
				for (var i = 0; i < data.length; i++) {
					var opt =data[i];
					test.appendChild(new Option(opt, opt));
				}
			},
				error:function(xhr, textStatus, error){
				alert(textStatus);
				alert(error);
    		}


		});
	}
}
</script>

	<div class="center column">
	
		<form name="form1" id="form1" action="browseTopic.php" method="POST" >
            Topic Level 1: 
            <select name="topic1" id="topic1">
                <option value="" selected="selected">Please select topic 1</option>
            </select>
            <br>
            Topic Level 2: 
            <select name="topic2" id="topic2">
                <option value="" selected="selected">Please select topic 2</option>
            </select>
            <br>
            Topic Level 3: 
            <select name="topic3" id="topic3">
                <option value="" selected="selected">Please select topic if state tax</option>
            </select>
            <br>
            <button name="browseTopic">Search</button>
 
	    </form>

        <div class="allQuestion">All Questions</div>
        <br>

        <?php 

            $res="";
            $questions = mysqli_query($connect, "SELECT * from Question ORDER BY q_timestamp DESC LIMIT 15");

            if(mysqli_num_rows($questions) > 0) {


                while ($row= mysqli_fetch_array($questions)) {

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
        
        ?>




	</div>
	
	</div>




	</div>
</body>
</html>