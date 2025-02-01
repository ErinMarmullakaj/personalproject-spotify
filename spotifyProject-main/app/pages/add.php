<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $artist_id = (int)$_POST['artist_id'];

        try{
            require '../config/db.inc.php';
            require '../config/sessions.inc.php';

            $user_id = $_SESSION['userId'];

            $query = 'INSERT INTO artists_added(artist_added,user_added) VALUES (:artist_added,:user_added);';
            $the_prep = $pdo->prepare($query);

            $the_prep->bindParam(':artist_added',$artist_id);
            $the_prep->bindParam(':user_added',$user_id);

            $the_prep->execute();

            if($the_prep->rowCount()){
                header('Location:index.php');
            }
        } catch(PDOException $e){
            echo 'Failed ' . $e->getMessage();
        }
    }

?>