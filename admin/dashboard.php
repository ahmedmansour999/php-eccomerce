
<?php 


session_start() ; 

if (isset($_SESSION['username'])) {

    $pageTitle = "dashboard" ;

    include "./int.php";

     

    include  $tpl . "Footer.php" ;

    
}else {

    header('location : index.php') ;

}





?>