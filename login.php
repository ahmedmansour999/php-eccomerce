<?php


session_start() ;
$pageTitle = "login" ;
include "./int.php"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $name = $_POST['username'] ;
    $password = $_POST['password'] ;

    $count = getCount("*" , "users" , "WHERE username = '$name'") ;

    if ($count > 0 ) {
        
        $_SESSION['user'] = $name ;
        header('location:index.php') ;
    }

}





?>



<div class=" auth-container row w-100">
    
    <h1 class="text-center login-header " >
        <span data-class="login " class="active" >Login</span> | <span data-class="signup" >signup</span>
    </h1>

    <form class="login col-sm-10 col-md-6" action="<?php $_SERVER['PHP_SELF']  ?>" method="post">

        <div class="input-container">
            <input type="text"  name="username" required placeholder="Enter User Name">
            <input type="password"  name="password" required placeholder="Password">
            <span class="flex-start">
                <input type="checkbox"  name="checkbox" id='checkbox'>
                <label for="checkbox">Remember Me</label>
            </span>
            <button class="btn btn-primary">log in</button>
        </div>

    </form>

    <form class="signup col-sm-10 col-md-6" action="<?php $_SERVER['PHP_SELF']  ?>" method="post">

        <div class="input-container">
            <label for="username">User Name</label>
            <input type="text"  name="username" id="username" placeholder="Enter User Name">
            <label for="email">Email</label>
            <input type="email"  name="Email " id="email" placeholder="Enter Validate Email">
            <label for="password">Password</label>
            <input type="password"  name="password"  id="password" placeholder="Password">
            <label for="password">Confirm Password</label>
            <input type="password"  name="Cpassword" id="password" placeholder="confirm Password">
            <button class="btn btn-success">Sign up</button>
        </div>

    </form>


</div>




<?php
include $tpl .'footer.php' ;
?>









