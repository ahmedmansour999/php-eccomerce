<?php

function lang($param)
{

    static $lang = array(


        //DashBoard NavBar page

        "HOME"               => "Home",
        "CATEGORIES"         => "Categories",
        "ITEMS"              =>   'Items',
        'MEMBER'              =>  'Members',
        "STATISITICS"        => "Statistics",
        "COMMENTS"             => "Comments",
        "LOGS"                => 'Logs',
        "EDITE_PROFILE"      => "Edite Profile",
        "SETTING"            => "Setting",
        "LOGOUT"             => "Logout",
        "" => "",

    );


    return $lang[$param];
}
