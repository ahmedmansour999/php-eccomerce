
<?php 


session_start() ; 
if (isset($_SESSION['username'])) {

    include "./int.php";
    
}else {

    header('location : index.php') ;

}





?>