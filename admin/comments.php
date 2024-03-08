
<?php 


session_start() ; 

if (isset($_SESSION['username'])) {

    $pageTitle = "Comments" ;

    include "./int.php";
    

    $href = (isset($_GET['href'])) ? $_GET['href'] : 'Manage';


    if ($href == 'Manage') { ?>

        <!-- Page Manager  -->

        <h1 class="text-center m-3"> Manage Comments</h1>
        <div class="container">

            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#ID</th>
                            <th>Comment</th>
                            <th>Item Name</th>
                            <th>Member Name</th>
                            <th>Date</th>
                            <th>control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php



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
                        $stmt = $con->prepare($query);
                        $stmt->execute();


                        ?>
                        <?php while ($row = $stmt->fetch()) { ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['comment'] ?></td>
                                <td><?php echo $row['itemName'] ?></td>
                                <td><?php echo $row['fullName'] ?></td>
                                <td><?php echo $row['date'] ?></td>
                                <td class="text-nowrap" >
                                <a href="?href=Edite&id=<?php echo $row['id'] ?>" class="btn btn-warning"><i class="fas fa-pen-fancy px-1 text-dark"></i>Edite</a>
                                <a href="?href=delete&id=<?php echo $row['id'] ?>" class="btn btn-danger confirm"><i class="fas fa-trash px-1"></i>delete</a>
                                 <?php if ($row['status'] == 0) { ?>
                                        <a href="?href=active&id=<?php echo $row['id'] ?>" class="btn btn-primary "><i class="fas fa-check mx-1"></i>Accept</a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php  } ?>
                    </tbody>
                </table>
            </div>
        </div>


        <?php

    }
    elseif ($href == "Edite") {

        $comId = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $query = "SELECT * FROM comments WHERE id = '$comId' LIMIT 1";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {
        ?>

            <div class="details ">
                <h1 class="text-center">Edite Comment</h1>
                <div class="container fw-bold  text-center  ">
                    <form class="form-horizontal form-dark  mt-5" action="?href=Update" method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                        <div class="input-group ">
                                    <label for="comment" class="input-group-text bg-dark text-light fw-bold">Comment</label>
                                    <textarea class="m-0 px-1 form-control" name="comment" placeholder=" comment" id="comment"  required><?php echo $row['comment'] ?></textarea>
                        </div>
                        <div class="form-group form-group-lg mt-2 float-end">
                            <div class=" col-sm-10 btn-lg ">
                                <input type="submit" value="Save" class="btn btn-primary btn-lg ">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        <?PHP

        } else {
            header('location:index.php');
        }
    }
    elseif ($href == "Update") {


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo "<h1 class='text-center'> Update Member  </h1>";
            echo "<div class='container text-center'> ";
            $id = $_POST["id"];
            $comment = $_POST["comment"];



            $HandleError = [];



            if (empty($comment)) {
                $HandleError[] = ' comment Cant Be <strong?> Empty </strong> ';
            }
            if (strlen($comment) < 3) {
                $HandleError[] = ' commen$comment Cant Be Less Than <strong?> 3 </strong> Characters ';
            }


            foreach ($HandleError as $error) {
                $theMsg = '<div class="alert alert-danger">' . $error . '</div>';
            }

            if (empty($HandleError)) {


                 
                    $query = "UPDATE comments SET comment = '$comment' WHERE id = '$id'";
                    $stmt = $con->prepare($query);
                    $stmt->execute();


                    $theMsg = '<div class="alert alert-primary"> Updated </div> ';
                    HomeRedirect($theMsg , "comments.php");
                
            }
        } else {
            $theMsg = '<div class="alert alert-danger"> No Denied To Update Members</div> ';
            HomeRedirect($theMsg , 'comments.php');
        }
    }
    elseif ($href == "delete") {

        echo "<h1 class='text-center'> Delete Member  </h1>";
        echo "<div class='container text-center'> ";

        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;
        $query = "DELETE FROM comments WHERE id = '$id' ";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $count = $stmt->rowCount();

        if ($count > 0) {

            $theMsg = '<div class="alert alert-primary"> Deleted </div> ';
            HomeRedirect($theMsg , 'comment.php');
        } else {
            $theMsg = '<div class="alert alert-danger"> ID not Exist </div>';
            HomeRedirect($theMsg);
        }
    }
    elseif ($href == "active") {
        echo "<h1 class='text-center'> Accept Comment  </h1>";
        echo "<div class='container text-center'> ";

        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;
        echo $id ;
        $query = "UPDATE comments SET status = '1' WHERE id = '$id'";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $count = $stmt->rowCount();


        
        if ($count > 0) {

            $theMsg = '<div class="alert alert-primary"> Accepted </div> ';
            HomeRedirect($theMsg , 'comment.php');

        } else {
            $theMsg = '<div class="alert alert-danger"> ID not Exist </div>';
            HomeRedirect($theMsg , 'comment.php');
        }
    }


 

    include  $tpl . "Footer.php"  ;

}else {

    header('location : index.php') ;
    exit() ; 

}





?>