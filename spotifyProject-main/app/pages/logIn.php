<?php

    require '../config/sessions.inc.php';

    if(isset($_SESSION['userId'])){
        header('Location:index.php');
    }

    function logIn($username,$password){
        try{
            require '../config/db.inc.php';
            $the_query = "SELECT * FROM users WHERE username = :username AND password = :password;";
            $the_prep = $pdo->prepare($the_query);

            $the_prep->bindParam(':username',$username);
            $the_prep->bindParam(':password',$password);

            $the_prep->execute();

            $fetched_user = $the_prep->fetch(PDO::FETCH_ASSOC);

            return $fetched_user ? $fetched_user : false;
        } catch(PDOException $e){
            echo "Failed " . $e->getMessage();
        }

    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(!empty($username) && !empty($password)){
            $log_in = logIn($username,$password);
            if($log_in){
                $_SESSION['userId'] = $log_in['id'];
                header('Location:index.php');

            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="./styles/signUp.css?v=2.3">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat|Quicksand|Anaheim|Roboto Slab">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container">
        <form class="form-wrapper" action='' method='post'>
            <div class="title-logo">
                <div class="logo">
                    <img src="../assets/spotify.png" alt="logo" height='60' width='60'>
                </div>
                <div class="title-page">
                    <h3>Log In</h3>
                    <p>Welcome Back</p>
                </div>
            </div>
            <div class="form-wrapper">
                <div class="username-input">
                    <input type="text" placeholder="Username" name='username'>
                </div>
                <div class="password-input">
                    <input type="password" placeholder="Password" name='password'>
                </div>
                <div class="signUp-button">
                    <button>Log In</button>
                </div>
                <div class="or-div">
                    <span>or</span> 
                </div>
            </div>
            
            <div class="buttons-wrapper">
                <button><a href="signUp.php" style='text-decoration:none;color:white;'>Sign Up</a></button>
                <button><a href="admin.php" style='text-decoration:none;color:white'>Admin</a></button>
            </div>
        </form>
    </div>
</body>
</html>