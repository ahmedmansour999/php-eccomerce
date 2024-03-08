<?php


    ob_start() ;
    session_start() ;

    $pageTitle = "items" ;


    include "./int.php"; 


        $item_id = (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) ? intval($_GET['itemid']) : 0;

        // $query = "SELECT * FROM items WHERE Item_id = '$item_id' ";
        // $stmt = $con->prepare($query);



        $stmt = $con->prepare("SELECT items.* , categories.name as catName , users.username , categories.ID as catId

                                FROM
                                    items 
                                
                                INNER JOIN
                                    users
                                ON 
                                    users.user_id = items.member_id
                                INNER JOIN 
                                    categories 
                                ON
                                    categories.ID = items.cat_id
                                WHERE 
                                    Item_id = '$item_id'
                                AND 
                                    approve = '1'    
                            ") ;

        $stmt->execute();
        $item = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {
            
        
    ?>


    <h1 class="text-center mt-3 text-capitalize" > <?php echo $item['Name'] ?> </h1>


    <!-- Item Details Container -->
    <div class="container mt-5">

        <div class="item-details row">
            <div class="col-md-3 ">
                <img src="https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                width="100%"

                alt="">
            </div>
            <div class="itemdetails-list col-md-9">
                <h2> <?php echo $item['Name'] ?> </h2>
                <P class="fw-bold" > <?php echo $item['Description'] ?> </P>
                <ul>
                    <li class="text-nowrap"> <span > <i class="fas fa-calendar fa-fw"></i>  Date  </span> : <?php echo $item['Date'] ?> </li>
                    <li class="text-nowrap"> <span >  <i class="fas fa-store fa-fw"></i> Country Made  </span>  : <?php echo $item['Country_Made'] ?> </li>
                    <li class="text-nowrap"> <span > <i class="fas fa-credit-card"></i> Price  </span> : <?php echo $item['Price'] ?>  </li>
                    <li class="text-nowrap"> <span > <i class="fas fa-tag"></i> Category   </span> :  <a href="categories.php?pageid=<?php echo  $item['catId'] ?>"><?php echo $item['catName'] ?></a> </li>
                    <li class="text-nowrap"> <span > <i class="fas fa-user"></i> User Name  </span> : <?php echo $item['username'] ?>  </li>
                    <li class="text-nowrap"> <span > <i class="fas fa-user"></i> Tags </span> : 
                        <?php 
                            $itemTags = explode("," , $item['tags']) ;
                            $tags = str_replace(" " , "" , $itemTags) ;
                            if (!empty($item['tags'])) {  
                            
                                foreach($tags as $tag){ ?>

                                    <a href="tags.php?tags=<?php echo $tag ; ?>"> <?php echo $tag ?> </a> | 
                                    
                            <?php    }  ?>

                        <?php }else{
                            echo "No Item Tag" ; 
                        }  ?>
                </ul>
            </div>
        
        </div>

        <hr class="custom-hr">
        <!-- Add New Comment -->
        <?php if (isset($_SESSION['user'])) { ?>
            
            <div class="row">
            <div class="col-md-9 offset-md-3">
                <div class="add-comment ">
                    <h3>
                        Add Comment
                    </h3>
                    <form action=" <?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_id']  ?> " method="POST" >
                        <textarea name="comment" id="comment"   class="w-100" rows="5" ></textarea>
                        <input type="submit" class="btn btn-primary " value="Comment" />
                    </form>
                    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {

                        $comment = $_POST['comment'] ; 
                        $item_id = $item['Item_id'] ;
                        $user_id = $item['member_id'] ; 
                        $time = date('H:i:s' , time()) ;

                        if (! empty($comment)) {
                                                    
                        $CommentStmt = $con->prepare("INSERT INTO 
                                                        comments(comment , status , date , time , item_id , user_id)
                                                        VALUES( '$comment' , '0' , NOW() , '$time'  ,'$item_id' , '$user_id' )
                        ") ;

                        $CommentStmt->execute() ;
                        }

                        if ($CommentStmt ) {
                            
                            echo "<div class='alert alert-success mt-3 text-dark fw-bold text-center p-1' > Comment Sucess </div> " ;
                        }else{

                            echo "<div class='alert alert-danger mt-3 text-dark fw-bold text-center p-1' > Comment Failed </div> " ;

                        }

                    } ?>
                </div>
            </div>
        </div>

        <?php    }else{

            echo "<a href='login.php' class='text-danger' > login </a> | <a href='login.php' class='text-danger' > register </a> to Comment" ;

        }  ?> 
 
        <hr>
        <!-- SHOW Comments Of Items -->
        <?php
            $Commentitem = $item['Item_id'] ;
            $query = "SELECT comments.* , users.fullName , items.Name As itemName
            FROM 
                comments 
            INNER JOIN 
                USERS
            ON 
                comments.user_id = users.user_id 
            INNER JOIN 
                items
            ON
                comments.item_id = items.item_id   ";
            $query = "SELECT comments.* , users.fullName AS member
                    FROM 
                        comments 
                    INNER JOIN
                        users
                    ON
                        comments.user_id = users.user_id
                    WHERE
                        comments.item_id = '$Commentitem'
                    AND 
                        status = '1'
                    ORDER BY 
                        id DESC
            " ;
            $stmt = $con->prepare($query) ;
            $stmt->execute() ;
            $comments = $stmt->fetchAll() ;
            echo "<h2 class='bg-primary p-3 text-white' > Latest Comments </h2>" ;
            if(! empty($comments)){ 
                
                foreach($comments  as $comment ){
                ?>        
                    <div class="comments row mt-5">

                        <div class="col-md-3 img-container ">
                            <img  src="https://cdn.pixabay.com/photo/2016/04/15/18/05/computer-1331579_640.png" class="member-img rounded-circle d-blcok m-aouto" alt="">
                            <span class="text-capitalize fw-bold" >
                                <?php echo $comment['member']  ?>
                            </span>
                        </div>
                        <div class="comment-text col-md-9">
                           <span> <?php echo $comment['comment'] ?></span>
                           <div class="comment-time float-end" >
                               <span class="" > <?php echo $comment['time'] ?> </span>
                               <br>
                               <span class="" > <?php echo $comment['date'] ?> </span>
                           </div>
                           
                        </div>
                    </div>

            <?php }} ?>


    </div>


<?php }else{ ?>


            <div class="bg-danger text-center p-2 fw-bold">there's No Item or Not Approved yet </div>

    <?php } 

include $tpl .'footer.php' ;

?>







<?php
    include $tpl .'footer.php' ;
    ob_end_flush()
?>









