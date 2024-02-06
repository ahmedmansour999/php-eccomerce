<?php 

    $tpl = "./includes/template/"  ; 

    $english = "./includes/language/eng.php" ;
    
    $arabic = "./includes/language/arab.php" ;

    $connection = "./connection.php" ;


    include $connection ;
 



    include $tpl . "Header.php";

    include $english;

    if (!isset($noNavBar)) {
        include $tpl . "navbar.php";
    }

    include  $tpl . "Footer.php" 



?>