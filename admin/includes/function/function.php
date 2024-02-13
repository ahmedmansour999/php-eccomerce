<?php

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

function HomeRedirect($errorMsg, $url = null, $sec = 5)
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

function getLatest($select, $table, $order, $limit = 5)
{

    global $con;
    $query = "SELECT $select FROM $table WHERE groupId = '0' ORDER BY $order DESC LIMIT $limit";
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
