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

    <!-- Add Product Section -->
    <?php 
    include 'C:/xampp/htdocs/Project/database/connect.php';
    $id = $_SESSION['admin_id'];
        $errPr = [
            'pr_name' => '',
            'dction' => '',
            'price' => '',
            'img' => ''
        ];
        if(isset($_POST['addproduct'])){
            $getPrname = $_POST['productName'];
            $getDrtion = $_POST['productDescription'];
            $getPr = $_POST['productPrice'];
            $getImg = $_FILES['img']['name'];
            $x = true;

            if(empty($getPrname)){
                $errPr['pr_name'] = "Vui long nhap Product Name"; 
                $x = false;
            }else{
                $errPr['pr_name'] = "";
            }
            if(empty($getDrtion)){
                $errPr['dction'] = "Vui long nhap Description"; 
                $x = false;
            }else{
                $errPr['dction'] = "";
            }
            if(empty($getPr)){
                $errPr['price'] = "Vui long nhap Product price"; 
                $x = false;
            }else{
                $errPr['price'] = "";
            }
            if(empty($_FILES['img']['name'])){
                $errPr['img'] = "Vui long chon file upload"; 
                $x = false;
            }else{
                $errPr['img'] = "";
                if(isset($_FILES['img']['name'])){
                    if($_FILES['img']['size'] > 1048576){
                        $errPr['img'] = "file qua lon";
                        $x = false;
                    }else{
                        $filename = explode(".", $_FILES['img']['name']);
                        $endname = strtolower(end($filename));
                        $typename = ['png', 'jpg', 'jpeg'];
                        if(in_array($endname, $typename)){
                            move_uploaded_file($_FILES['img']['tmp_name'], './img_upload/'.$_FILES['img']['name']);
                            $errPr['img'] = "file da upload";
                            // echo "ok";
                        }else{
                            $errPr['img'] = "file khong dung dinh dang";
                        }
                    }
                }
            }
            if($x == true){
                $sql = "INSERT INTO `product` (`title`, `description`, `price`, `image`,`id_users`) 
                        VALUES ('$getPrname', '$getDrtion', '$getPr', '$getImg', '$id') ";
                $result = $con->query($sql);
                if($result == true){
                    echo 'Upload thành công';
                }else{
                    echo 'Lỗi: ' . $con->error;
                }
            }
            
        }
    ?>
    <div id="addProduct" class="form-section">
        <h2>Add Product</h2>
    
        <form id="addProductForm" action="#" method="post" enctype="multipart/form-data">
            <input type="text" class="1" name="productName" placeholder="Product Name" >
            <p> <?php echo $errPr['pr_name']?></p>

            <textarea class="2" name="productDescription" placeholder="Product Description" rows="4" ></textarea>
            <p> <?php echo $errPr['dction']?></p>

            <input type="number" class="3" name="productPrice" placeholder="Product Price" step="0.01">
            <p> <?php echo $errPr['price']?></p>

            <input type="file" name="img" placeholder="Image"/>
            <p> <?php echo $errPr['img']?></p>

            <button type="submit" name="addproduct" class="submit-btn">Add Product</button>
        </form>
    </div>

    <!-- Edit Product Section -->

    </div>
</div>



</body>
</html>
