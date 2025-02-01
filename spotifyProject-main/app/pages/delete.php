<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['artist_id'])){
        $artist_id = (int)$_GET['artist_id'];
        try{
            require '../config/db.inc.php';
            require '../config/sessions.inc.php';

            $user_id = $_SESSION['userId'];

            $query = 'DELETE FROM artists_added WHERE artist_added = :artist_added AND user_added = :user_added;';
            $the_prep = $pdo->prepare($query);

            $the_prep->bindParam(':user_added',$user_id);
            $the_prep->bindParam(':artist_added',$artist_id);

            $the_prep->execute();

            if($the_prep->rowCount()){
                header('Location:seeArtists.php');
            }
        } catch(PDOException $e){
            die('Failed Because Of ' . $e->getMessage());
        }
    }

?>