<?php


session_start();

if (isset($_SESSION['username'])) {

    $pageTitle = "dashboard";

    include "./int.php";

    $latestUserNum = 6 ;
    $latestUser = getLatest("*" , "users" , "user_id" , $latestUserNum ) ;


    $latestitemsNum = 6 ;
    $latestItems = getLatest( '*' , 'items' , 'Item_id' , $latestitemsNum)
    


?>



    <!-- /* Start Dashboard Component mark here */ -->

    <div class="container home-stats">
        <h1 class="text-center">Dashboard</h1>

        <div class="row text-center">

            <div class="col-md-3">
                <div class="stat member-stat">
                    <i class="fas fa-users"></i>
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
                    <i class="fas fa-user-plus"></i>
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
                    <i class="fas fa-tag"></i>
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
                    <i class="fas fa-comments"></i>
                    <div class="info">
                        total Comments
                    <span class="d-block ">0</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="container latest mt-4">

        <div class="row">

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
    </div>
    <!-- /* End Dashboard Component */ -->

<?php
    include  $tpl . "Footer.php";
} else {

    header('location : index.php');
}





?>