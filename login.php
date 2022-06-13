<?php

    if(isset($_POST['login_button'])) {
        $loginemail = strip_tags($_POST['login_email']);
        $_SESSION['login_email'] = $loginemail;
        $password = md5($_POST['login_password']);

        $login_query = mysqli_query($connect, "SELECT * FROM users where email='$loginemail' AND password = '$password'");

        if (mysqli_num_rows($login_query) == 1) {
            $row = mysqli_fetch_array($login_query);
            $username = $row['user_name'];
            $_SESSION['username'] = $username;
            header('Location: homepage.php');
            exit();
        } else {
            array_push($errors,"Invalid email or password");
        }

    }
?>
