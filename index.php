
<!DOCTYPE html>
<html lang="en">
<?php include("global/utility.php");  //menambahkan file untuk fungsi tambahan yang dibutuhkan ?>
    <head>
        <?php include("partials/head.php"); ?>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.1/css/fixedHeader.bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
        <title>Dashboard - Hand Sanitizer</title>
    </head>
    <body class="sb-nav-fixed">
        <?php include("partials/topbar.php"); //mengambil tampilan menu atas?>
        <div id="layoutSidenav">
            <?php include("partials/leftbar.php"); //mengambil tampilan menu di samping kiri ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <div class="row">
                            <div class="col-md-6">                                
                                <h1 class="my-4">Dashboard</h1>                                  
                            </div>
                            
                        </div>
                        <?php
                            include 'global/db_access.php'; //menambahkan file konfigurasi akses database
                            $statusCair = 'Error';
                            $load = mysqli_query($conn, "SELECT * FROM log_action ORDER BY id_action DESC LIMIT 1");   // perintah sql untuk mengambil 1 baris data terakhir
                            $row = mysqli_fetch_assoc($load);  //menjalankan perintah sql                          
                            $statusCair = statCairan($row['cairan'],$row['cairan_max'],$row['cairan_min']); //mengambil teks status cairan
                            
                            //mengambil suhu rata-rata
                            $load = mysqli_query($conn, "SELECT AVG(suhu) as rerata FROM log_action");
                            $row = mysqli_fetch_assoc($load);  
                            $suhu_rerata = $row['rerata'];

                            //mengambil suhu maksimal
                            $load = mysqli_query($conn, "SELECT MAX(suhu) as suhu_max FROM log_action");
                            $row = mysqli_fetch_assoc($load);  
                            $suhu_max = $row['suhu_max'];

                            //mengambil suhu minimal
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
                                            //menampilkan status cairan terakhir pada dashboard
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
                                            //menampilkan suhu rata-rata pada dashboard
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
                                            //menampilkan suhu maksimal pada dashboard
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
                                            //menampilkan suhu minimum pada dashboard
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
                                <!-- tabel untuk menampilkan seluruh log data -->
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
                                        
                                        //perintah sql untuk mengambil seluruh data log                                       
                                        $load = mysqli_query($conn, "SELECT * FROM log_action ORDER BY id_action ASC");   
                                        //melakukan iterasi pada seluruh data log
                                        while ($row = mysqli_fetch_array($load)){
                                        $persenCair = $row['cairan'] / $row['cairan_max'] * 100.0; //mengambil status cairan dalam persen
                                        echo '<tr>';
                                            echo '<td>'.$row['id_action'].'</td>'; //menampilkan id log ke dalam tabel
                                            echo '<td>'.tglWaktuIndo($row['waktu']).'</td>'; //menampilkan waktu ke dalam tabel
                                            //menampilkan status sisa cairan ke dalam tabel
                                            echo '<td>'.round($persenCair,2).' % <small>('. statCairan($row['cairan'],$row['cairan_max'],$row['cairan_min']) .')</small></td>';
                                            //menampilkan nilai ADC water sensor ke dalam tabel
                                            echo '<td>'.$row['cairan'].' <small>(Max: '.$row['cairan_max'].', Min: '.$row['cairan_min'].')</small></td>';
                                            echo '<td>'.$row['suhu'].' &#8451;</td>'; //menampilkan nilai suhu ke dalam tabel
                                        echo '</tr>';                                
                                        }   
                                    ?>
                                    </tbody>
                                </table> 
                            </div>
                        </div>                  
                        
                    </div>
                </main>
                <?php include('partials/footer.php'); //mengambil tampilan footer ?>
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
            //fungsi javascript untuk mengaktifkan library datatables
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
