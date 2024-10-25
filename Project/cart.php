<?php session_start();
include 'C:/xampp/htdocs/Project/database/connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="css/cart.css">
</head>
<body>
    <header>
        <div class="website-name">My Website</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="cart-container">

        <table class="cart-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Image</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
            <th>Actions</th>

        </tr>
    </thead>
    <tbody>
        <?php 
        if($_SESSION['cart']){
            $cart = $_SESSION['cart'];
        }else{
            $cart = "";
        }

            $sum = 0;
            foreach($cart as $key){
                $totalmin = $key['qty'] * $key['price'];
                $sum += $totalmin;
        ?>

        <tr>
            <td class="id"><?php echo $key['id_product']?></td>
            <td><?php echo $key['title']?></td>
            <td><img src="<?php echo "img_upload/".$key['image']?>" alt="Product 1"></td>
            <td>
                <button class="decrease-btn">-</button>
                <input type="number" class="qty" value="<?php echo $key['qty']?>" min="1">
                <button class="increase-btn">+</button>
            </td>
            <td class="price"><?php echo "$".$key['price']?></td>
            <td class="total"><?php echo "$".$totalmin?></td>
            <td>
                <button class="delete-btn">Remove</button>
            </td>
        </tr>
        <?php
            }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5">Total</td>
            <td class="tt"><?php echo "$".$sum?></td>   
            <td ></td>
        </tr>
    </tfoot>
</table>
    <footer>
        <p>Address: 123 Street Name, City, Country | Phone: +123456789</p>
    </footer>
<script>
    $(document).ready(function(){
        $('button.increase-btn').click(function(event){
            event.preventDefault();
            var id = parseInt($(this).closest('tr').find('td.id').text());
            var qty = parseInt($(this).closest('td').find('input.qty').val()) ;
            var total = parseInt($(this).closest('tr').find('td.total').text().replace("$", "").trim()) ;
            var price = parseInt($(this).closest('tr').find('td.price').text().replace("$", "").trim()) ;
            var newQty = qty + 1;

            var newTotal = qty * price;


            $(this).closest('td').find('input.qty').val(newQty);
            $(this).closest('tr').find('td.total').text("$"+ newTotal);
            var qty2 = parseInt($(this).closest('td').find('input.qty').val()) ;

            var sum = 0 
            $('td.total').each(function(){
                var tt = parseInt($(this).closest('tr').find('td.total').text().replace("$", "").trim()) ;
                sum += tt;
            })
            $('td.tt').text("$"+sum)
            $.ajax({
					method: "POST",
					url: "ajax/ajax_qty.php", //	k co html va chi chay ngầm
					data: {
						qty : qty2,
                        id : id

					},
					success : function(res){
						
						// ket qua ben php tra ve lai
						console.log(res)
						
						
					}
				});
        })
        $('button.decrease-btn').click(function(event){
            event.preventDefault();
            var id = parseInt($(this).closest('tr').find('td.id').text());
            var qty = parseInt($(this).closest('td').find('input.qty').val()) ;
            var total = parseInt($(this).closest('tr').find('td.total').text().replace("$", "").trim()) ;
            var price = parseInt($(this).closest('tr').find('td.price').text().replace("$", "").trim()) ;
            var newQty = qty - 1;
            if(newQty < 1){
                newQty = 1
            }

            var newTotal = qty * price;

            var sum = 0 
            $('td.total').each(function(){
                var tt = parseInt($(this).closest('tr').find('td.total').text().replace("$", "").trim()) ;
                sum += tt;
            })
            $('td.tt').text("$"+sum)

            $(this).closest('td').find('input.qty').val(newQty);
            $(this).closest('tr').find('td.total').text("$"+ newTotal);
            var qty2 = parseInt($(this).closest('td').find('input.qty').val()) ;

            

            $.ajax({
					method: "POST",
					url: "ajax/ajax_qty.php", //	k co html va chi chay ngầm
					data: {
						qty : qty2,
                        id : id

					},
					success : function(res){
						
						// ket qua ben php tra ve lai
						console.log(res)
						
						
					}
				});
        })
        $('button.delete-btn').click(function(event){
            event.preventDefault();
            var id_dl = parseInt($(this).closest('tr').find('td.id').text());
            $(this).closest('tr').remove();

            var sum = 0 
            $('td.total').each(function(){
                var tt = parseInt($(this).closest('tr').find('td.total').text().replace("$", "").trim()) ;
                sum += tt;
            })
            $('td.tt').text("$"+sum)
            $.ajax({
                method: "POST",
                url: "ajax/ajax_delete.php",
                data: {
                    id_dl : id_dl
                },
                success : function(res){
                    console.log(res);
                }
            })
        })
    })

</script>
</body>
</html>
