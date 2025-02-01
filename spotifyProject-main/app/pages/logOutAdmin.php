<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        require '../config/sessions.inc.php';

        $_SESSION['adminId'] = null;

        header('Location:logInAdmin.php');
    }

?>