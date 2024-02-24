 
<?php 

  $username = $_SESSION['username']; ; 
  
 ?> 


<nav class="navbar navbar-dark navbar-expand-lg bg-dark  ">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100">
        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="dashboard.php"><?php echo lang('HOME') ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="categories.php"><?php echo lang('CATEGORIES') ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./items.php"><?php echo lang('ITEMS') ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="members.php"><?php echo lang('MEMBER') ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="comments.php"><?php echo lang('COMMENTS') ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../index.php"><?php echo lang('SHOP') ?></a>
        </li>

        <li class="nav-item dropdown float-right">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $username ?>
          </a>
          <ul class="dropdown-menu ">
            <li><a class="dropdown-item" href="members.php?href=Edite&userid=<?php echo $_SESSION['ID'] ?>"><?php echo lang('EDITE_PROFILE') ?></a></li>
            <li><a class="dropdown-item" href="#"> <?php echo lang('SETTING') ?></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php"> <?php echo lang('LOGOUT') ?></a></li>
          </ul>
        </li>

      </ul>

    </div>
  </div>
</nav>