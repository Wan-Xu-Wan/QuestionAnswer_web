<?php 
class Topic {
    private $connect;
    private $topic1_query;
    private $topic2_query;
    private $topic3_query;
	private $topic1;
    private $topic2;
    private $topic3;


	public function __construct($connect){
		$this->connect = $connect;
		$this->topic1_query = mysqli_query($connect, "SELECT distinct topic_id,topic_name FROM topic WHERE topic_id in (SELECT distinct highestLevel_topic_id from topicHierarchy)");
        $this->topic2_query = mysqli_query($connect, "SELECT distinct topic_id, topic_name FROM topic WHERE topic_id in (SELECT distinct higherLevel_topic_id from topicHierarchy)");
		$this->topic3_query = mysqli_query($connect, "SELECT distinct topic_id, topic_name FROM topic WHERE topic_id in (SELECT distinct topic_id from topicHierarchy)");


	}

    function topic1_Selection() {
        $option1=array();


        while( $row=mysqli_fetch_array($this->topic1_query)) {
            $name1=$row['topic_name'];
            array_push($option1, $name1);

        }

        return $option1;
    }

    function topic2_Selection($topic_name) {
        $option1=array();
        $query=  mysqli_query($this->connect, "SELECT distinct topic_id,topic_name FROM topic WHERE topic_id in (SELECT 
        distinct higherLevel_topic_id from topicHierarchy WHERE highestLevel_topic_id in (SELECT distinct topic_id from topic WHERE topic_name='$topic_name'))");

        while( $row=mysqli_fetch_array($query)) {
            $name1=$row['topic_name'];
            array_push($option1, $name1);

        }
        return $option1;
    }
    function topic3_Selection($topic1_name,$topic2_name) {

        $option1=array();
        $query=  mysqli_query($this->connect, "SELECT distinct topic_id,topic_name FROM topic WHERE topic_id in (SELECT distinct topic_id from topicHierarchy WHERE highestLevel_topic_id in (SELECT distinct topic_id from topic WHERE topic_name='$topic1_name') AND higherLevel_topic_id in (SELECT distinct topic_id from topic WHERE topic_name='$topic2_name') )");

        while( $row=mysqli_fetch_array($query)) {
            $name1=$row['topic_name'];
            array_push($option1, $name1);

        }

        return $option1;
    }


}

?>