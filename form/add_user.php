<?php
// session_start();  
include '../global/db_access.php';

// if(($_SESSION['login_role'] == 'Admin')){    

    if(isset($_POST['nama']) && isset($_POST['nik']) && isset($_POST['jk'])  && isset($_POST['t4Lahir'])
     && isset($_POST['tglLahir']) && isset($_POST['hp']) && isset($_POST['pekerjaan'])  && isset($_POST['alamat']) && isset($_POST['pass'])){
         
        $sql = "INSERT INTO user (nama, nik, jenis_kelamin, t4_lahir, tgl_lahir, no_hp, pekerjaan, alamat, pass, email, role ) 
        VALUES ('".$_POST['nama']."','".$_POST['nik']."','".$_POST['jk']."','".$_POST['t4Lahir']."',
        '".$_POST['tglLahir']."','".$_POST['hp']."','".$_POST['pekerjaan']."','".$_POST['alamat']."','".$_POST['pass']."','".$_POST['email']."','user')";

       
        if(!mysqli_query($conn, $sql)){
            // echo "ERROR";
            echo("Error description: " . $conn -> error);
        }else{
            echo "BERHASIL";
            // header("location: ../permintaan.php");
            echo "<script> window.location.href = '../user.php'; </script>";
        }       
     }

?>