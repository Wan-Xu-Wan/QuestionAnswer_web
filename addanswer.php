<?php 
    include "header.php";
    include "class/User.php";
    include "class/Question.php";
    include "class/Topic.php";
    include "class/Answer.php";
        
        
        if(isset($_POST['postAnswerBtn'])) {
            $qid = $_GET['question'];
            $answerbody =strip_tags($_POST['answerbody']); 
            $postAnswer = new Answer($connect, $_SESSION['email'], $_SESSION['password']);
            $postAnswer->addAnswer($qid, $answerbody);
            echo "<p>Answer Posted! </p>";
            
        } else {
            echo "error";
        }
        //header("location:Questionpage.php? question=$qid");

?>

<div>
    <form >
        <a  href='Questionpage.php? question=<?php echo $qid; ?>' id= "return" class="return">
            Return to question page
        </a>

    </form>
    
</div>
