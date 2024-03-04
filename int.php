<?php 

    ini_set('display_errors' , 'on') ;
    error_reporting(E_ALL) ;

    $sessionUser = '' ;

    if (isset($_SESSION['user'])) {

        $sessionUser = $_SESSION['user'] ;

    }

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