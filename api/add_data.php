<?php

include '../global/db_access.php'; //mengambil file konfigurasi akses database
include '../global/utility.php';  //menambahkan file untuk fungsi tambahan yang dibutuhkan 

if(isset($_GET['suhu']) && isset($_GET['cairan'])){ //memeriksa jika nilai suhu dan ADC cairan tersedia

    $waktu = $date->format('Y-m-d H:i:s'); //mengatur format penulisan waktu

    //perintah sql untuk menambahkan data log
    $sql = "INSERT INTO log_action (suhu, cairan, cairan_max, cairan_min, waktu) VALUES ('".$_GET['suhu']."','".$_GET['cairan']."','".$_GET['max']."','".$_GET['min']."','".$waktu."')";



    //mengeksekusi perintah sql 
    if(!mysqli_query($conn, $sql)){
        echo("Error log: " . $conn -> error);
    }else{
        echo "Berhasil";
    }

    $statusCair = statCairan($_GET['cairan'],$_GET['max'],$_GET['min']); //mengambil teks status cairan

    //kirim notifikasi saat cairan kosong
    if($statusCair  == "Kosong"){
        $pesan = "Cairan Kosong! Silahkan isi ulang.";
        sendMessage($chatId, $pesan, $tokenAPI);
    }
}else{
    echo 'ERROR:Parameter Tidak Lengkap';
}


?>