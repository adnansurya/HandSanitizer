<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="index.html">BeRice</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <!-- <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
        </div>
    </form> -->
    <!-- Navbar-->
    <div class="position-absolute top-50 end-0 translate-middle-y">
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-8">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i>  <?php if(isset($_SESSION['login_user'])){echo $_SESSION['login_user'];  }?></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">                   
                    <!-- <li><hr class="dropdown-divider" /></li> -->
                    <?php if(isset($_SESSION['login_user'])){  ?>
                        <li><a class="dropdown-item" href="form/logout.php">Logout</a></li>
                    <?php }else { ?>
                    <li><a class="dropdown-item" href="login.php">Login</a></li>
                    <?php } ?>
                
                </ul>
            </li>
        </ul>
    </div>
    
</nav>