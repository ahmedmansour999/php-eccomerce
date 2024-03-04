<?php


ob_start();
session_start();

$pageTitle = "Add Ads";


include "./int.php";

if (isset($_SESSION['user'])) {

    $stmt = $con->prepare("SELECT * from users WHERE username = '$sessionUser' ");
    $stmt->execute();
    $info = $stmt->fetch();

    $errors = [] ;

    if ($_POST['name'] ) {
        # code...
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
                                    <input type="text" id="name" name="name" data-class=".preview-title" placeholder="Item Name" class="m-0 px-1 col-10 live" required>
                                </div>
                                <div class="input-group row">
                                    <label for="Description" class="input-group-text col-2">Description</label>
                                    <textarea class="m-0 px-1 col-10 live " data-class=".preview-description"  rows="3" name="Description" placeholder="Item Description " id="Description" required></textarea>
                                </div>
                                <div class="input-group row">
                                    <label for="Price" class="input-group-text col-2 " >Price</label>
                                    <input type="number" id="Price" name="Price" data-class=".preview-price" placeholder="Item Price" class="m-0 px-1 col-10 live " required>
                                </div>
                                <div class="input-group row">
                                    <label for="country" class="input-group-text col-2"> Country </label>
                                    <input type="text" id="country" name="country" placeholder="Item country Made" class="m-0 px-1 col-10  " required>
                                </div>
                                <!-- Select Status Of Item -->
                                <div class="input-group row">
                                    <label for="status" class="input-group-text col-2">Item status</label>
                                    <select name="status" id="status" class="m-0 px-1 col-10 " >
                                        <option value="0"> </option>
                                        <option value="1">New</option>
                                        <option value="2">Used</option>
                                    </select>
                                </div>

                                <!-- Select User -->
                                <div class="input-group">
                                    <!-- Select Category -->
                                    <div class="input-group row">
                                        <label for="category" class="input-group-text col-2">Category</label>
                                        <select name="category" id="category" class="m-0 px-1 col-10 " >
                                            <option value="0"> </option>
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