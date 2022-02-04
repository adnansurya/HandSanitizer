<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Public</div>       
                <a class="nav-link" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>  
                <?php if(isset($_SESSION['login_user'])){if($_SESSION['login_role'] == 'petugas'){  ?>  
                <div class="sb-sidenav-menu-heading">Petugas</div>                                  
                <a class="nav-link" href="penerima.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Daftar Penerima
                </a>
                <a class="nav-link" href="user.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    User
                </a>
                <a class="nav-link" href="zakat_masuk.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Zakat Masuk 
                </a>
                <?php } } ?>
                <div class="sb-sidenav-menu-heading">USER</div>                                  
                <a class="nav-link" href="zakat.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Zakat
                </a>
                   
            </div>
        </div>
        <!-- <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Start Bootstrap
        </div> -->
    </nav>
</div>