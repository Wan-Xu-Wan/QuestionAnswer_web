<?php 
	include "connectDB.php";
	include "class/User.php";
	include "class/Question.php";
	include "class/Topic.php";

    if(isset($_GET['topic2'])) {
        $topic1_selected = $_GET['topic1'];
        $topic2_selected = $_GET['topic2'];
        $topics = new Topic($connect);
	    $topic3_name= $topics->topic3_Selection($topic1_selected, $topic2_selected);

       echo json_encode($topic3_name);
    }


?>