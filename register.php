<?php

    include "connectDB.php";

    $register_message = array();
    $errors=array();


    if(isset($_POST['register_button'])) {
        $username= strip_tags($_POST['user_name']); //prevent cross-site scripting
        $username= str_replace(' ','',$username);


        $email= strip_tags($_POST['user_email']); 
        $email= str_replace(' ','',$email);

        $email2= strip_tags($_POST['user_email2']); 
        $email2= str_replace(' ','',$email2);

        $password= strip_tags($_POST['user_password']); 

        $password2= strip_tags($_POST['user_password2']); 

        $city= strip_tags($_POST['user_city']);

        $state= strip_tags($_POST['user_state']); 

        $country= strip_tags($_POST['user_country']);


        $description= strip_tags($_POST['user_description']); 
        $_SESSION['r_description'] = $description; 

        $registerDate= date("Y-m-d");

   

        //check email
        if($email != $email2) {
            array_push($errors, "Emails don't match");
        } else {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email = filter_var($email, FILTER_VALIDATE_EMAIL);
                $email_check_query = "Select email from users where email = '$email'";
                $email_check = mysqli_query($connect, $email_check_query) or die ('Query failed'.mysqli_error($connect));
              
                if (mysqli_num_rows($email_check) > 0) {
                    array_push($errors, "Email registered already");
                }

            } else {
                array_push($errors, "Invalid email");
            }
        }

        // check username
        $username_check_query = "Select user_name from users where user_name = '$username'";
        $username_check = mysqli_query($connect, $username_check_query) or die ('Query failed'.mysqli_error($connect));
              
        if (mysqli_num_rows($username_check) > 0) {
            array_push($errors, "Username registered already");

        }

        if (strlen($description)>255) {
            array_push($errors, "Description exceeds 255 characters");
        }

        if ($password != $password2) {
            array_push($errors, "Passwords don't match");
        }

        if (strLen($password)>50 || strlen($password) < 8) {
            array_push($errors, "Password must be between 8 and 50 characters");
        }
        if (empty($errors)) {
            $password= md5($password);

            $head_img = "images/1.jpg";
            $insert_query = "INSERT INTO users(user_name, email, password, city, state, country, user_description, head_img, register_date, num_questions, num_likes, num_answers, user_status)
                            VALUES('$username', '$email', '$password', '$city', '$state', '$country', '$description', '$head_img', '$registerDate', '0', '0', '0', 'basic')";
            $insert= mysqli_query($connect, $insert_query ) or die ('Query failed'.mysqli_error($connect));
            array_push($register_message, "<span>Welcome to Tax 101! Now you can login!</span>");
        }

    }
    include "login.php";
?>

<html>
<head>
    <title>Login or Create Account</title>
    <link rel="stylesheet" type="text/css" href="css/loginstyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/register.js"></script>
</head>
<body>
    <?php 
        if(isset($_POST['register_button'])) {
            echo '
            <script>$(document).ready(function() {
                $("#loginnow").hide();
                $("#registernow").show();
            });
            </script>
            ';
        }
    ?>

    <div class="wrapper">

        <div class="loginpart">
        <div class="loginheader">
            <h1>Welcome to Tax 101</h1>
            Login or Sign up
        </div>
        <div id="loginnow">
            <form action="register.php" method="POST">
                <input type="email" name="login_email" placeholder="Email">
                <br>
                <input type="password" name="login_password" placeholder="Password">
                <br>
                <input type="submit" name="login_button" value="Login">
                <br>
                <?php
                    if (in_array("Invalid email or password", $errors)) {
                        echo "Invalid email or password<br>";
                    }
                ?>
                <a href="#" id= "register" class="register">
                    Or create account
                </a>
            </form>

        </div>
        <div id="registernow">
            <form action="register.php" method="POST">
                <input type="text" name="user_name" placeholder="Username" required>
                <br>
                <?php
                    if (in_array("User name registered already", $errors)) {
                        echo "Username registered already<br>";
                    }
                ?>
                <input type="email" name="user_email" placeholder="Email" required>
                <br>
                <?php
                    if (in_array("Email registered already", $errors)) {
                        echo "Email registered already<br>";
                    }
                ?>
                <?php
                    if (in_array("Invalid email", $errors)) {
                        echo "Invalid email<br>";
                    }
                ?>
                <?php
                    if (in_array("Emails don't match", $errors)) {
                        echo "Emails don't match<br>";
                    }
                ?>
                <input type="email" name="user_email2" placeholder="Confirm Email" required>
                <br>
                <input type="password" name="user_password" placeholder="Password" required>
                <br>
                <?php
                    if (in_array("Passwords don't match", $errors)) {
                        echo "Passwords don't match<br>";
                    }
                ?>
                <?php
                    if (in_array("Password must be between 8 and 50 characters", $errors)) {
                        echo "Password must be between 8 and 50 characters<br>";
                    }
                ?>
                <input type="password" name="user_password2" placeholder="Confirm Password" required>
                <br>
                <input type="text" name="user_city" placeholder="City" required>
                <br>
                <input type="text" name="user_state" placeholder="State" required>
                <br>
                <input type="text" name="user_country" placeholder="Country" required>
                <br>
                <textarea class="input" rows ="5" cols="20" name= "user_description" placeholder= "Description" required><?php
                    if (isset($_session['r_description'])) {
                        echo $_session['r_description'];
                    }
                ?></textarea>
                <br>
                <?php
                    if (in_array("Description exceeds 255 characters", $errors)) {
                        echo "Description exceeds 255 characters<br>";
                    }
                ?>
                <input type="submit" name="register_button" value="Register">
                <br>
                <?php
                    if (in_array("<span>Welcome to Tax 101! Now you can login!</span>", $register_message)) {
                        echo "<span >Welcome to Tax 101! Now you can login!</span><br>";
                    }
                ?>
                <a href="#" id= "return" class="return">
                    Return to sign in page
                </a>
                
            </form>

        </div>

        </div>
    </div>

</body>
</html>