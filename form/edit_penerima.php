<?php
// session_start();  
include '../global/db_access.php';

// if(($_SESSION['login_role'] == 'Admin')){    

    if(isset($_POST['nama']) && isset($_POST['nik']) && isset($_POST['jk'])  && isset($_POST['t4Lahir'])
     && isset($_POST['tglLahir']) && isset($_POST['hp']) && isset($_POST['pekerjaan'])  && isset($_POST['card']) && isset($_POST['alamat'])){
         
        $sql = "UPDATE penerima  SET nama='".$_POST['nama']."', nik='".$_POST['nik']."', jenis_kelamin='".$_POST['jk']."', t4_lahir='".$_POST['t4Lahir']."', 
        tgl_lahir=  '".$_POST['tglLahir']."', no_hp='".$_POST['hp']."', pekerjaan='".$_POST['pekerjaan']."', no_kk='".$_POST['kk']."', alamat='".$_POST['alamat']."' 
        WHERE card_id='".$_POST['card']."'"; 
        echo $sql;
       
        if(!mysqli_query($conn, $sql)){
            echo "ERROR";
        }else{
            echo "BERHASIL";
            // header("location: ../permintaan.php");
            echo "<script> window.location.href = '../penerima.php'; </script>";
        }       
     }

?>