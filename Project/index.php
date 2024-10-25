<?php session_start();
include 'C:/xampp/htdocs/Project/database/connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <link rel="stylesheet" href="css/index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
                body {
            background-image: url(img/bkgroud.jpg);
        }
    </style>
        <style>
        .styled-link {
            display: inline-block;
            padding: 0;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
        }
        
        .styled-link:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        
        .styled-link:active {
            background-color: #004494;
            transform: translateY(0);
        }
        nav ul li img{
            width: 10px;
        }

            /* .cart-icon {
    position: relative;
    display: inline-block;
} */

.fas.fa-shopping-cart {
    position: relative;
    font-size: 24px; /* Kích thước biểu tượng */
    color: white; /* Màu sắc biểu tượng */
}

/* Định dạng cho số lượng sản phẩm */
.cart-quantity {
    position: absolute;
    top: -10px; /* Đặt số lượng lên trên cùng của biểu tượng */
    right: -10px; /* Đặt số lượng lệch phải của biểu tượng */
    background-color: red; /* Màu nền của số lượng */
    color: white; /* Màu chữ của số lượng */
    border-radius: 50%; /* Tạo hình tròn cho số lượng */
    padding: 2px 6px; /* Padding cho số lượng */
    font-size: 12px; /* Kích thước chữ của số lượng */
    font-weight: bold; /* Chữ đậm */
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Cải thiện hiển thị khi hover */
.cart-quantity:hover {
    background-color: #ffcc00;
    transition: background-color 0.3s ease;
}
    </style>
</head>
<body>

<?php 
    // session_start();
    $qty = 0;
    if(isset($_SESSION['cart'])){
        $cart = $_SESSION['cart'];
        foreach($cart as $key){
            $qty += $key['qty'];
        }

    }
    // $cart_quantity = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
    echo $qty;
    $login = 'Login';
    $link = 'register_login.php';
    $admin_text = ""; // Biến chứa text "Admin"
    $admin_image = ""; // Biến chứa đường dẫn hình ảnh
    $link_admin = "cart.php";

    if(isset($_SESSION['admin_id'])){
        $login = 'Log out';
        $link = 'logout.php';
        $admin_text = "Admin";
    } elseif(isset($_SESSION['client_id'])){
        $login = 'Log out';
        $link = 'logout.php';
        $admin_image = "img/cart.jpg";
    }
    
?>
<!-- Header -->
<header>
    <div class="website-name">My Website</div>
    <!-- Navigation Menu -->
    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Products</a></li>
            <li><a href="#">About Us</a></li>
            <li>
                <a href="<?php echo $link_admin; ?>">
                    <?php 
                    if ($admin_text) {
                        echo $admin_text;
                    } elseif ($admin_image) {
                        // Hiển thị biểu tượng giỏ hàng và số lượng sản phẩm
                        echo "<i class='fas fa-shopping-cart'>$qty</i>";
                        // if ($qty > 0) {
                        //     echo "<span class='cart-quantity'>$qty</span>";
                        // }
                    }
                    ?>
                </a>
            </li>
            <li><a href="<?php echo $link; ?>"><?php echo $login; ?></a></li>
        </ul>
    </nav>
</header>

    <!-- Main Body for Products -->
    <div class="product-container">
        <div class="container_pr">

            <!-- Menu bên trái -->
            <div class="container_menu">

    
    <!-- Sản phẩm Nổi bật -->
                <section class="featured-products">
                    <h2 style="color: white;">Sản phẩm Nổi bật</h2>
                    <div class="product-list">
                        <div class="product-item">
                            <img src="img/giay.jpg" alt="Sản phẩm 1">
                            <h3>Sản phẩm 1</h3>
                            <p>Mô tả ngắn về sản phẩm 1.</p>
                            <a href="#">Xem chi tiết</a>
                        </div>
                        <div class="product-item">
                            <img src="img/giay.jpg" alt="Sản phẩm 2">
                            <h3>Sản phẩm 2</h3>
                            <p>Mô tả ngắn về sản phẩm 2.</p>
                            <a href="#">Xem chi tiết</a>
                        </div>
                        <!-- Thêm các sản phẩm khác -->
                    </div>
                </section>



                <!-- Tìm kiếm -->
                <section class="search-form">
                    <h2>Tìm kiếm</h2>
                    <form action="search_results.html" method="get">
                        <input type="text" name="query" placeholder="<?php echo $qty?>">
                        <button type="submit">Tìm kiếm</button>
                    </form>
                </section>

                <!-- Thông tin Khuyến Mãi -->
                <section class="promotions">
                    <h2>Khuyến mãi</h2>
                    <p>Đừng bỏ lỡ các ưu đãi đặc biệt! Giảm giá lên đến 50% cho các sản phẩm chọn lọc.</p>
                    <a href="#">Xem tất cả khuyến mãi</a>
                </section>
            </div>

            <!-- Phần sản phẩm -->
            <div class="container_sp">
                <section class="product-grid">
                    <?php
                    if(isset($_SESSION['admin_id'])){
                        $id = $_SESSION['admin_id'];
                    }else{
                        $id = "";
                    }
                    
                        $sql = "SELECT * FROM `product` ";
                        $result = $con->query($sql);
                        $data = [];
                        if($result && $result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                $data[] = $row; // Thêm từng hàng vào mảng $data
                            }
                        }
                        foreach($data as $key){
                            ?>

                            <div class="product">
                                <div class="product-image">
                                    <img src="<?php echo "img_upload/".$key['image']?>" alt="Product 1">
                                    <a class="description-link" href="#">Description</a>
                                </div>
                                <h3><?php echo $key['title']?></h3>
                                <p style="color: black;"><?php echo $key['price']."$"?></p>
                                <input type="hidden" class="id_pr" value="<?php echo $key['id_product']?>" name="">
                                <button type="submit" class="add_to_cart">Add to cart</button>
                            </div>
                    <?php
                        }
                    ?>
                </section>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>Address: 123 Street Name, City, Country | Phone: +123456789</p>
    </footer>

    <script>
        $(document).ready(function(){
            $('button.add_to_cart').click(function(event){
                event.preventDefault();

                var id = $(this).closest('div.product').find('input.id_pr').val();
                // alert(id);
                var qty = $('i.fas').text();
                // alert(qty);
                var newCart = parseInt(qty)  + 1;
                $('i.fas').text(newCart);
				$.ajax({
					method: "POST",
					url: "ajax/ajax_cart.php", //	k co html va chi chay ngầm
					data: {
						id : id

					},
					success : function(res){
						
						// ket qua ben php tra ve lai
						console.log(res)
						
						
					}
				});
                
            });
        });


    </script>

</body>
</html>
