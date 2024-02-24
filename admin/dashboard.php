<?php


session_start();

if (isset($_SESSION['username'])) {

    $pageTitle = "dashboard";

    include "./int.php";

    $latestUserNum = 6 ;
    $latestUser = getLatest("*" , "users" ,  "WHERE groupId = '0'" , "user_id" , $latestUserNum ) ;


    $latestitemsNum = 6 ;
    $latestItems = getLatest( '*' , 'items'  , 'Item_id' , $latestitemsNum)
    


?>



    <!-- /* Start Dashboard Component mark here */ -->

    <div class="container home-stats">
        <h1 class="text-center">Dashboard</h1>

        <div class="row text-center">

            <div class="col-md-3">
                <div class="stat member-stat">
                <a href="members.php"><i class="fas fa-users"></i></a>
                    <div class="info">
                        total members
                        <span class="d-block ">
                            <a href="members.php?href=Manage">
                                <?php echo checkItem("groupId" , "users" , "0") ?>
                            </a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat pending-stat">
                <a href="members.php?href=Manage&page=pending"><i class="fas fa-user-plus"></i></a>
                    <div class="info">
                        pending members
                        <span class="d-block ">
                            <a href="members.php?href=Manage&page=pending">
                                <?php echo checkItem("regStatus" , "users" , 0) ?>
                            </a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat item-stat">
                <a href="items.php?"><i class="fas fa-tag"></i></a>
                    <div class="info">
                        total items
                        <span class="d-block ">
                            <a href="items.php?">
                                <?php echo countItem("name" , "items" ) ?>
                            </a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat comment-stat">
                    <a href="comments.php"> <i class="fas fa-comments"></i> </a>
                    <div class="info">
                        total Comments
                        <span class="d-block ">
                            <a href="items.php?">
                                <?php echo countItem("comment" , "comments" ) ?>
                            </a>
                        </span>
                    </div>
                    
                </div>
            </div>

        </div>

    </div>

    <!-- /* Start Latest Item And Users And Comments mark here */ -->
    <div class="container latest mt-4">

        <!-- Start latest User and Item -->
        <div class="row">
            <!-- latest Users -->
            <div class="col-sm-6">
                <div class="card card-default">
                    <div class="card-header  ">
                        <i class="fa fa-user"></i> Latest User
                        <span class="toggleSpan">
                            <i class="fas fa-plus toggle" ></i>
                        </span>
                    </div>
                    <div class="card-body">
                        <?php
                            echo '<ul class="latest-list" >' ;    
                                foreach ($latestUser as $user){
                                    echo "<li class='latest-item text-capitalize'>" ;
                                        echo $user ['username']    ;
                                        echo "<div>" ;
                                            echo '<a class="btn btn-warning pull-right" href="members.php?href=Edite&userid=' . $user["user_id"] . '" >' ;
                                                echo " <i class='fas fa-pen me-2'> " ;
                                            echo "</i>Edite</a>" ;
                                            if ($user['regStatus'] == 0){
                                            echo '<a href="members.php?href=active&userid=' . $user["user_id"] . '" class="btn btn-primary ms-2 "><i class="fas fa-check mx-1"></i>Active</a>' ;
                                            }
                                        echo "</div>" ;
                                    echo "</li>";
                                }
                            echo '<ul>' ;
                        ?>
                    </div>
                </div>
            </div>

            <!-- latest Item -->
            <div class="col-sm-6">
                <div class="card card-default">
                    <div class="card-header text-center ">
                        <i class="fa fa-tag"></i> Latest Item
                        <span class="toggleSpan">
                            <i class="fas fa-plus toggle" ></i>
                        </span>
                    </div>
                    <div class="card-body">
                    <?php
                            echo '<ul class="latest-list" >' ;    
                                foreach ($latestItems as $item){
                                    echo "<li class='latest-item text-capitalize'>" ;
                                        echo $item['Name']    ;
                                        echo "<div>" ;
                                            echo '<a class="btn btn-warning pull-right" href="members.php?href=Edite&itemid=' . $item["Item_id"] . '" >' ;
                                                echo " <i class='fas fa-pen me-2'> " ;
                                            echo "</i>Edite</a>" ;
                                            if ($item['approve'] == 0){
                                            echo '<a href="items.php?href=approve&itemid=' . $item["Item_id"] . '" class="btn btn-primary ms-2 "><i class="fas fa-check mx-1"></i>Approve</a>' ;
                                            }
                                        echo "</div>" ;
                                    echo "</li>";
                                }
                            echo '<ul>' ;
                        ?>
                    </div>
                </div>
            </div>

        </div>
         <!--End latest User and Item -->
        <!--start latest Comments -->
        <div class="row">
            <!-- latest Users -->
            <div class="col-sm-6">
                <div class="card card-default">
                    <div class="card-header  ">
                        <i class="fa fa-user"></i> Latest Comments
                        <span class="toggleSpan">
                            <i class="fas fa-plus toggle" ></i>
                        </span>
                    </div>
                    <div class="card-body">
                        <ul class="latest-comment" id="aa" >
                            <?php
                                $query = "SELECT comments.* , users.fullName AS member
                                        FROM 
                                            comments 
                                        INNER JOIN
                                            users
                                        ON
                                            comments.user_id = users.user_id
                                        ORDER BY 
                                            id DESc
                                " ;
                                $stmt = $con->prepare($query) ;
                                $stmt->execute() ;
                                $comments = $stmt->fetchAll() ;
                                if(! empty($comments)){ 
                                    
                                    foreach($comments  as $comment ){
                                    ?>

                                        <li class="list-comment text-capitalize"> 
                                            <span class="member-n" ><?php echo $comment['member'] ?></span>
                                            <p class="member-c" > <?php echo $comment['comment'] ?></p>
                                        </li>

                                <?php }}
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        <!--End latest Comments -->
    </div>
    <!-- /* End Latest Item And Users And Comments   */ -->
    <!-- /* End Dashboard Component */ -->

<?php
    include  $tpl . "Footer.php";
} else {

    header('location : index.php');
}





?>