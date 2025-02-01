<?php

    require '../config/sessions.inc.php';
    // if($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_SESSION['adminId'])){
    //     header('Location:logInAdmin.php');
    // }

    if(empty($_SESSION['adminId'])){
        header('Location:logInAdmin.php');
    }

    function all_users(){
        try{
            require '../config/db.inc.php';

            $query = 'SELECT DISTINCT * FROM users LEFT JOIN payments ON payments.user_id = users.id;';
            $the_prep = $pdo->prepare($query);
            $the_prep->execute();

            $fetched_users = $the_prep->fetchAll(PDO::FETCH_ASSOC);

            return $fetched_users;
        } catch(PDOException $e){
            echo "Failed " . $e->getMessage();
        }
    }

    $current_users = all_users();


    function numSongs($current_users){
        $num_songs = [];
        foreach($current_users as $user){
            try{
                require '../config/db.inc.php';
                $query = 'SELECT * FROM artists_added WHERE user_added = :user_id';
                $the_prep = $pdo->prepare($query);

                $the_prep->bindParam(':user_id',$user['id']);

                $the_prep->execute();

                $fetched_users = $the_prep->fetchAll(PDO::FETCH_ASSOC);

                if($fetched_users){
                    array_push($num_songs,count($fetched_users));
                }else{
                    array_push($num_songs,0);
                }
            } catch(PDOException $e){
                echo 'Failed Because Of ' . $e->getMessage();
            }
        }

        return $num_songs;
    }

    $num_songs = numSongs($current_users);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat|Quicksand|Anaheim|Roboto Slab">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
    <style>
        body{
            background-color:#181818;
            overflow:hidden;
        }
        .container{
            height:100vh;
            width:100%;
            display:flex;
            justify-content:center;
            align-items:center;
            position:relative;
        }
        table{
            border-collapse:collapse;
        }

        table,td,tr,th{
            border:1px solid white;
            border-radius:2px;
            font-family:'Quicksand';
            padding:15px;
            color:white;
            cursor:pointer;
            transition:.5s ease-in-out;
        }

        td:hover{
            background:white;
            color:#333;
        }

        #logOutButton{
            padding:8px 22px;
            position:absolute;
            right:5%;
            top:5%;
            background-color:white;
            color:#333;
            font-family:'Quicksand',sans-serif;
            font-weight:1000;
            cursor:pointer;
            z-index:1;
            border-radius:6px;

        }
    </style>
</head>
<body>
    <h1 style='position:absolute;color:white;font-family:"Quicksand",sans-serif;font-weight:1000;font-size:22px; padding-left:10px;'>Admin Dashboard</h1>
    <button id='logOutButton'><a href="logOutAdmin.php" style="text-decoration:none;color:#333;">Log out</a></button>
    <div class="container">
        <p style="position:absolute;top:27%;color:white;font-family:'Quicksand';font-size:17px; font-weight:1000;">User Stats:</p>
        <?php if($current_users): ?>
            <table>
                <thead>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Payment Method</th>
                    <th>Number Of Songs Added</th>
                </thead>
                
                <tbody>
                    <?php foreach($current_users as $index => $user): ?>
                        <tr>
                            <td><?php echo $user['username'] ?></td>
                            <td><?php echo $user['email'] ?></td>
                            <td><?php echo $user['payment_id'] ? $user['method'] : 'No Payment' ?></td>
                            <td><?php echo $num_songs[$index] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>