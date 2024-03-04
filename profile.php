<?php


    ob_start() ;
    session_start() ;

    $pageTitle = "profile" ;


    include "./int.php"; 

    if (isset($_SESSION['user'])) {
        
    $stmt = $con->prepare("SELECT * from users WHERE username = '$sessionUser' ") ;
    $stmt->execute() ;
    $info = $stmt->fetch() ;

    ?>


    <h1 class="text-center mt-3 text-capitalize" >Profile <?php echo $sessionUser ?> </h1>

    <div class="information  mt-3">

        <div class="container ">
                
            <div class="card">
                <div class="card-header bg-primary fw-bold text-light text-capitalize">my information</div>
                <div class="card-body">
                    <ul >
                        <li >
                                <i class="fas fa-unlock fa-fw"></i>
                                <span >  login Name </span> :  
                                <?php echo   $info['username'] ?>   
                        
                        </li>
                        
                        <li>
                                <i class="fas fa-envelope fa-fw"></i>
                                <span> email </span> :  
                                <?php echo   $info['email'] ?>   
                        
                        </li>
                        
                        <li>
                                <i class="fas fa-user fa-fw"></i>
                                <span> fullname </span> : 
                                <?php echo   $info['fullName'] ?>  
                        
                        </li>
                        
                        <li>
                                <i class="fas fa-calendar"></i>
                                <span class="text-nowrap" > Register Date </span> :  
                                <?php echo   $info['date'] ?>  

                    
                        </li>
                    </ul
                    >
                </div>

            </div>

        </div>

    </div>
    <div class="ads  mt-3">

        <div class="container ">
                
            <div class="card">
                <div class="card-header bg-primary fw-bold text-light text-capitalize d-flex justify-content-between">
                    <span>my Ads</span>
                    <span class="icon"> <a href="newad.php"><i class="fas fa-plus"></i></a> </span>
                </div>
                
                <div class="card-body row">
                <?php 
                $items = getItems( 'member_id' , $info['user_id']) ;
                if (!empty($items)) {
                    foreach($items as $item){?>
                    

                        <div class="col-sm-6 col-md-4 col-lg-3 mb-3 mb-sm-0">
                            <div class="card items-container " >
                                <div class="item-price"> <?php echo $item['Price'] ?>  </div>
                                <img src="https://m.media-amazon.com/images/I/611mRs-imxL._AC_SX679_.jpg" class="card-img-top" alt="...">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?php echo $item['Name'] ?>
                                     </h5>
                                    <p class="card-text">
                                        <?php echo $item['Description'] ?>
                                    </p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                                
                            </div>
                        </div>

                    <?php }
                }else{

                    echo " <p class='text-center fw-bold' >  no Items yet </p> " ;

                }
            ?>
                </div>
            </div>

        </div>

    </div>
    <div class="comments  mt-3">

        <div class="container ">
                
            <div class="card">
                <div class="card-header bg-primary fw-bold text-light text-capitalize">latest comments</div>
                <?php 
                        $stmt = $con->prepare("SELECT comments.*, item_id, user_id 
                                        FROM 
                                            comments 
                                        WHERE 
                                            user_id = :user_id
                                       ");

                        

                        $stmt->bindParam(':user_id', $info["user_id"]);

                        $stmt->execute();

                        $comments = $stmt->fetchAll() ;

                        // print_r($comments) ;
                    echo '<div class="card-body">' ;

                    if (isset($comments)) {
                    
                    

                        foreach($comments as $comment){
            
                             echo  "<p > -" . $comment['comment'] .  "</p>" ;
                          
                        }
                    
                    }else {

                        echo " <p class='text-center fw-bold' >  no Items yet </p> " ;

                    } 
                    echo  '</div>' ;
                    ?>
            </div>

        </div>

    </div>
    <div class="information  my-3">

        <div class="container ">
                
            <div class="card">
                <div class="card-header bg-primary fw-bold text-light text-capitalize">my information</div>
                <div class="card-body">
                    My Name Is Ahmed
                </div>
            </div>

        </div>

    </div>


<?php } else{

    header('location:index.php') ;

}

include $tpl .'footer.php' ;

?>







<?php
    include $tpl .'footer.php' ;
    ob_end_flush()
?>









