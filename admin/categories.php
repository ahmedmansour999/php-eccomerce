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
                    <div class="cat-header">
                        <a href="categories.php?href=Add" class="btn btn-primary"><i class="fas fa-plus"></i> Add Category</a>
                        <div class="options ">
                            <div class="ordering" > <i class="fas fa-sort"></i> Ordering : [ <a href="?sort=ASC" class=" <?php if($sort == "ASC")echo 'active'?> " >Asc </a> | <a href="?sort=DESC" class=" <?php if($sort == "DESC")echo 'active'?>" >Desc </a> ]</div>
                            <div class="view"><i class="fas fa-eye"></i> View :
                                [<a data-view="full" class="full ">Full</a> |
                                <a data-view="classic" class="Classic active">Classic</a>]
                              </div> 
                        </div>
                    </div>
                     <?php foreach ($allCatergories as $category) { ?>
                
                    <div class="cat position-relative">
                        <div class="head">
                            <h3 class="text-center "><?php echo $category['name'] ?></h3>
                        </div>
                        <div class="body " id="<?php echo $category['ID'] ?>">
                            
                                <p> <span class="fw-bold" >Description :</span> <?php echo ($category['description'] == "") ?  "No Description" : $category['description'] ;  ?></p>
                                <div class="d-flex justify-content-around">
                                    <div class="cat-left">
                                        <p class="details-cat"><span class="cat-card">Ordering</span>: <span class="border border-1 px-2 bg-white"><?php echo $category['ordering'] ?></span></p>
                                        <p class="details-cat"><span class="cat-card">Visibility</span>: <?php echo ($category['visibility'] == "0") ? "<span class='no'><i class='fas fa-times'></i></span>" : "<span class='yes'><i class='fas fa-check'></i></span>";?></p>
                                    </div>
                                    <div class="cat-right">
                                        <p class="details-cat"><span class="cat-card">Comment</span>:<?php echo ($category['allow_comment'] == "0") ? "<span class='no'><i class='fas fa-times'></i></span>" : "<span class='yes'><i class='fas fa-check'></i></span>";?></p>
                                        <p class="details-cat"><span class="cat-card">Ads</span>: <?php echo ($category['allow_ads'] == "0") ? "<span class='no'><i class='fas fa-times'></i></span>" : "<span class='yes'><i class='fas fa-check'></i></span>";?></p>
                                    </div>
                                </div>
                        
                            
                        </div>
                        <div class="foot">
                            <a  class="del confirm" href="categories.php?href=Delete&id=<?php echo $category['ID'] ;?>"><i class="fas fa-trash  "></i>Delete</a>
                            <a  class="edite" href="categories.php?href=Edite&id=<?php echo $category['ID'] ;?>"><i class="fas fa-pen-nib "></i>Edite</a>
                        </div>
                    </div>
                                            <!-- Chiled Category  -->
                    <?php
                        $condition = "where parent =". $category['ID'] ;
                        $childCats = getItem('*' , 'categories' , $condition ) ;
                        if ( !empty($childCats) ) {
                            echo  '<div class="child px-4 fw-bold">
                                        <p class="m-0 text-success" >Child Categories</p>
                                        <div class=" child-link " >
                                        ' ;
                            foreach($childCats as $cat){ 
                                echo "<div class='link'> <p class='m-0 px-5 py-1'>  
                                            <a class='text-dark' href='categories.php?href=Edite&id=" . $cat['ID'] . "'>" . $cat['name'] . "</a> 
                                             <a  class='del confirm show-delete text-danger mx-3' href='categories.php?href=Delete&id=' " .  $category['ID'] ."'>Delete</a>
                                    </p> </div> ";
                        
                            }           
                                    echo  '</div>
                                    </div>    
                            ' ;
                        }
                    } ?>


                </div>
            </div>
        
        <?php
    } elseif ($href == "Add") {?>

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
                        <label class="col-sm-2 control-label">Parent</label>
                        <select name="parent" id="parent" class="col-sm-10 col-md-5 mb-3 p-1"  >
                            <option value="0">None</option>
                            <?php 
                                $parentCats = getItem('*' , 'categories' , 'where parent = 0' );
                                foreach($parentCats as $parentCat) {
                                    
                            ?>
                            <option value="<?php echo $parentCat['ID'] ?> ">
                                        <?php echo $parentCat['name'] ?>
                            </option>
                            <?php } ?>
                        </select>
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

            $parent = $_POST['parent'] ;


            // check Validation Of Data 

            if (!empty($name) ) {
           
        
                $count = checkItem('name', 'categories', $name);
                if ($count == 1) {
                    echo "<div class='alert alert-danger text-center'> Category Name Already Exist </div>";
                } else {
                    $query = "INSERT INTO categories (name , description , parent , ordering , allow_comment , allow_ads )
                    VALUES ( '$name' , '$description' , '$parent' , '$ordering' , '$allowComment' , '$allowAds' )";
                    $stmt = $con->prepare($query);
                    $stmt->execute();


                    echo  '
                        <div class="alert alert-primary"> Added Successfuly </div>
                        <a class="btn btn-primary text-center" href="categories.php"> Done</a> 
                    ';
                }
            }else{
                $errorMsg = "<div class='alert alert-danger text-center'> Category Name Can't Be Empty </div>"; 
                HomeRedirect($errorMsg , "categories.php"); ;
                exit();
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
        
    } elseif ($href == "Edite") {

        $cat_id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        echo $cat_id ;
        $stmtCat = stmt("SELECT * FROM categories WHERE ID =". $cat_id ) ;
        $cat = $stmtCat->fetch() ;
        $count = $stmtCat->rowCount() ;


        
        if ($count > 0 ) {
            ?>

            <div class="edite">

                <h1 class="text-center text-dark">Update Category</h1>

                <div class="container fw-bold">
                    <form class="form-horizontal" action="categories.php?href=Update" method="POST">
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Category Name</label>
                            <input name="name" type="text" class="col-sm-10 col-md-5" placeholder="Category Name" value="<?php echo $cat['name']  ?>">
                            <input name="id" type="hidden" value="<?php echo $cat['ID']  ?>">
                        </div>
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Description</label>
                            <input name="description" type="text" class="col-sm-10 col-md-5" placeholder="Category Description" value="<?php echo $cat['description'] ?>" >
                        </div>
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Parent</label>
                            <select name="parent" id="parent" class="col-sm-10 col-md-5 mb-3 p-1"  >
                                <option value="0">None</option>
                                <?php 
                                
                                    $parentCats = getItem('*' , 'categories' , 'where parent = 0' );
                                    foreach($parentCats as $parentCat) {
                                        
                                ?>
                                <option value="<?php echo $parentCat['ID'] ?> " <?php if ($parentCat['ID'] == $cat['parent'] ) {
                                    echo "selected" ;} ?> >
                                            <?php echo $parentCat['name'] ?>
                                </option>
                                <?php } ?>
                            </select>
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
                                <input type="submit" value="Update" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
            <?PHP

        } if ($count == 0) {
            $theMsg = '<div class="alert alert-danger"> ID not Exist </div>';
            // HomeRedirect($theMsg);
            echo $theMsg ;
        }
    } elseif ($href == "Update") {

        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            echo "<h1 class='text-center'> Add Catergory </h1>";
            echo "<div class='container text-center'>";

            $name = $_POST["name"];

            $id = $_POST["id"] ;

            $description = $_POST["description"];

            $parent = $_POST["parent"];

            $ordering = $_POST["ordering"];

            $visibilty = $_POST["visibilty"];

            $allowComment = $_POST["comment"];

            $allowAds = $_POST["Ads"];


            // check Validation Of Data 

            if (!empty($name) ) {
                
                $exeptionId = "AND id != '$id' " ;
                $count = checkItem('name', 'categories', $name , $exeptionId );

                if ($count == 1) {

                    echo "<div class='alert alert-danger text-center'> Category Name Already Exist </div>";

                } else {
                    $query = "UPDATE categories 
                        SET name='$name', 
                            description='$description', 
                            parent='$parent', 
                            ordering='$ordering', 
                            allow_comment='$allowComment', 
                            allow_ads='$allowAds' 
                        WHERE ID='$id'";
          
                    stmt($query) ;

                    // $stmt = $con->prepare($query);
                    // $stmt->execute();


                    echo  '
                        <div class="alert alert-primary"> Updated Successfuly </div>
                        <a class="btn btn-primary text-center" href="categories.php"> Done</a> 
                    ';
                }

            }else{
                $errorMsg = "<div class='alert alert-danger text-center'> Category Name Can't Be Empty </div>"; 
                HomeRedirect($errorMsg , "categories.php"); ;
                exit();
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
            exit();
        }
        
        
    } elseif ($href == "Delete") {

       
        echo "<h1 class='text-center'> Delete Category  </h1>";

        echo "<div class='container text-center'> ";
    
        $cat_id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

        $stmt = stmt('DELETE FROM categories WHERE ID ='.$cat_id);
        
        $count = $stmt->rowCount();
        
        if ($count > 0) {
    
            $theMsg = '<div class="alert alert-primary"> Deleted </div> ';
            HomeRedirect($theMsg);
            exit();

        } else {

            $theMsg = '<div class="alert alert-danger"> ID not Exist </div>';
            HomeRedirect($theMsg);
            exit();

        }

    }


    include $tpl . "footer.php";
}


?>