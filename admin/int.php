<?php 

    $connection = "./connection.php" ;
    $tpl = "./includes/template/"  ; 
    $function = "./includes/function/" ; 
    $english = "./includes/language/eng.php" ;
    $arabic = "./includes/language/arab.php" ;
    $page = "./pages.php" ;


    include $connection ;
    include $function . "function.php" ;
   
 



    include $tpl . "Header.php";

    include $english;

    if (!isset($noNavBar)) {
        include $tpl . "navbar.php";
    }

    





?>