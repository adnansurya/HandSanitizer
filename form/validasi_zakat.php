<?php
// session_start();  
include '../global/db_access.php';

// if(($_SESSION['login_role'] == 'Admin')){    

    if(isset($_POST['nik']) && isset($_POST['token']) && isset($_POST['beras'])){
        
        $waktu = $date->format('Y-m-d H:i:s');

         
        $sql = "UPDATE log_masuk set status='Selesai', jumlah=".$_POST['beras'].", waktu='".$waktu."' WHERE nik='".$_POST['nik']."' AND token='".$_POST['token']."'";

       
        if(!mysqli_query($conn, $sql)){
            // echo "ERROR";
            echo("Error description: " . $conn -> error);
        }else{
            echo "BERHASIL";
            
            $load =  mysqli_query($conn,"SELECT value FROM global_var WHERE nama_var='beras'");
            $row = mysqli_fetch_array($load,MYSQLI_ASSOC);
            $berasNow = (float) $row['value'];
            $berasIn = (float) $_POST['beras'];
            $totalBeras = $berasNow + $berasIn;

            $sql = "UPDATE global_var set value='".$totalBeras."' WHERE nama_var='beras'";

            if(!mysqli_query($conn, $sql)){
                // echo "ERROR";
                echo("Error description: " . $conn -> error);
            }else{
                // header("location: ../permintaan.php");
                echo "<script> window.location.href = '../zakat_masuk.php'; </script>";
            }
            
        }       
     }

?>