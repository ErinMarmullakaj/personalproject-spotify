<?php
    $host = 'mysql:host=localhost;dbname=spotifyProject';
    $username_db = 'root';
    $password_db = '';

    try{
        $pdo = new PDO($host,$username_db,$password_db);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
        echo "Failed " . $e->getMessage();
    }

?>