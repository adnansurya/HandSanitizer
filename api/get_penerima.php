<?php
// session_start();  
include '../global/db_access.php';
$resObj = new \stdClass();
$resObj -> result = "";


// if(($_SESSION['login_role'] == 'Admin')){    

    if(isset($_GET['card'])){
        
        $registered = mysqli_query($conn, "SELECT * FROM penerima WHERE card_id = '".$_GET['card']."'");        
        if (!$registered){
        
            $resObj -> result = "error";
            $resObj -> data = "Error description: " . mysqli_error($conn);
                               
        } else{
            if(mysqli_num_rows($registered) > 0){
                $r = mysqli_fetch_assoc($registered); 
        
                // $data -> nama = $r['nama'];
                // $data -> waktu = $waktu;
                
                $resObj -> result = "success";
                $resObj -> data = $r;
            }else{
                $resObj -> result = "unknown";
                $resObj -> data = $_GET['card'];
            }
        }
        
        
        
    
        echo json_encode($resObj);
        
    }else{
        echo 'Data tidak lengkap';
    }

?>