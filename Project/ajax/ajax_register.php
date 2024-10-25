<?php include 'C:/xampp/htdocs/Project/database/connect.php';

    if(isset($_POST['user']) ){
        $user = $_POST['user'];
        // echo "<pre>";
        // var_dump($user);
        // echo $user['username'];
        $userName = $user['username'];
        $email = $user['email'];
        $pass = md5($user['pass']);
        $role = $user['level'];
        // echo $userName;

        $sql = "INSERT INTO `users` (username, email, password, role)
                VALUES ('$userName','$email', '$pass','$role')";
        
        $result = $con->query($sql);
        if($result == true){
            echo 1;
        }else{
            echo 2;
        }
    }


?>