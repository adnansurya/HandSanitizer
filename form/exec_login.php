<?php
    session_start();
    if(isset($_POST['user']) && isset($_POST['pass'])) {
        // username and password sent from form 
        
         $myuser = $_POST['user'];
         $mypassword = $_POST['pass'];
    
         include '../global/db_access.php';
         $load = mysqli_query($conn, "SELECT * FROM user WHERE (email = '".$myuser."' OR no_hp = '".$myuser."') AND pass='".$mypassword."'" );  
         $row = mysqli_fetch_array($load,MYSQLI_ASSOC);

         $count = mysqli_num_rows($load);
         $error = "";
         if($count == 1 && $error == "") {
      
            $_SESSION['login_user'] = $row['nama'];
            $_SESSION['login_id'] = $row['user_id'];
            $_SESSION['login_hp'] = $row['no_hp'];
            $_SESSION['login_role'] = $row['role'];
            $_SESSION['login_nik'] = $row['nik'];
            echo 'login berhasil';
            
            echo "<script>window.location.href = '../index.php';</script>";
         }else {
            $error = "Your Login Name or Password is invalid";
            echo $error;
         }

    }else{
        echo 'Data tidak lengkap';
        echo "<script>window.location.href = '../login.php';</script>";    
        
    }
?>