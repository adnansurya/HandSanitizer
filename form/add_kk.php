<?php
// session_start();  
include '../global/db_access.php';

// if(($_SESSION['login_role'] == 'Admin')){    

    if(isset($_POST['kk']) && isset($_POST['kepala']) && isset($_POST['alamat'])  && isset($_POST['prov'])
     && isset($_POST['kodepos']) && isset($_POST['lurah']) && isset($_POST['camat'])  && isset($_POST['kota'])){
         
        $sql = "INSERT INTO kk_penerima (no_kk, kepala, alamat,  rt_rw, kodepos, lurah, camat, kota, provinsi ) 
        VALUES ('".$_POST['kk']."','".$_POST['kepala']."','".$_POST['alamat']."','".$_POST['rt']."/".$_POST['rw']."',
        '".$_POST['kodepos']."','".$_POST['lurah']."','".$_POST['camat']."','".$_POST['kota']."','".$_POST['prov']."')";

       
        if(!mysqli_query($conn, $sql)){
            echo "ERROR";
        }else{
            echo "BERHASIL";
            // header("location: ../permintaan.php");
            echo "<script> window.location.href = '../penerima_baru.php'; </script>";
        }       
     }

?>