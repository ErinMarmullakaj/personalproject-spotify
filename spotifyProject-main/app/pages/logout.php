<?php
    require '../config/sessions.inc.php';
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $_SESSION['userId'] = null;
        header('Location:logIn.php');
    }
?>