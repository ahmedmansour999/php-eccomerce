<?php 


session_start();


if (isset($_SESSION["username"])) {
    

    $pageTitle = "items";

    include "int.php";
    $users = runQuery('SELECT username FROM users') ;
    

    $href = (isset($_GET["href"]) ? $_GET['href'] : "manager"  ) ; 

    if ($href == "manager") 
    { ?>
        <h1 class="text-center m-3"> Manage Items</h1>
        <div class="container">
    
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th >Description</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Country</th>
                            <th>Status</th>
                            <th>user</th>
                            <th>category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
    
                        $process = '';
                        if (isset($_GET['page']) && $_GET['page'] == "pending") {
                            $process ='AND regStatus = 0';
                        }
    
                        $query ='SELECT 
                                    items.* , categories.name AS category , users.username AS users 
                                FROM 
                                    items 
                                INNER JOIN 
                                    categories 
                                ON
                                    categories.ID = items.cat_id 
                                INNER JOIN 
                                    users 
                                ON 
                                    users.user_id = items.member_id '
                        ;
                        $stmt = $con->prepare($query);
                        $stmt->execute();
    
    
                        ?>
                        <?php while ($row = $stmt->fetch()) { ?>
                            <tr>
                                <td><?php echo $row['Item_id'] ?></td>
                                <td><?php echo $row['Name'] ?></td>
                                <td ><?php echo $row['Description'] ?></td>
                                <td><?php echo $row['Price'] ?></td>
                                <td><?php echo $row['Date'] ?></td>
                                <td><?php echo $row['Country_Made'] ?></td>
                                <td><?php echo $row['Status'] ?></td>
                                <td><?php echo $row['users'] ?></td>
                                <td><?php echo $row['category'] ?></td>
                                <td> 
                                        <a href="?href=Edite&itemid=<?php echo $row['Item_id'] ?>" class="btn btn-warning"><i class="fas fa-pen-fancy px-1 text-dark"></i>Edite</a>
                                        <a href="?href=delete&itemid=<?php echo $row['Item_id'] ?>" class="btn btn-danger confirm"><i class="fas fa-trash px-1"></i>Delete</a>
                                    <?php if ($row['approve'] == '0' ) { ?>
                                        <a href="?href=approve&itemid=<?php echo $row['Item_id'] ?>" class="btn btn-primary"><i class="fas fa-check px-1"></i>Approve</a>                                        
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php  } ?>
                    </tbody>
                </table>
            </div>
            <div class=" d-flex justify-content-end">
                <a class="btn btn-primary text-center " href="?href=add"> <i class="fas fa-plus"></i> Add Items</a>
            </div>
        </div>
    <?php }

    // Add Items mark here
    elseif($href == 'add')
    {?> 
        
        <div class="container items-container">
            <h1 class="text-center">Add Items</h1>
            <div class="items">
                <form action="?href=insert" method="post">
                    <div class="input-group">
                        <label for="name" class="input-group-text">Item Name</label>
                        <input type="text" id="name" name="name" placeholder="Item Name" class="m-0 px-1 " required>
                    </div>
                    <div class="input-group">
                        <label for="Description" class="input-group-text">Description</label>
                        <textarea class="m-0 px-1" name="Description" placeholder="Item Description" id="Description" required></textarea>
                    </div>
                    <div class="input-group">
                        <label for="Price" class="input-group-text">Price</label>
                        <input type="text" id="Price" name="Price" placeholder="Item Price" class="m-0 px-1 " required>
                    </div>
                    <div class="input-group">
                        <label for="country" class="input-group-text"> Country </label>
                        <input type="text" id="country" name="country" placeholder="Item country Made" class="m-0 px-1 " required>
                    </div>
                    <!-- Select Status Of Item -->
                    <div class="input-group">
                        <label for="status" class="input-group-text">Item status</label>
                        <select name="status" id="status" class="m-0 px-1"  >
                            <option value="0"> </option>
                            <option value="1">New</option>
                            <option value="2">Used</option>
                        </select>
                    </div>

                        <!-- Select User -->
                    <div class="input-group">
                        <label for="user" class="input-group-text">user</label>
                        <select name="user" id="user" class="m-0 px-1"  >
                            <option value="0"> </option>
                            <?php 
                                $users = runQuery('SELECT username , user_id FROM users') ;
                                foreach ($users as $user) {
                                    echo '<option value="'.$user['user_id'].'">'.$user['username'].'</option>';
                                }
                            ?>
                        </select>
                        <!-- Select Category -->
                    <div class="input-group">
                        <label for="category" class="input-group-text">Category</label>
                        <select name="category" id="category" class="m-0 px-1"  >
                            <option value="0"> </option>
                            <?php 
                                $cats = runQuery('SELECT name , ID FROM categories') ;
                                foreach ($cats as $cat) {
                                    echo '<option value="'.$cat['ID'].'">'.$cat['name'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="input-group justify-content-end">
                        <button class="btn btn-dark fw-bold" ><i class="fas fa-plus" ></i> Add </button>
                    </div>
                </form>
            </div>
        </div>



    <?php }

    // Insert Items into DB ; mark here
    elseif($href == 'insert')
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            echo "<h1 class='text-center'> Add Item  </h1>";
            echo "<div class='container text-center'> ";
    
            $name = $_POST["name"];
    
            $desc = $_POST["Description"];
    
            $price = $_POST["Price"];
    
            $country =  $_POST["country"];

            $status =  $_POST["status"];

            $user = $_POST["user"];

            $cat = $_POST["category"];
    
    
    
            // check Validation Of Data 
    
            $HandleError = [];
    
            if (empty($name)) 
            {
                $HandleError[] = ' name Cant Be <strong?> Empty </strong> ';
            }
            if (empty($desc)) 
            {
    
                $HandleError[] =  ' Description Cant Be <strong?> Empty </strong> ';
            }
            if (strlen($desc) < 5) 
            {
                $HandleError[] = ' Description Cant Be Less Than <strong?> 5 </strong> Characters ';
            }
            if (empty($price)) 
            {
    
                $HandleError[] = ' Price Cant Be <strong?> Empty </strong> ';
            }
            if (empty($country)) 
            {
    
                $HandleError[] = ' Country Made Cant Be <strong?> Empty </strong> ';
            }
            if (empty($status) || $status == '0') 
            {
    
                $HandleError[] = ' Status Cant Be <strong?> Empty </strong> ';
            }
            if (empty($user) || $user == '0') 
            {
    
                $HandleError[] = ' user Cant Be <strong?> Empty </strong> ';
            }
            if (empty($cat) || $cat == '0') 
            {
    
                $HandleError[] = ' cat Cant Be <strong?> Empty </strong> ';
            }
    
            foreach ($HandleError as $error) 
            {
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
    
    
    
            if (empty($HandleError)) {
    
                 

                $query = "INSERT INTO items 
                    (name , Description , Price , Status , Country_Made , Date  , member_id , cat_id )  
                        VALUES ( '$name' , '$desc' , '$price' , '$status' , '$country' , now() , '$user' , '$cat' )";
                $stmt = $con->prepare($query);
                $stmt->execute();


                echo  '
                    <div class="alert alert-primary"> Added Successfuly </div>
                    <a class="btn btn-primary text-center" href="items.php"> Done</a> 
                 ';
                
            }
            echo "</div>";
        } else {
            $errorMsg = '
                <div  class="container" >
                <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="alert-heading">Error</h4>
                <p>Something Went Wrong</p>
                </div> 
            ';
    
    
            HomeRedirect($errorMsg);
        }
    }

    // Edite Items 
    elseif($href == 'Edite')
    {    
        $item_id = (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) ? intval($_GET['itemid']) : 0;

        $query = "SELECT * FROM items WHERE Item_id = '$item_id' ";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {
     ?>
            <div class="container items-container">
                        <h1 class="text-center">Edite Items <span class="text-warning"><?php echo $row['Name'] ?></span> </h1>
                        <div class="items">
                            <form action="?href=update" method="post">
                                <div class="input-group">
                                    <label for="name" class="input-group-text">Item Name</label>
                                    <input type="text" id="name" name="name" placeholder="Item Name" class="m-0 px-1 " required value=" <?php echo $row['Name'] ?>" >
                                    <input type="hidden" name="id"  value=" <?php echo $row['Item_id'] ?>" >
                                </div>
                                <div class="input-group">
                                    <label for="Description" class="input-group-text">Description</label>
                                    <textarea class="m-0 px-1" name="Description" placeholder="Item Description" id="Description"  required><?php echo $row['Description'] ?></textarea>
                                </div>
                                <div class="input-group">
                                    <label for="Price" class="input-group-text">Price</label>
                                    <input type="text" id="Price" name="Price" placeholder="Item Price" class="m-0 px-1 " value=" <?php echo $row['Price'] ?>" required>
                                </div>
                                <div class="input-group">
                                    <label for="country" class="input-group-text"> Country </label>
                                    <input type="text" id="country" name="country" placeholder="Item country Made" class="m-0 px-1 " value=" <?php echo $row['Country_Made'] ?>" required>
                                </div>
                                <!-- Select Status Of Item -->
                                <div class="input-group">
                                    <label for="status" class="input-group-text">Item status</label>
                                    <select name="status" id="status" class="m-0 px-1"  >
                                        <option value="0"> </option>
                                        <option value="1" <?php if ($row['Status']== 1){echo 'selected' ;} ?> >New</option>
                                        <option value="2" <?php if ($row['Status']== 2){echo 'selected' ;} ?> >Used</option>
                                    </select>
                                </div>

                                    <!-- Select User -->
                                <div class="input-group">
                                    <label for="user" class="input-group-text">user</label>
                                    <select name="user" id="user" class="m-0 px-1">
                                        <option value="0"> </option>
                                        <?php 
                                            $users = runQuery('SELECT username , user_id FROM users') ;
                                            foreach ($users as $user) {
                                                echo '<option value="'.$user['user_id'].'" ';
                                                 if ($row['member_id']== $user['user_id']){echo 'selected' ;}  ; 
                                                echo ">".$user['username'].'</option>' ;
                                            }
                                        ?>
                                    </select>
                                    <!-- Select Category -->
                                <div class="input-group">
                                    <label for="category" class="input-group-text">Category</label>
                                    <select name="category" id="category" class="m-0 px-1"  >
                                        <option value="0"> </option>
                                        <?php 
                                            $cats = runQuery('SELECT name , ID FROM categories') ;
                                            foreach ($cats as $cat) {
                                                echo '<option value="'.$cat['ID'].'" ';
                                                if ($row['cat_id']== $cat['ID']){echo 'selected' ;}  ; 
                                                echo '>'.$cat['name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="input-group justify-content-end">
                                    <button class="btn btn-dark fw-bold" > update </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- show Comments In Item -->
                        <?php
                            $query = "SELECT comments.* , users.fullName 
                                        FROM 
                                            comments 
                                        INNER JOIN 
                                            users
                                        ON 
                                            comments.user_id = users.user_id 
                                        where item_id = '$item_id' ";

                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $comment = $stmt->fetch() ;

                            if(!empty($comment)){ 
                        ?>                           
                            <h1 class="text-center m-3"> Manage Comments</h1>
                            <div class="container">

                                <div class="table-responsive">
                                    <table class="table table-bordered text-center">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Comment</th>
                                                <th>Member Name</th>
                                                <th>Date</th>
                                                <th>control</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($comment = $stmt->fetch()) { ?>
                                                <tr>
                                                    <td><?php echo $comment['comment'] ?></td>
                                                    <td><?php echo $comment['fullName'] ?></td>
                                                    <td><?php echo $comment['date'] ?></td>
                                                    <td class="text-nowrap" >
                                                    <a href="?href=Edite&id=<?php echo $comment['id'] ?>" class="btn btn-warning"><i class="fas fa-pen-fancy px-1 text-dark"></i>Edite</a>
                                                    <a href="?href=delete&id=<?php echo $comment['id'] ?>" class="btn btn-danger confirm"><i class="fas fa-trash px-1"></i>delete</a>
                                                    <?php if ($comment['status'] == 0) { ?>
                                                            <a href="?href=accept&id=<?php echo $comment['id'] ?>" class="btn btn-primary "><i class="fas fa-check mx-1"></i>Accept</a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php  } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    <?php } ?>    
            </div>

            <?php } else{
                $errorMsg = '
                    <div  class="container" >
                    <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="alert-heading">Error</h4>
                    <p>Something Went Wrong</p>
                    </div> 
                ';
                HomeRedirect($errorMsg , 'items.php');
            } ?>
    <?php }

    // Update Items
    elseif($href == 'update')
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            echo "<h1 class='text-center'> Update Item  </h1>";
            echo "<div class='container text-center'> ";
            
            $id = $_POST["id"];

            $name = $_POST["name"];
    
            $desc = $_POST["Description"];
    
            $price = $_POST["Price"];
    
            $country =  $_POST["country"];

            $status =  $_POST["status"];

            $user = $_POST["user"];

            $cat = $_POST["category"];
    
    
    
            // check Validation Of Data 
    
            $HandleError = [];
    
            if (empty($name)) 
            {
                $HandleError[] = ' name Cant Be <strong?> Empty </strong> ';
            }
            if (empty($desc)) 
            {
    
                $HandleError[] =  ' Description Cant Be <strong?> Empty </strong> ';
            }
            if (strlen($desc) < 5) 
            {
                $HandleError[] = ' Description Cant Be Less Than <strong?> 5 </strong> Characters ';
            }
            if (empty($price)) 
            {
    
                $HandleError[] = ' Price Cant Be <strong?> Empty </strong> ';
            }
            if (empty($country)) 
            {
    
                $HandleError[] = ' Country Made Cant Be <strong?> Empty </strong> ';
            }
            if (empty($status) || $status == '0') 
            {
    
                $HandleError[] = ' Status Cant Be <strong?> Empty </strong> ';
            }
            if (empty($user) || $user == '0') 
            {
    
                $HandleError[] = ' user Cant Be <strong?> Empty </strong> ';
            }
            if (empty($cat) || $cat == '0') 
            {
    
                $HandleError[] = ' cat Cant Be <strong?> Empty </strong> ';
            }
    
            foreach ($HandleError as $error) 
            {
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
    
    
    
            if (empty($HandleError)) {
    
                 

                $query = "UPDATE items 
                SET Name = '$name' , Description = '$desc' , Price = '$price' , Country_made = '$country' , member_id = '$user' , cat_id = '$cat' , Status = '$status' where Item_id = '$id'" ;
                stmt($query) ;

                echo  '
                    <div class="alert alert-primary"> Updated Successfuly </div>
                    <a class="btn btn-primary text-center" href="items.php"> Done</a> 
                 ';
                
            }
            echo "</div>";
        } else {
            $errorMsg = '
                <div  class="container" >
                <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="alert-heading">Error</h4>
                <p>Something Went Wrong</p>
                </div> 
            ';
    
    
            HomeRedirect($errorMsg);
        }
    }

    // Delete Items
    elseif($href == 'delete')
    {
        echo "<h1 class='text-center'> Delete Item  </h1>";
        echo "<div class='container text-center'> ";
    
        $item_id = (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) ? intval($_GET['itemid']) : 0;
        $query = "DELETE FROM items WHERE Item_id = '$item_id' ";
        
        $stmt =  stmt($query) ;
        $count = $stmt->rowCount() ;
    
        if ($count > 0) {
    
            $theMsg = '<div class="alert alert-primary"> Deleted </div> ';
            HomeRedirect($theMsg , 'back');
        } else {
            $theMsg = '<div class="alert alert-danger"> ID not Exist </div>';
            HomeRedirect($theMsg , 'back');
        }
    }

    // approve item
    else if($href == 'approve'){
        echo "<h1 class='text-center'> approve Member  </h1>";
        echo "<div class='container text-center'> ";
    
        $item_id = (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) ? intval($_GET['itemid']) : 0;
        $query = "UPDATE items SET approve = '1' WHERE item_id = '$item_id' ";
        $stmt = stmt($query) ;
        $count = $stmt->rowCount();
        if ($count > 0) {
    
            $theMsg = '<div class="alert alert-primary"> approved </div> ';
            HomeRedirect($theMsg , 'back');
        } else {
            $theMsg = '<div class="alert alert-danger"> ID not Exist </div>';
            HomeRedirect($theMsg , 'back');
        }
    };

    include $tpl . "footer.php";

}



?>