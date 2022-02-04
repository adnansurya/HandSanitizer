<?php

include '../global/db_access.php';

if(isset($_GET['suhu']) && isset($_GET['cairan'])){

    $waktu = $date->format('Y-m-d H:i:s');

    $sql = "INSERT INTO log_action (suhu, cairan, waktu) VALUES ('".$_GET['suhu']."','".$_GET['cairan']."','".$waktu."')";

        
    if(!mysqli_query($conn, $sql)){
        echo("Error log: " . $conn -> error);
    }else{
        echo "Berhasil";
    }
}else{
    echo 'ERROR:Parameter Tidak Lengkap';
}


?>