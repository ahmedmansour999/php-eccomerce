<?php


    session_start() ;
    
    if (isset($_SESSION['user'])) {
        
        header('location:index.php') ;

        exit();
    }
    
    $noNavBar = " " ;
    $pageTitle = "login" ;
    include "./int.php"; 





    if ($_SERVER["REQUEST_METHOD"] == 'POST') {

        if (isset($_POST['login'])) {
                    
            $username = $_POST['user'];
            $password = $_POST['pass'];
            $hashPass = sha1($password);

            // Assuming $con is your database connection
            $query = "SELECT
                        username , password , user_id 
                        FROM users 
                        WHERE username = :username 
                        AND password = :password
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

                $_SESSION['user'] = $username;
                $_SESSION['ID'] = $row['user_id'];
                $_SESSION['password'] = $row['password'];
                header('location:index.php') ;
                exit() ;

            } else {
                echo "Authentication failed";
            }

        }else{

            $errors = [] ;

            if (isset($_POST['username'])) {
                
                $filterUser = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');

                if (strlen($filterUser) < 4 ) {
                    
                    $errors[] = ' Username Lenght must be larger than 4 char ' ;

                }

            }
            if (isset($_POST['password']) && isset($_POST['Cpassword'])  ) {

                if (empty($_POST['password'])) {

                    $errors[] =  'Password Required' ;

                }

                $pass = sha1($_POST['password']);
                $cpass = sha1($_POST['Cpassword']);
                
                if ($pass !== $cpass) {
                    
                    $errors[] = ' Password is not Matched ' ;

                }

                
            }
            if (isset($_POST['email'])  ) {

                $filterEmail = filter_var($_POST['email'] , FILTER_SANITIZE_EMAIL) ;

                if (filter_var($filterEmail) != true) {
                    
                    $errors[] = 'Not Valid Email' ;

                }

            }

        }   if (empty($errors)) {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

            
                    
                    $username = $_POST["username"];

                    $email = $_POST['email'] ;
                    
            
                    $password =  $_POST["password"];
            
                    $hashPass = sha1($_POST["password"]);
            

                        // Check if Usename is already registered 
            

                        $count = checkItem('username', 'users', $username);
                        
                        if ($count > 0) {

                            $errors[] =  'Username Already Exist' ;
                            
                        } else {
                            $query = "INSERT INTO users (email , username , password , fullName , regStatus )  VALUES ( '$email' , '$username' , '$hashPass' , '$username' , 0 )";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                        }
                    
                    echo "</div>";
                }
        }
    }



?>



    <div class=" auth-container row w-100">
        
        <h1 class="text-center login-header " >
            <span data-class="login " class="active" >Login</span> | <span data-class="signup" >signup</span>
        </h1>

        <form class="login col-sm-10 col-md-6"  action="<?php $_SERVER['PHP_SELF']  ?>" method="post">

            <div class="input-container">
                <input   type="text"  name="user" required placeholder="Enter User Name">
                <input   type="password"  name="pass" required placeholder="Password">
                <span class="flex-start">
                    <input type="checkbox"  name="checkbox" id='checkbox'>
                    <label for="checkbox">Remember Me</label>
                </span>
                <input name="login" type="submit" class="btn btn-primary" value="Login"/>
            </div>

        </form>

        <form class="signup col-sm-10 col-md-6" name="signup" action="<?php $_SERVER['PHP_SELF']  ?>" method="post">

            <div class="input-container">
                <label for="username">User Name</label>
                <input type="text"  name="username" id="username" required placeholder="Enter User Name" minlength="4" >
                <label for="email">Email</label>
                <input type="email"   id="email" required placeholder="Enter Validate Email" name="email">
                <label for="password">Password</label>
                <input type="password"  name="password"  id="password" required placeholder="Password" minlength="4">
                <label for="cpassword">Confirm Password</label>
                <input type="password"  name="Cpassword" id="cpassword" minlength="4" required placeholder="confirm Password">
                <input name="signup" type="submit" class="btn btn-success" value="Signup"/>

            </div>

        </form>
        <div class="the-errors text-center my-1"  >

            <?php 
                if (!empty($errors)) {
                    
                    foreach($errors as $err)

                    echo $err ;

                }
            ?>

        </div>


    </div>




<?php
include $tpl .'footer.php' ;
?>









