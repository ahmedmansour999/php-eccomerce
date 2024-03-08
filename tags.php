<?php 
    session_start() ;

    $pageTitle = "tags item";
    
    include "int.php" ;

?>


    <div class="container">
        <div class="container">
            <div  class="row ">
                <?php 

                if(isset($_GET['tags'])){

                    $tagName = $_GET['tags'] ; 
                    $condition = 'WHERE tags LIKE "%egypt%" AND approve = "1"';
                    $items = globalData( '*' , 'items' , $condition) ; 
                    print_r($items ) ;
                    ?>
                    
                    <h1 class="text-center mt-3 text-capitalize">#<?php  echo $tagName ; ?></h1>  
                    <?php if (!empty($items)) {
                        foreach($items as $item){ ?>

                            <div class="col-sm-6 col-md-4 col-lg-3 mb-3 mb-sm-0">
                                <div class="card items-container " >
                                    <div class="item-price"> <?php echo $item['Price'] ?>  </div>
                                    <img src="https://m.media-amazon.com/images/I/611mRs-imxL._AC_SX679_.jpg" class="card-img-top" alt="...">

                                    <div class="card-body">
                                        <a href="item.php?itemid=<?php echo $item['Item_id'] ?> " class="card-title">
                                            <?php echo $item['Name'] ?>
                                        </a>
                                        <p class="card-text">
                                            <?php echo $item['Description'] ?>
                                        </p>
                                        <a href="#" class="btn btn-primary">Go somewhere</a>
                                        <span class="date"> <?php echo $item['Date'] ?>  </span>

                                    </div>
                                    
                                </div>
                            </div>

                        <?php 
                    }
                    }
                }else{
                    echo "<div class='alert alert-danger mt-3 fw-bold'>Enter Correct Tag Name</div>" ;
                }
            ?>
        </div>
        </div>  
    </div>




<?php include $tpl .'footer.php' ; ?>
