<?php 
	include "connectDB.php";
	include "class/User.php";
	include "class/Question.php";
	include "class/Topic.php";

    if(isset($_GET['topic1'])) {
        $topic1_selected = $_GET['topic1'];
        $topics = new Topic($connect);
	    $topic2_name= $topics->topic2_Selection($topic1_selected);

       // echo json_encode($topic1_selected);

       echo json_encode($topic2_name);
    }


?>