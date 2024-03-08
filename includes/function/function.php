<?php

// FRONT END FUNCTION

/* 
    - get all categoris 
*/

function getCat(){

    global $con ;
    $stmt = $con->prepare('SELECT * FROM categories where parent = "0" ORDER BY ID ASC') ;
    $stmt->execute() ;
    $row = $stmt->fetchall() ; 
    return $row ;

}


/* 
    - get items of Categories 
*/
function getItems($where , $value , $sta = NULL ){

    global $con ;
    
    if ($sta == 1 ) {
    
        $sta = "AND APPROVE = '1' " ;

    }else if ($sta == 0) {

        $sta = 'AND APPROVE = "0" ' ;

    }else{

        $sta = NULL ;

    }   


    $stmt = $con->prepare("SELECT * FROM items Where $where = $value $sta ORDER BY item_id ASC  ") ;
    $stmt->execute() ;
    $row = $stmt->fetchall() ; 
    return $row ;

} ;



/*
    -SELECT FROM BD WITH CONDITION
    -FUNCTION ACCEPT => [SELECTED & table ^ CONDTION ]
    -RETURN DATE FROM DATABASE
*/
function getData($select , $table ,$condition = " "){
    global $con ;
    $stmt = $con->prepare("SELECT '$select' FROM items '$condition'  ") ;
    $stmt->execute() ;
    $row = $stmt->fetchall() ; 
    return $row ;
} ;


function globalData($select , $table ,$condition = null){
    global $con ;
    $stmt = $con->prepare("SELECT '$select' FROM $table $condition  ") ;
    $stmt->execute() ;
    $row = $stmt->fetchAll() ; 
    return $row ;
} ;

/*
    -SELECT FROM BD WITH CONDITION
    -FUNCTION ACCEPT => [SELECTED & table ^ CONDTION ]
    -RETURN DATE FROM DATABASE
*/
function getCount($select , $table ,$condition = " "){
    global $con ;
    $stmt = $con->prepare("SELECT $select FROM $table $condition  ") ;
    $stmt->execute() ;
    $count = $stmt->rowCount() ; 
    return $count ;
} ;



// title function 

function getTitle()
{
    global $pageTitle;
    if (isset($pageTitle)) {
        echo $pageTitle;
    } else {
        echo "Default Title";
    }
}



/*
     * Home Redirect Function v2.0 
     * This function Accept Parameters  
     * $theMsg echo  Message [success , error , warning ]
     * url = the url to redirect
     * $sec = secound Before redirect
    */

function HomeRedirect($errorMsg, $url = null, $sec = 3)
{

    if ($url === null) {

        $url =  "dashboard.php";
    } else {

        if ($_SERVER['HTTP_REFERER'] && $_SERVER['HTTP_REFERER'] !== " ") {

            $url = $_SERVER['HTTP_REFERER'];
        }
    }

    echo $errorMsg;
    echo "<div class='text-center'>You will be redirected to the <strong class='text-danger'>Home Page</strong> after $sec seconds.</div>";
    header("refresh:$sec;url=$url");
    exit;
}


/**
 * Returns the number of rows in a table.
 *
 * @param string $table The table to query.
 * @param string $item The column to count.
 * @return int The number of rows.
 */

function checkItem($select, $table, $value)
{

    global $con;
    $query = "SELECT $select FROM $table WHERE $select = ?";
    $statment = $con->prepare($query);
    $statment->execute(array($value));
    $count = $statment->rowCount();

    return $count;
}



/**
 * Returns the number of rows in a table.
 *
 * @param string $table The table to query.
 * @param string $item The column to count.
 * @return int The number of rows.
 */
function countItem($item, $table)
{

    global $con;

    $query = "SELECT COUNT($item) from $table ";

    $stmt2 = $con->prepare($query);

    $stmt2->execute();

    $count = $stmt2->fetchColumn();

    return $count;
}


/**
 * Returns the latest records from a table, filtered by groupId = 0.
 *
 * @param string $select The columns to select.
 * @param string $table The table to query.
 * @param string $order The column to order by.
 * @param int $limit The maximum number of records to return.
 * @return array The latest records.
 */

function getLatest( $select , $table , $where , $order , $limit = 5 )
{

    global $con;
    $query = "SELECT $select FROM $table $where ORDER BY $order DESC LIMIT $limit";
    $latestStmt = $con->prepare($query);
    $latestStmt->execute();
    $row = $latestStmt->fetchAll();
    return $row;
}



function runQuery($query ){
    $stmt = stmt($query) ;
    $row = $stmt->fetchAll();
    return $row;
}

function stmt($query){
    global $con;
    $stmt = $con->prepare($query);
    $stmt->execute();
    return $stmt;
}


/**
 * Returns the user state if active or not
 *
 * @param string $select The columns to select.
 * @param string $table The table to query.
 * @param string $order The column to order by.
 * @param int $limit The maximum number of records to return.
 * @return array The latest records.
 */

 function checkUserState($username){

    global $con ;

    $query = "SELECT username , regStatus 
    FROM users 
    WHERE username = '$username' 
    AND regStatus = 0 ";
    $userStmt = $con->prepare($query) ;
    $userStmt->execute() ;
    $count = $userStmt->rowCount() ;
    
    return $count ;

 }

 /*
    - Select All Data with Pagination 
    - Accept Paramater (Table)
    - $tabel -> table name from database
    - $itemNum -> number of item in one Page 
    -
 */
function paginationPages( $table , $itemNum  ){

    global $con ; 
    $perPage = $itemNum ; 

    // Retrieve total number of items
    $stmt = $con->prepare("SELECT COUNT(*) As totalItems FROM $table") ;
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalItems = $row['totalItems'] ;

    // Calculate total pages
    $totalPages = ceil($totalItems / $perPage) ; 

    return $totalPages ; 

}
function paginationData($table , $condition  , $order ,$itemNum , $currentPage){

        global $con ; 
        $perPage = $itemNum ; 

        // Determine current page
        $page = $currentPage ;

        // number of items i need skip 
        $startingLimit = ($page - 1) * $perPage ;
    
        // Retrieve items for current page
        $query = "SELECT * FROM $table $condition ORDER BY $order DESC LIMIT $startingLimit,$perPage " ;
        $stmt = $con->prepare($query);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data ;

}

