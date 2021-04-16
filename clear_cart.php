<?php 
    if(isset($_GET["clearall"])){
        session_start();
        unset($_SESSION["cart_items"]);
        header("Location: index.php");
    }
    else{
        session_start();
        unset($_SESSION["cart_items"]);

        // $a = &$_SESSION["cart_items"][$index];
        // unset($a);
        
        // echo $index;
        header("Location: shopping_cart.php");
    }
?>