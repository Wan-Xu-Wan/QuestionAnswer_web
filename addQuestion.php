<?php 
	include "header.php";
	include "class/User.php";
	include "class/Question.php";
	include "class/Topic.php";

	
 ?>

 <?php 
	$firsttopic = new Topic($connect);
	$topic1_name= $firsttopic->topic1_Selection();
	//$topic2_name= $firsttopic->topic2_Selection("individual income tax");

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
	
		<form name="form1" id="form1" action="PostQuestion.php" method="POST" >
		Topic Level 1: 
		<select name="topic1" id="topic1" required>
			<option value="" selected="selected" >Please select topic 1</option>
		</select>
		<br>
		Topic Level 2: 
		<select name="topic2" id="topic2" required>
			<option value="" selected="selected" >Please select topic 2</option>
		</select>
		<br>
		Topic Level 3: 
		<select name="topic3" id="topic3">
			<option value="" selected="selected">Please select topic if state tax</option>
		</select>
		<br>
		Title:
		<br>
		<textarea class="input" rows ="1" id="area1" name= "question_title" placeholder= "" required></textarea>
		<br>
		Body:
		<br>
		<textarea class="input" rows ="20" id="area2" name= "question_body" placeholder= "" required></textarea>
		<br>
		<input type="submit" value="Submit" name="q_submit">  
	</form>


	</div>
	
	</div>




	</div>
</body>
</html>