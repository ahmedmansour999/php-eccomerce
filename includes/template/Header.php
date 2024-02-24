<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="layout/css/front.css">
    
    <title><?php getTitle() ?></title>

</head>

    <div class="upper-bar">
        <div class="container ">
            <span class="fw-bold"> 
                <?php if (isset($_SESSION['user']) ) { ?>
                 
                    <a href=""> Welcome <?php echo $_SESSION['user']  ?> </a>
                    <a href="logout.php"> log out </a>
                    
                <?php }else{ ?>
                    
                    <a href="login.php" class="login" >login</a> | <a href="login.php" class="signup">signup</a>

                <?php } ?>
            </span>
        </div>
    </div>
<nav class="navbar navbar-dark navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand px-5" href="#">Home Page</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="app-nav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 justify-content-end px-5 ">
                <?php 
                $allCat = getCat();
                foreach ($allCat as $cat) { 
                    echo "<li class='nav-item '><a class='nav-link ' href='categories.php?pageid=". $cat['ID']."&pagename=". str_replace(' ' , "_" , $cat['name']) ."'>" . $cat['name'] . "</a></li>";
                }
                ?>
            </ul>
        </div>
    </div>
</nav>




<body>
