<?php


ob_start();
session_start();

$pageTitle = "Add Ads";


include "./int.php";

if (isset($_SESSION['user'])) {

    $stmt = $con->prepare("SELECT * from users WHERE username = '$sessionUser' ");
    $stmt->execute();
    $info = $stmt->fetch();



    if ($_SERVER['REQUEST_METHOD']=="POST" ) {
        
        $errors = [] ;

        $name      =  htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') ;
        $price     =  filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT) ;
        $desc      =  htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8') ;
        $country   =  htmlspecialchars($_POST['country'], ENT_QUOTES, 'UTF-8') ;
        $category  =  htmlspecialchars($_POST['category'], ENT_QUOTES, 'UTF-8') ;
        $status    = $_POST['status'] ;
        $user = $_SESSION["ID"] ;

        if (strlen($name) < 3 ) {
            
            $errors[] = 'Item title Must be at least 4 characters' ;
            
        }
        if (strlen($desc) < 10 ) {
            
            $errors[] = 'Item Description Must be at least 10 characters' ;

        }
        if (strlen($country) < 3 ) {
            
            $errors[] = 'Item Country Must be at least 4 characters' ;

        }
        if (strlen($category) < 1 ) {
            
            $errors[] = ' Category Must be Not Empty' ;

        }
        if (strlen($price) < 1 ) {
            
            $errors[] = 'Item Price Must be Not Empty' ;

        }
        if (strlen($status) < 1 ) {
            
            $errors[] = 'Item Status Must be Not Empty ' ;

        }
        if (empty($errors)) {
    

            $query = "INSERT INTO items 
                (name , Description , Price , Status , Country_Made , Date  , member_id , cat_id )  
                    VALUES ( '$name' , '$desc' , '$price' , '$status' , '$country' , now() , '$user' , '$category' )";
            $stmt = $con->prepare($query);
            
            $stmt->execute();


            echo  '
                <div class="alert alert-primary"> Added Successfuly </div>
             ';
            
        }
        
    }

?>


    <h1 class="text-center mt-3 text-capitalize">create new ad</h1>


    <div class="ads  mt-3">

        <div class="container ">

            <div class="card">
                <div class="card-header bg-primary fw-bold text-light text-capitalize">create new ad</div>


                <div class="card-body ">

                    <div class="row">
                        <!-- Form To add Ads -->
                        <div class="ad-form col-lg-9">
                            <form action="?href=insert" method="post">
                                <div class="input-group row">
                                    <label for="name" class="input-group-text col-2">Item Name</label>
                                    <input type="text" id="name" name="name" data-class=".preview-title" placeholder="Item Name" 
                                    class="m-0 px-1 col-10 live" pattern=".{3,}" title='Item title Must be at least 4 characters' required>
                                </div>
                                <div class="input-group row">
                                    <label for="Description" class="input-group-text col-2">Description</label>
                                    <textarea class="m-0 px-1 col-10 live " data-class=".preview-description" 
                                         rows="3" name="description" placeholder="Item Description "
                                          id="Description" pattern=".{3,}" title='Item title Must be at least 4 characters' required>
                                    </textarea>
                                </div>
                                <div class="input-group row">
                                    <label for="Price" class="input-group-text col-2 " >Price</label>
                                    <input type="number" id="Price" name="price" data-class=".preview-price" placeholder="Item Price" class="m-0 px-1 col-10 live " required>
                                </div>
                                <div class="input-group row">
                                    <label for="country" class="input-group-text col-2"> Country </label>
                                    <input type="text" id="country" name="country" placeholder="Item country Made" class="m-0 px-1 col-10  " required>
                                </div>
                                <!-- Select Status Of Item -->
                                <div class="input-group row">
                                    <label for="status" class="input-group-text col-2">Item status</label>
                                    <select name="status" id="status" class="m-0 px-1 col-10 " require >
                                        <option value=""> </option>
                                        <option value="1">New</option>
                                        <option value="2">Used</option>
                                    </select>
                                </div>

                                <!-- Select User -->
                                <div class="input-group">
                                    <!-- Select Category -->
                                    <div class="input-group row">
                                        <label for="category" class="input-group-text col-2">Category</label>
                                        <select name="category" id="category" class="m-0 px-1 col-10 " require >
                                            <option value=""> </option>
                                            <?php
                                            $cats = runQuery('SELECT name , ID FROM categories');
                                            foreach ($cats as $cat) {
                                                echo '<option value="' . $cat['ID'] . '">' . $cat['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="input-group justify-content-end mt-2">
                                        <button class="btn btn-primary fw-bold"><i class="fas fa-plus"></i> Add </button>
                                    </div>
                                </div> 
                            </form>
                        </div>


                        <!-- Form To show Data  -->
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-3 mb-sm-0">
                            <div class="card items-container  live-preview">
                                <div class="item-price "> $
                                    <span class="preview-price" > price</span>
                                </div>
                                <img src="https://m.media-amazon.com/images/I/611mRs-imxL._AC_SX679_.jpg" class="card-img-top" alt="...">

                                <div class="card-body">
                                    <h5 class="card-title preview-title">
                                        title
                                    </h5>
                                    <p class="card-text preview-description">
                                        Description
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>


        <div class="error">
            
            <?php 
                if (!empty($errors)) {
                    foreach($errors as $error){ ?>
    
                        <div class="text-center text-danger m-2">
                            <?php echo $error ?>
                        </div>
            
            <?php } }?>

        </div>

    </div>



<?php } else {

    header('location:login.php');
}

include $tpl . 'footer.php';

?>







<?php
include $tpl . 'footer.php';
ob_end_flush()
?>