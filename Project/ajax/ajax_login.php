<?php session_start();
 include 'C:/xampp/htdocs/Project/database/connect.php';
    if(isset($_POST['login'])){
        $login = $_POST['login'];
        $username = $login['username'];
        $pass = md5($login['pass']);
        $sql = "SELECT * FROM `users` where `username` = '$username' AND `password` = '$pass';";
        $result = $con ->query($sql);
        if($result->num_rows>0){
            $user = $result->fetch_assoc(); // Lấy thông tin người dùng
            if($user['role'] == 0){
                $_SESSION['admin_id'] = $user['id_users'];
                
                echo 1;
            }elseif($user['role'] == 1){
                $_SESSION['client_id'] = $user['id_users'];
                echo 2;
            }

            // // $id = "";
            // echo $result;
        }else{
            
        }
    }
?>