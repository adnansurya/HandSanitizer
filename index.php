<?php  
    session_start();
    if(isset($_SESSION['login_user'])){
        $user_check = $_SESSION['login_user'];
    } 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("partials/head.php"); ?>
        <title>Dashboard - BeRice</title>
    </head>
    <body class="sb-nav-fixed">
        <?php include("partials/topbar.php"); ?>
        <div id="layoutSidenav">
            <?php include("partials/leftbar.php"); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Blank</h1>                       
                        <div class="card my-3">
                            <div class="card-body">
                                This page is an example of using the light side navigation option. By appending the
                                <code>.sb-sidenav-light</code>
                                class to the
                                <code>.sb-sidenav</code>
                                class, the side navigation will take on a light color scheme. The
                                <code>.sb-sidenav-dark</code>
                                is also available for a darker option.
                            </div>
                        </div>
                    </div>
                </main>
                <?php include('partials/footer.php'); ?>
            </div>
        </div>
        <?php include("partials/scripts.php"); ?>
    </body>
</html>
