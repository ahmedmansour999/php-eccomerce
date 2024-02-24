<?php 

    $connection = "./connection.php" ;
    $tpl = "./includes/template/"  ; 
    $function = "./includes/function/" ; 
    $english = "./includes/language/eng.php" ;
    $arabic = "./includes/language/arab.php" ;


    include $connection ;
    include $function . "function.php" ;
   
 



    include $english;
    include $tpl . "Header.php";








?>