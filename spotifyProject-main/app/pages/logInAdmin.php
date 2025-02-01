<?php
        

    function logIn($admin_username,$admin_password){
        try{
            require '../config/db.inc.php';
            $query = 'SELECT * FROM adminuser WHERE username = :username AND password = :password;';
            $prep = $pdo->prepare($query);
            $prep->bindParam(':username',$admin_username);
            $prep->bindParam(':password',$admin_password);

            $prep->execute();
            $fetched_admin = $prep->fetch(PDO::FETCH_ASSOC);

            if($fetched_admin){
                return $fetched_admin;
            }
        } catch(PDOException $e){
            echo "Failed Because Of " . $e->getMessage();
        }
        return false;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        require '../config/sessions.inc.php';

        $admin_username = $_POST['username'];
        $admin_password = $_POST['password'];


        if(logIn($admin_username,$admin_password)){
            $_SESSION['adminId'] = 1;
            header('Location:admin.php');
        }

       
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin </title>
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
                    <p>Welcome Admin</p>
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
            </div>
            
        </form>
    </div>
</body>
</html>