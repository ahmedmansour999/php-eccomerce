<?php

session_start() ; 
$noNavBar = " " ;
$pageTitle = "login" ;

if (isset($_SESSION['username'])) {

    header('locaion:dashboard.php') ;
    
}

include "./int.php"; 




if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashPass = sha1($password);

    // Assuming $con is your database connection
    $query = "SELECT
                username , password , user_id 
                FROM users 
                WHERE username = :username 
                AND password = :password
                AND groupId = '1'
                ";
    $stmt = $con->prepare($query);

    // Bind parameters
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashPass);
    

    // Execute the query
    $stmt->execute();
    $row =  $stmt->fetch();

    // Get the number of rows returned
    $count = $stmt->rowCount();

    // Check if a user with the provided credentials exists
    if ($count > 0) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['ID'] = $row['user_id'];
        $_SESSION['password'] = $row['password'];
        header('location:dashboard.php') ;
        exit() ;
    } else {
        echo "Authentication failed";
    }
}

?>



<div class="container d-flex align-items-center">
        
    <form class="form-control"  action="<?php echo $_SERVER['PHP_SELF'] ?> " method="POST" >

        <h1 class="text-center m-5">Login</h1>
    
        <input class="form-control " type="text" name="user" placeholder="User Name"    autocomplete="off"  >
        <input class="form-control" type="password" name="pass" placeholder="password" autocomplete="off" > 
        <input class="btn btn-primary w-100" type="submit" value="Login">

    </form>
</div>






