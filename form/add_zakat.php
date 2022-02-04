<?php
// session_start();  
include '../global/db_access.php';
include '../global/utility.php';

// if(($_SESSION['login_role'] == 'Admin')){    

    if(isset($_GET['nik'])){
        

        $token = generateRandomString();
        $waktu = $date->format('Y-m-d H:i:s');
        $sql = "INSERT INTO log_masuk (nik, token, waktu, status, jumlah ) 
        VALUES ('".$_GET['nik']."','".$token."','".$waktu."','Menunggu','-')";

       
        if(!mysqli_query($conn, $sql)){
            // echo "ERROR";
            echo("Error description: " . $conn -> error);
        }else{
            echo "BERHASIL";
            // header("location: ../permintaan.php");
            echo "<script> window.location.href = '../zakat.php'; </script>";
        }       
     }

?>