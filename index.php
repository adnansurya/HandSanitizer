
<!DOCTYPE html>
<html lang="en">
<?php include("global/utility.php"); ?>
    <head>
        <?php include("partials/head.php"); ?>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.1/css/fixedHeader.bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
        <title>Dashboard - Hand Sanitizer</title>
    </head>
    <body class="sb-nav-fixed">
        <?php include("partials/topbar.php"); ?>
        <div id="layoutSidenav">
            <?php include("partials/leftbar.php"); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <div class="row">
                            <div class="col-md-6">                                
                                <h1 class="my-4">Dashboard</h1>                                  
                            </div>
                            
                        </div>
                        <?php
                            include 'global/db_access.php';
                            $statusCair = 'Error';
                            $load = mysqli_query($conn, "SELECT * FROM log_action ORDER BY id_action DESC LIMIT 1");   
                            $row = mysqli_fetch_assoc($load);                           
                            $statusCair = statCairan($row['cairan'],$row['cairan_max'],$row['cairan_min']); 
                            
                            $load = mysqli_query($conn, "SELECT AVG(suhu) as rerata FROM log_action");
                            $row = mysqli_fetch_assoc($load);  
                            $suhu_rerata = $row['rerata'];

                            $load = mysqli_query($conn, "SELECT MAX(suhu) as suhu_max FROM log_action");
                            $row = mysqli_fetch_assoc($load);  
                            $suhu_max = $row['suhu_max'];

                            $load = mysqli_query($conn, "SELECT MIN(suhu) as suhu_min FROM log_action");
                            $row = mysqli_fetch_assoc($load);  
                            $suhu_min = $row['suhu_min'];
                        ?>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-default mb-4">
                                    <div class="card-body">
                                        <p>Status Cairan</p>   
                                        
                                        <?php 
                                            if($statusCair=='Kosong'){
                                                echo '<h3 class="text-warning">'.$statusCair.'</h3>';                                    
                                            }else if($statusCair=='Normal'){
                                                echo '<h3 class="text-primary">'.$statusCair.'</h3>';                                    
                                            }else if($statusCair=='Penuh'){
                                                echo '<h3 class="text-success">'.$statusCair.'</h3>';                                    
                                            }else if($statusCair=='Error'){
                                                echo '<h3 class="text-danger">'.$statusCair.'</h3>';                                    
                                            }
                                         ?>                                    
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-default mb-4">
                                    <div class="card-body">
                                        <p>Suhu Rata-Rata</p>
                                        <?php
                                            echo '<h3>'. round($suhu_rerata,2).'  &#8451</h3>'; 
                                        ?>
                                    </div>                                   
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-default mb-4">
                                    <div class="card-body">
                                        <p>Suhu Tertinggi</p>
                                        <?php
                                            echo '<h3 class="text-danger">'. $suhu_max.'  &#8451</h3>'; 
                                        ?>
                                    </div>                                   
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-default mb-4">
                                    <div class="card-body">
                                        <p>Suhu Terendah</p>
                                        <?php
                                            echo '<h3 class="text-primary">'. $suhu_min.'  &#8451</h3>'; 
                                        ?>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">                                
                                <h2 class="my-4">Log</h2>                                  
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Waktu</th>   
                                            <th>Sisa Cairan</th>
                                            <th>ADC Cairan</th>
                                            <th>Suhu Tubuh</th>                                                               
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        // $role = $_SESSION['login_role'];
                                                                               
                                        $load = mysqli_query($conn, "SELECT * FROM log_action ORDER BY id_action ASC");   
                                        while ($row = mysqli_fetch_array($load)){
                                        $persenCair = $row['cairan'] / $row['cairan_max'] * 100.0;
                                        echo '<tr>';
                                            echo '<td>'.$row['id_action'].'</td>';
                                            echo '<td>'.tglWaktuIndo($row['waktu']).'</td>';
                                            echo '<td>'.round($persenCair,2).' % <small>('. statCairan($row['cairan'],$row['cairan_max'],$row['cairan_min']) .')</small></td>';
                                            echo '<td>'.$row['cairan'].' <small>(Max: '.$row['cairan_max'].', Min: '.$row['cairan_min'].')</small></td>';
                                            echo '<td>'.$row['suhu'].' &#8451;</td>';                                                           
                                        echo '</tr>';                                
                                        }   
                                    ?>
                                    </tbody>
                                </table> 
                            </div>
                        </div>                  
                        
                    </div>
                </main>
                <?php include('partials/footer.php'); ?>
            </div>
        </div>
        <?php include("partials/scripts.php"); ?>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/fixedheader/3.2.1/js/dataTables.fixedHeader.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>
        <script>
              $(document).ready(function() {
                    $('#bootstrap-data-table').DataTable({
                        "order": [[ 0, "desc" ]],
                        responsive : true
                        // "columnDefs" : [
                        //     {
                        //         "targets" : [0],
                        //         "visible" : false
                        //     }
                        // ]
                    });
              });
        </script>
    </body>
</html>
