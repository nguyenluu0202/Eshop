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
<?php  include 'C:/xampp/htdocs/Project/database/connect.php';
    $id = $_SESSION['admin_id'];
    // echo $id;
    $errPr = [
        'id_pr' => "",
        'pr_name' => '',
        'dction' => '',
        'price' => '',
        'img' => ''
    ];
    if(isset($_POST['edit_product'])){
        $getID = $_POST['productID'];
        $getPrname = $_POST['productName'];
        $getDrtion = $_POST['productDescription'];
        $getPr = $_POST['productPrice'];
        $getImg = $_FILES['img']['name'];
        $x = true;

        if(empty($getID)){
            $errPr['id_pr'] = "Vui long nhap Product ID"; 
            $x = false;
        }else{
            $errPr['id_pr'] = "";
        }
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
             
            // $x = false;
            $sql = "UPDATE `product` SET 
                                        `title` = '$getPrname',
                                        `description` = '$getDrtion',
                                        `price` = '$getPr' 
                                        WHERE `id_users` = '$id' AND `id_product` = '$getID'";
            $result = $con->query($sql);
            if($result == true){
                $errPr['img'] = "Giữ nguyên file cũ";
            } else {
                echo "Lỗi SQL: " . $con->error;
            }
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

            if($x == true){
                $sql = "UPDATE `product` SET 
                `title` = '$getPrname',
                `description` = '$getDrtion',
                `price` = '$getPr',
                `image` = '$getImg' 
                WHERE `id_users` = '$id' AND `id_product` = '$getID'";
    
        $result = $con->query($sql);
        if($result == true){
            $errPr['img'] = "Up file moi";
        } else {
            echo "Lỗi SQL: " . $con->error;
        }
            }
        }

                    
    }

?>



    <div id="editProduct" class="form-section_h ">
        <div class="form-section_edit">
            <h2>Edit Product</h2>
            <form id="editProductForm" action="#" method="post" enctype="multipart/form-data">
                <input type="text" id="1" name="productID" placeholder="Product ID" >
                    <p> <?php echo $errPr['id_pr']?></p>

                <input type="text" id="2" value="" name="productName" placeholder="Product Name" >
                <p> <?php echo $errPr['pr_name']?></p>

                <textarea name="productDescription" id="3"  placeholder="Product Description" rows="4" ></textarea>
                <p> <?php echo $errPr['dction']?></p>

                <input type="number" value="" id="4" name="productPrice" placeholder="Product Price" step="0.01" >
                <p> <?php echo $errPr['price']?></p>

                <input type="file" value="" id="5" name="img" accept="image/*">
                <p> <?php echo $errPr['img']?></p>

                <button type="submit" name="edit_product" class="submit-btn">Update Product</button>
            </form>

        </div>


        <!-- Product List -->
         <div class="form-section_tb">
         <h3>Product List</h3>
        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>

                </tr>
            </thead>
            
                <?php 
                    $sql = "SELECT * FROM product WHERE `id_users` = '$id'";
                    $result = $con->query($sql);
                    $data = [];
                    
                    // Kiểm tra nếu có kết quả trả về
                    if($result && $result->num_rows > 0){
                        // Lặp qua từng hàng kết quả và thêm vào mảng $data
                        while($row = $result->fetch_assoc()){
                            $data[] = $row; // Thêm từng hàng vào mảng $data
                        }

                    }
                    // echo "<pre>";
                    // var_dump($data);

                    foreach($data as $key => $value){
                        ?>
            <tbody id="productList">
               <tr>
                    <td><?php echo $value['id_product'] ?></td>
                    <td><?php echo $value['title'] ?> </td>
                    <td><?php echo $value['description'] ?></td>
                    <td><?php echo $value['price'] ?></td>
                    <td><img width="100px" src="<?php echo "img_upload/".$value['image'] ?>" alt=""></td>

                    <td>
                        <form action="#">
                            <input type="hidden" class="id_pr" value="<?php echo $value['id_product'] ?>">
                            <input type="hidden" class="title" value="<?php echo $value['title'] ?>">
                            <input type="hidden" class="description" value="<?php echo $value['description'] ?>">
                            <input type="hidden" class="price" value="<?php echo $value['price'] ?>">
                            <input type="hidden" class="image_pr" value="<?php echo $value['image'] ?>">


                            <button type="button" id="edit" class="submit-btn">Edit</button>
                            <button type="button" id="delete" class="submit-btn">Delete</button>
                        </form>
                    </td>

               </tr> <!-- Dynamic rows will be inserted here -->
            </tbody>
               <?php
                    }
                ?>

        </table>

         </div>
        
    </div>
</div>
<script>
$(document).ready(function(){
    // Sự kiện khi nhấn nút edit
    $('button#edit').click(function(event){
        event.preventDefault();

        // Tìm các input trong dòng gần nhất chứa button 'edit' được nhấn
        var getID = $(this).closest('tr').find('input.id_pr').val();
        var getTt = $(this).closest('tr').find('input.title').val();
        var getDc = $(this).closest('tr').find('input.description').val();
        var getPr = $(this).closest('tr').find('input.price').val();
        var getImg = $(this).closest('tr').find('input.image_pr').val();

        // Kiểm tra và gán giá trị vào các thẻ input/textarea khác
        if(getID != ""){
            $('input#1').val(getID);
        } else {
            $('input#1').val("Lỗi");
        }
        if(getTt != ""){
            $('input#2').val(getTt);
        } else {
            $('input#2').val("Lỗi");
        }
        if(getDc != ""){
            $('textarea#3').val(getDc);
        } else {
            $('textarea#3').val("Lỗi");
        }
        if(getPr != ""){
            $('input#4').val(getPr);
        } else {
            $('input#4').val("Lỗi");
        }
        if(getImg != ""){
            $('input#5').val(getImg);
        } else {
            $('input#5').val("Lỗi");
        }

        var product = {
            id: getID,
            title: getTt,
            description: getDc,
            price: getPr,
            image: getImg
        };
        console.log(product);
    });

    // Sự kiện khi nhấn nút delete
    $('button#delete').click(function(event){
        // event.preventDefault();
        var getID = $(this).closest('tr').find('input.id_pr').val(); // Tìm input có class 'id_pr' trong hàng gần nhất
        console.log(getID);
        $(this).closest('tr').remove();
        $.ajax({
            method: "POST",
            url: "ajax/ajax_delete_product.php",
            data: {
                id_delete : getID
            },
            success: function(res){
                console.log(res);
            }
        });
    });
});

</script>

</body>
</html>
