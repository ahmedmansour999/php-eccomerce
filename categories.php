<?php 
    session_start() ;

    $pageTitle = "category";
    
    include "int.php" ;

?>


    <div class="container">
        <h1 class="text-center mt-3 text-capitalize"><?php  echo str_replace("_" , " " ,  $_GET['pagename'] ) ; ?></h1>  
        <div class="container">
            <div  class="row ">
            <?php 
                $items = getItems( 'cat_id' , $_GET['pageid']) ;
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
                }

            ?>
        </div>
        </div>  
    </div>




<?php include $tpl .'footer.php' ; ?>
