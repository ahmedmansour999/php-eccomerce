<?php

session_start();


if (isset($_SESSION["username"])) {

    $pageTitle = "category";

    include "int.php";

    $sort = (isset($_GET['sort']))? $_GET['sort'] : "ASC";

    $allCatergories = runQuery("SELECT * FROM categories ORDER BY ordering " . $sort ) ;






    $href = (isset($_GET['href'])) ? $_GET['href'] : "Manager";

    if ($href == "Manager") { ?>

            <div class="container ">
                        
                <h1 class="text-center text-dark">Category </h1>
                <div class="cat-container ">
                    <div class="options ">
                        <div class="sorting">
                            Ordering :  <a href="?sort=ASC" >Asc </a> | <a href="?sort=DESC" >Desc </a> 
                        </div>
                    </div>
                     <?php foreach ($allCatergories as $category) { ?>
                
                    <div class="cat position-relative">
                        <div class="head">
                            <h3 class="text-center "><?php echo $category['name'] ?></h3>
                        </div>
                        <div class="body " id="<?php echo $category['ID'] ?>">
                            
                                <p><?php echo ($category['description'] == "") ?  "No Description" : $category['description'] ;  ?></p>
                                <div class="d-flex justify-content-around">
                                    <div class="cat-left">
                                    <p class="details-cat" > <span class="cat-card" > Ordering </span> :  <?php echo $category['ordering'] ?></p>
                                    <p class="details-cat" > <span class="cat-card" >  Visibility </span> : <?php echo ($category['visibility'] == "0") ?  "<span class='no'>No</span>" : "<span class='yes'>Yes</span>" ;?></p>
                                    </div>
                                    <div class="cat-right">
                                    <p class="details-cat" > <span class="cat-card" >  Comment </span> :<?php echo ($category['allow_comment'] == "0") ?  "<span class='no'>No</span>" : "<span class='yes'>Yes</span>" ;?></p>
                                    <p class="details-cat" > <span class="cat-card" >  Ads  </span>: <?php echo ($category['allow_ads'] == "0") ?  "<span class='no'>No</span>" : "<span class='yes'>Yes</span>" ;?></p>
                                    </div>
                                </div>
                            
                        </div>
                        <div class="foot">
                            <a  href="categories.php?href=Edit&id=<?php echo $category['ID'] ;?>"><i class="fas fa-pen-nib edite"></i></a>
                            <a  href="categories.php?href=Delete&id=<?php echo $category['ID'] ;?>"><i class="fas fa-trash del "></i></a>
                        </div>
                    </div>
                
                    <?php } ?>

                </div>
            </div>
        
    <?php } elseif ($href == "Add") {?>

        <div class="add">

            <h1 class="text-center text-dark">Add New Category</h1>

            <div class="container fw-bold">
                <form class="form-horizontal" action="categories.php?href=Insert" method="post">
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Category Name</label>
                        <input name="name" type="text" class="col-sm-10 col-md-5" placeholder="Category Name">
                    </div>
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <input name="description" type="text" class="col-sm-10 col-md-5" placeholder="Category Description">
                    </div>
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Ordering</label>
                        <input name="ordering" type="number" class="col-sm-10 col-md-5" placeholder="Arrange The Categories">
                    </div>

                    <div class="form-group form-group-lg d-flex">
                        <label class="col-sm-2 control-label">Visiblity</label>
                        <div class="col-sm-10 col-md-6 d-flex justify-content-around">
                            <div>
                                <input type="radio" id="vis" name="visibilty" value="0" checked>
                                <label for="vis">yes</label>
                            </div>
                            <div>
                                <input type="radio" id="not-vis" name="visibilty" value="1">
                                <label for="not-vis">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group-lg d-flex">
                        <label class="col-sm-2 control-label">Comments</label>
                        <div class="col-sm-10 col-md-6 d-flex justify-content-around">
                            <div>
                                <input type="radio" id="com" name="comment" value="0" checked>
                                <label for="com">yes</label>
                            </div>
                            <div>
                                <input type="radio" id="com-no" name="comment" value="1">
                                <label for="com-no">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group-lg d-flex">
                        <label class="col-sm-2 control-label">Allow Ads</label>
                        <div class="col-sm-10 col-md-6 d-flex justify-content-around">
                            <div>
                                <input type="radio" id="ads" name="Ads" value="0" checked>
                                <label for="ads">yes</label>
                            </div>
                            <div>
                                <input type="radio" id="no-ads" name="Ads" value="1">
                                <label for="no-ads">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <div class="offset-2 col-sm-10">
                            <input type="submit" value="Add" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>


<?php
    } elseif ($href == "Insert") {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            echo "<h1 class='text-center'> Add Catergory </h1>";
            echo "<div class='container text-center'>";

            $name = $_POST["name"];

            $description = $_POST["description"];

            $ordering = $_POST["ordering"];

            $visibilty = $_POST["visibilty"];

            $allowComment = $_POST["comment"];

            $allowAds = $_POST["Ads"];


            // check Validation Of Data 

            if (!empty($name) ) {
           
        
                $count = checkItem('name', 'categories', $name);
                if ($count == 1) {
                    echo "<div class='alert alert-danger text-center'> Category Name Already Exist </div>";
                } else {
                    $query = "INSERT INTO categories (name , description , ordering , allow_comment , allow_ads )
                    VALUES ( '$name' , '$description' , '$ordering' , '$allowComment' , '$allowAds' )";
                    $stmt = $con->prepare($query);
                    $stmt->execute();


                    echo  '
                        <div class="alert alert-primary"> Added Successfuly </div>
                        <a class="btn btn-primary text-center" href="members.php"> Done</a> 
                    ';
                }
            }else{
                $errorMsg = "<div class='alert alert-danger text-center'> Category Name Can't Be Empty </div>"; 
                HomeRedirect($errorMsg , "categories.php"); ;
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


            HomeRedirect($errorMsg , 'categories.php' );
        }
        
    } elseif ($href = "Edite") {

        $cat_id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $stmtCat = stmt("SELECT * FROM categories WHERE ID =". "$cat_id" ) ;
        $cat = $stmtCat->fetch() ;
        $count = $stmtCat->rowCount() ;



        if ($count > 0) {
        ?>

            <div class="edite">

            <h1 class="text-center text-dark">Update Category</h1>

            <div class="container fw-bold">
                <form class="form-horizontal" action="categories.php?href=Update" method="post">
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Category Name</label>
                        <input name="name" type="text" class="col-sm-10 col-md-5" placeholder="Category Name" value="<?php echo $cat['name']  ?>">
                    </div>
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <input name="description" type="text" class="col-sm-10 col-md-5" placeholder="Category Description" value="<?php echo $cat['description'] ?>" >
                    </div>
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Ordering</label>
                        <input name="ordering" type="number" class="col-sm-10 col-md-5" placeholder="Arrange The Categories" value="<?php echo $cat['ordering'] ?>">
                    </div>

                    <div class="form-group form-group-lg d-flex">
                        <label class="col-sm-2 control-label">Visiblity</label>
                        <div class="col-sm-10 col-md-6 d-flex justify-content-around">
                            <div>
                                <input type="radio" id="vis" name="visibilty" value="0" <?php if($cat['visibility'] == 0 ) echo "checked" ; ?>  >
                                <label for="vis">yes</label>
                            </div>
                            <div>
                                <input type="radio" id="not-vis" name="visibilty" value="1" <?php if($cat['visibility'] == 1 ) echo "checked" ; ?> >
                                <label for="not-vis">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group-lg d-flex">
                        <label class="col-sm-2 control-label">Comments</label>
                        <div class="col-sm-10 col-md-6 d-flex justify-content-around">
                            <div>
                                <input type="radio" id="com" name="comment" value="0" <?php if($cat['allow_comment'] == 0 ) echo "checked" ; ?> >
                                <label for="com">yes</label>
                            </div>
                            <div>
                                <input type="radio" id="com-no" name="comment" value="1" <?php if($cat['allow_comment'] == 1 ) echo "checked" ; ?> >
                                <label for="com-no">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group-lg d-flex">
                        <label class="col-sm-2 control-label">Allow Ads</label>
                        <div class="col-sm-10 col-md-6 d-flex justify-content-around">
                            <div>
                                <input type="radio" id="ads" name="Ads" value="0" <?php if($cat['allow_ads'] == 0 ) echo "checked" ; ?> >
                                <label for="ads">yes</label>
                            </div>
                            <div>
                                <input type="radio" id="no-ads" name="Ads" value="1" <?php if($cat['allow_ads'] == 1 ) echo "checked" ; ?> >
                                <label for="no-ads">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <div class="offset-2 col-sm-10">
                            <input type="submit" value="Add" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
            </div>


        <?PHP

        } else {
            $theMsg = '<div class="alert alert-danger"> ID not Exist </div>';
            HomeRedirect($theMsg);
        }
    } elseif ($href = "Update") {

        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            echo "<h1 class='text-center'> Add Catergory </h1>";
            echo "<div class='container text-center'>";

            $name = $_POST["name"];

            $description = $_POST["description"];

            $ordering = $_POST["ordering"];

            $visibilty = $_POST["visibilty"];

            $allowComment = $_POST["comment"];

            $allowAds = $_POST["Ads"];


            // check Validation Of Data 

            if (!empty($name) ) {
           
        
                $count = checkItem('name', 'categories', $name);
                if ($count == 1) {
                    echo "<div class='alert alert-danger text-center'> Category Name Already Exist </div>";
                } else {
                    $query = "UPDATE categories SET (name , description , ordering , allow_comment , allow_ads )
                    VALUES ( '$name' , '$description' , '$ordering' , '$allowComment' , '$allowAds' )";
                    $stmt = $con->prepare($query);
                    $stmt->execute();


                    echo  '
                        <div class="alert alert-primary"> Updated Successfuly </div>
                        <a class="btn btn-primary text-center" href="categories.php"> Done</a> 
                    ';
                }
            }else{
                $errorMsg = "<div class='alert alert-danger text-center'> Category Name Can't Be Empty </div>"; 
                HomeRedirect($errorMsg , "categories.php"); ;
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


            HomeRedirect($errorMsg , 'categories.php' );
        }
        
        
    } elseif ($href = "Delete") {

       
        echo "<h1 class='text-center'> Delete Category  </h1>";
        echo "<div class='container text-center'> ";
    
        $cat_id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $stmt = stmt('DELETE FROM categories WHERE cat_id = ');
        
        $count = $stmt->rowCount();
        
        if ($count > 0) {
    
            $theMsg = '<div class="alert alert-primary"> Deleted </div> ';
            HomeRedirect($theMsg);
        } else {
            $theMsg = '<div class="alert alert-danger"> ID not Exist </div>';
            HomeRedirect($theMsg);
        }

    }


    include $tpl . "footer.php";
}


?>