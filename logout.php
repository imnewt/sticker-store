<?php 
    session_start();
    if(!isset($_SESSION["user"]) || !isset($_SESSION["customer"])){
        header("Location: index.php");
    }
    unset($_SESSION["user"]);
    unset($_SESSION["customer"]);
    header("Location: index.php");
?>