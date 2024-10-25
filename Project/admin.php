<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<header>
    <div class="website-name"><h1>Admin Dashboard</h1></div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Products</a></li>
                <li><a href="#">About Us</a></li>
            </ul>
        </nav>
</header>

<div class="container">

    <!-- Tabs -->
    <div class="tab">
        <a href="admin.php"><button type="button" id="up" class="no-click" >Update User</button></a>
        <a href="add_product.php"><button type="button" id="add" class="no-click" >Add Product</button></a>
        <a href="edit_product.php"><button type="button" id="edit" class="no-click" >Edit Product</button></a>
    </div>

    <!-- Update User Section -->
    <div id="updateUser" class="form-section active">
        <h2>Update User</h2>
        <?php 
            include 'C:/xampp/htdocs/Project/database/connect.php';

            // Lấy ID của người dùng từ session
            $id = $_SESSION['admin_id'];
            $msg = [
                'name' => '',
                'mail' => ''
            ];

            // Truy vấn lấy thông tin người dùng hiện tại
            $sql = "SELECT * FROM `users` WHERE `id_users` = '$id';";
            $result = $con->query($sql);
            $data = [];

            if ($result == true) {
                $data = $result->fetch_assoc();
            }

            // Xử lý khi người dùng nhấn nút cập nhật
            if (isset($_POST['update'])) {
                $getName = $_POST['userName'];
                $getMail = $_POST['yourEmail'];
                $getPass = $_POST['password']; // Chưa mã hóa MD5
                $x = true;

                // Kiểm tra nếu mật khẩu không được nhập, chỉ cập nhật tên và email
                if (empty($getPass)) {
                    $sql = "UPDATE `users` SET `username` = '$getName',
                                                `email` = '$getMail' 
                                                WHERE `id_users` = '$id';";
                    $result = $con->query($sql);
                    if ($result  == true) {
                        echo 'Sử dụng mật khẩu cũ.';
                    }
                } else {
                    // Nếu có mật khẩu mới, mã hóa mật khẩu và cập nhật cả ba trường
                    $getPass = md5($getPass);
                    $sql = "UPDATE `users` SET `username` = '$getName',
                                                `email` = '$getMail',
                                                `password` = '$getPass' 
                                                WHERE `id_users` = '$id';";
                    $result = $con->query($sql);
                    if ($result == true) {
                        echo 'Sử dụng mật khẩu mới.';
                    }
                }
            }
        ?>

       
        <form id="updateUserForm" action="" method="post">
            <!-- <input type="text" name="userID" placeholder="User ID" required> -->
            <input type="text" value="<?php echo $data['username']?>" name="userName" placeholder="Username">
            <p><?php echo $msg['name']?></p>
            <input type="email" value="<?php echo $data['email']?>" name="yourEmail" placeholder="User Email" >
            <p><?php echo $msg['mail']?></p>
            <input type="password"  name="password" placeholder="New Password">
            <button type="submit" name="update" class="submit-btn">Update User</button>
        </form>
 
    </div>

    <!-- Add Product Section -->
    



</body>
</html>
