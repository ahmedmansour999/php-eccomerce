<?php



    session_start() ;


    $pageTitle = "Home" ;

    include "./int.php"; 


    // Get All Items With Pagination

    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
    $perPage = 8 ;
    
    $totalPages = paginationPages('items' , $perPage) ;
    $condition = 'where approve = "1" ' ;

    $items = paginationData('items' ,$condition ,'Item_id' , $perPage , $currentPage ) ;

?>


<div class="container">

        <!-- pagination of Items -->
        <div class="pagintaion-header">
            <h1 class="text-center mt-3 text-capitalize"> Items </h1>
                <nav aria-label="float-end">
                    <ul class="pagination m-0">

                    <?php if ($currentPage > 1 ) { ?>

                                    <li class="page-item"> 
                                        <a href='?page=<?php echo ($currentPage - 1); ?>' class='links btn btn-primary '>Previous</a> 
                                    </li> 
                            <?php }else { ?>
                                    <li class="page-item disabled">
                                                <a class="page-link">Previous</a>
                                    </li>
                            <?php } ?>
                            

                <?php  for ($pagenum = 1  ;$pagenum <=  $totalPages ; $pagenum++) : ?> 
                    <li class="page-item">
                        <a href='<?php echo "?page=$pagenum"; ?>' class='links btn page-link <?php echo ($pagenum == $currentPage) ? 'active' : '' ?> '> <?php echo $pagenum; ?> </a>
                    </li>
                <?php  endfor;  ?>

                            <?php if ($currentPage < $totalPages ) { ?>
                                <li class="page-item">
                                    <a href='?page=<?php echo ($currentPage + 1); ?>' class='links btn btn-primary '>Next</a>
                                </li>
                            <?php }else{ ?>
                                        <li class="page-item disabled">
                                                <a class="page-link">Next</a>
                                     </li>
                            <?php } ?>
                            

                    </ul>
                </nav>
             
        </div> 

        <div class="container items-container">
            <!-- Show All Items -->
            <div  class="row ">
                
            <?php 
                if (!empty($items)) {
                    foreach($items as $item){?>
                    

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

                    <?php }
                }else{

                    echo '<div class="alert  text-dark alert-danger text-center fw-bold" > No Item in this page </div>  ' ;
                    echo ' <a href="newad.php" class="btn bg-primary btn-primary w-auto float-end "> Add Item </a>' ;
                }

            ?>
        </div>
        </div>  
    </div>







   <?php include $tpl .'footer.php' ; ?>









