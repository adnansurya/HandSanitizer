<?php
// session_start();  
include '../global/db_access.php';

$satuTakar = 0.1;

// if(($_SESSION['login_role'] == 'Admin')){    

    if(isset($_GET['card'])){
        
        $load = mysqli_query($conn, "SELECT * FROM penerima WHERE card_id = '".$_GET['card']."'" );        
        $count = mysqli_num_rows($load);
    
        if($count == 1 ) {
            $waktu = $date->format('Y-m-d H:i:s');

            $row = mysqli_fetch_array($load,MYSQLI_ASSOC);
            $no_kk = $row['no_kk'];
            $nik = $row['nik'];

            if($no_kk != '' && $nik != ''){
                $load = mysqli_query($conn, "SELECT * FROM penerima WHERE no_kk = '".$no_kk."'" );      
                $jmlOrang = (int) mysqli_num_rows($load);  
    
                $totalTakar = $jmlOrang * $satuTakar;
                
                echo "TAKAR:".$totalTakar;

                $load =  mysqli_query($conn,"SELECT value FROM global_var WHERE nama_var='beras'");
                $row = mysqli_fetch_array($load,MYSQLI_ASSOC);
                $berasNow = (float) $row['value'];
               
                $totalBeras = $berasNow - $totalTakar;

                $sql = "UPDATE global_var set value='".$totalBeras."' WHERE nama_var='beras'";

                if(!mysqli_query($conn, $sql)){
                    // echo "ERROR";
                    echo("Error stok: " . $conn -> error);
                }else{
                    $sql = "INSERT INTO log_keluar (card_id, jumlah, waktu) VALUES ('".$_GET['card']."','".$totalTakar."','".$waktu."')";

        
                    if(!mysqli_query($conn, $sql)){
                        echo("Error log: " . $conn -> error);
                    }
                }
                
                 
    
            }else{
                echo "ERROR:Data Penerima Tidak Valid.";
            }

                                  
        }else{
            echo 'INFO :Penerima Belum Terdaftar. ';

            $sql = "INSERT INTO penerima (card_id) VALUES ('".$_GET['card']."')";

        
            if(!mysqli_query($conn, $sql)){
                echo "ERROR:Gagal mendaftarkan penerima.";
            }else{
                echo "INFO :Berhasil mendaftarkan penerima.";                   
            }  
        }
    }else{
        echo 'ERROR:Kesalahan Pembacaan';
    }

?>