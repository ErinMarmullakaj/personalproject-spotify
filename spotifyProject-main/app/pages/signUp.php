<?php

    
    $error = null;

    function checkUsername($username){
        try{
            require '../config/db.inc.php';

            $the_query = 'SELECT * FROM users WHERE username = :username;';
            $the_preparment = $pdo->prepare($the_query);
            $the_preparment->bindParam(':username',$username);
            $the_preparment->execute();

            if($the_preparment->fetch(PDO::FETCH_ASSOC)){
                return false;
            }
        } catch(PDOException $e){
            echo "Failed " . $e->getMessage();
        }

        return true;
    }

    function signUp($username,$email,$password){
        try{
            require '../config/db.inc.php';

            $query = 'INSERT INTO users(username,email,password) VALUES (:username,:email,:password);';
            $the_prep = $pdo->prepare($query);

            $the_prep->bindParam(':username',$username);
            $the_prep->bindParam(':email',$email);
            $the_prep->bindParam(':password',$password);

            $the_prep->execute();

            if($the_prep->rowCount()){
                return true;
            }
        } catch(PDOException $e){
            echo "Failed " . $e->getMessage();

        }
        
        return false;
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(!empty($username) && !empty($email) && !empty($password)){
            if(checkUsername($username)){
                if(signUp($username,$email,$password)){
                    header('Location:logIn.php');
                }
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
                    <h3>Sign Up</h3>
                    <p>Your ultimate companion for discovering and enjoying your<br> favorite tunes anytime, anywhere.</p>
                </div>
            </div>
            <div class="form-wrapper">
                <div class="username-input">
                    <input type="text" placeholder="Username" name='username'>
                </div>
                <div class="email-input">
                    <input type="text" placeholder="Email" name='email'>
                </div>
                <div class="password-input">
                    <input type="password" placeholder="Password" name='password'>
                </div>
                <div class="signUp-button">
                    <button>Sign Up</button>
                </div>
                <div class="or-div">
                    <span>or</span> 
                </div>
            </div>
            
            <div class="buttons-wrapper">
                <button>Log In</button>
                <button>Admin</button>
            </div>
        </form>
    </div>
</body>
</html>