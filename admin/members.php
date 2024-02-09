
<?php 


session_start() ; 

if (isset($_SESSION['username'])) {

    $pageTitle = "members" ;

    include "./int.php";
    
    include $page ; 

    include  $tpl . "Footer.php"  ;

}else {

    header('location : index.php') ;
    exit() ; 

}





?>