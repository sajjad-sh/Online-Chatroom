<?php 

    require_once "session.php";

    $host = $_SERVER['HTTP_HOST'];

    if(!$_SESSION['username']){
        header("Location: http://$host/modules/login.php");
        exit();
    }

?>