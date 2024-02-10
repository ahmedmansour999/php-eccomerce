<?php


session_start();

if (isset($_SESSION['username'])) {

    $pageTitle = "dashboard";

    include "./int.php";

    $latestUserNum = 5 ;
    $latestUser = getLatest("*" , "users" , "user_id" , $latestUserNum ) ;
    


?>



    <!-- /* Start Dashboard Component mark here */ -->

    <div class="container home-stats">
        <h1 class="text-center">Dashboard</h1>

        <div class="row text-center">

            <div class="col-md-3">
                <div class="stat member-stat">
                    total members
                    <span class="d-block "><a href="members.php?href=Manage"><?php echo checkItem("groupId" , "users" , "0") ?></a></span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat pending-stat">
                    pending members
                    <span class="d-block "><a href="members.php?href=Manage&page=pending"><?php echo checkItem("regStatus" , "users" , 0) ?></a></span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat item-stat">
                    total items
                    <span class="d-block ">1500</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat comment-stat">
                    total Comments
                    <span class="d-block ">5503</span>
                </div>
            </div>

        </div>

    </div>

    <div class="container latest mt-4">

        <div class="row">

            <div class="col-sm-6">
                <div class="card card-default">
                    <div class="card-header text-center ">
                        <i class="fa fa-user"></i> Latest User
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
                    </div>
                    <div class="card-body">
                        tets
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