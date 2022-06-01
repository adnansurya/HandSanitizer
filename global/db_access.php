<?php
//konfigurasi akses database
// $conn = mysqli_connect("localhost", "root", "", "handsanitizer");
$conn = mysqli_connect("localhost", "id18601438_protohs", "H@ndSanitiz3r", "id18601438_proto");

$date = new DateTime("now", new DateTimeZone('Asia/Makassar') );

//token api untuk akses bot dan chat id untuk id telegram tujuan chat
$tokenAPI = '5462037985:AAHWj01D5QSipWGCsJt6iu1suhVvouq77Ug';
$chatId = '633689498'; 
?>