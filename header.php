<?php 
    include "connectDB.php";
    
    if(isset($_SESSION['username'])) {
        $logedin_user = $_SESSION['username'];
        $userinfo_query = mysqli_query($connect, "SELECT * FROM users where user_name ='$logedin_user'");
        $userinfo = mysqli_fetch_array($userinfo_query);
        $_SESSION['userid'] = $userinfo['user_id'];
        $_SESSION['email'] = $userinfo['email'];
        $_SESSION['password'] = $userinfo['password'];
    } 
?>

<html>
<head>
	<title>Welcome to Tax 101</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/homestyle.css">

</head>
<body>
    <div class="h_topbar">

  
        <div class="homepage">
            <a href="homepage.php">Tax 101</a>
        </div>

        <div class="search">

        <form action="search.php" method="GET" name="search_form">
            <input type="text"  name="search_text" placeholder="Search..." autocomplete="on" id="search_text_input">

            <div class="button_holder">
                <button type="submit"  name=""  id="search_button">
                    <img src="images/search.png">
                </button>
                
            </div>

        </form>

        <div class="search_results">
        </div>



        </div>



        <nav>
            <a class="leftnav" href="allQuestion.php">All Questions     </a>
            
            <a href="<?php echo $userinfo['user_name']; ?>">Profile   </a>
            <a href="logout.php">
				Logout
			</a>

        </nav>
    </div>
    <div class="wrapper">

   

