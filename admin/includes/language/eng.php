<?php

    function lang( $param ) {

        static $lang = array(

            
            //DashBoard NavBar page

            "HOME"               => "Home" ,
            "CATEGORIES"         => "Categories" ,
            "EDITE_PROFILE"      => "Edite Profile" ,
            "SETTING"            => "Setting" ,
            "LOGOUT"             => "Logout" ,
            "" => "" ,

        ) ;


        return $lang[$param] ;

    }