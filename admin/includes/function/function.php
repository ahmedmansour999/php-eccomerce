<?php 

    // title function 

    function getTitle(){
        global $pageTitle ;
        if (isset($pageTitle)) {
            echo $pageTitle ;
        } else {
            echo "Default Title" ;
        }

    }

?>