<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Box with Header</title>
    <link rel="stylesheet" href="css/form.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body{
            height: 100%;
            margin: 0; /* Loại bỏ margin mặc định */
            padding: 0; /* Loại bỏ padding mặc định nếu có */
            font-family: Arial, sans-serif;
            background-image: url('img/bkgroud.jpg'); /* Đảm bảo đường dẫn chính xác */
            background-color: rgba(0, 0, 0, 0); /* Đảm bảo màu nền không ảnh hưởng */
            background-size: cover; /* Đảm bảo hình nền phủ toàn bộ trang */
            background-position: center; /* Căn giữa hình nền */
            background-repeat: no-repeat; /* Ngăn hình nền lặp lại */
            border: none; /* Loại bỏ bất kỳ đường viền nào nếu có */
            overflow: hidden; /* Ngăn hiện tượng cuộn có thể làm lộ đường viền */


        }
        
       
    </style>
</head>
<body>
    
    <div class="container" id="register-container">
       
        <div class="chat-box">
        <h1 >Register</h1><br>

            <div class="form-container">
                <form action="index.php">
                    <label for="reg-username">User Name</label>
                    <input type="text" id="reg-username" name="username" placeholder="User name">
                    <p class="err1"></p>
                    <label for="reg-email">Email</label>
                    <input type="text" id="reg-email" name="email" placeholder="Your email">
                    <p class="err2"></p>
                    
                    <label for="reg-password">Password</label>
                    <input type="text" id="reg-password" name="password" placeholder="Password"><br>
                    <p class="err3"></p>
                    <label for="level">Select User Level:</label>
    <select name="level" id="level">
        <option value="1">Member</option>
        <option value="0">Admin</option>
    </select>
                <div class="center-buttons">
                    <button type="submit" id="register-button">Register</button>
                    <button type="button"  id="register_login-button">Login</button>
                </div>


                </form>

            </div>
        </div>
    </div>

    <div class="container hidden" id="login-container">

        <div class="chat-box">
        <h1 >Login</h1><br>

            <div class="form-container">
                <form action="" method="post">
                <label for="login-username">User Name</label>
                <input type="text" id="login-username" name="username" placeholder="User Name">
                <p class="err1"><?php ?></p>
                <!-- <label for="login-email">Email</label>
                <input type="text" id="login-email" name="email" placeholder="Your email"> -->
                <label for="login-password">Password</label>
                <input type="text" id="login-password" name="password" placeholder="Password"><br>
                <p class="err3"></p>
                <div class="center-buttons">
                <button type="submit" name="login"  id="login_sucess-button">Login</button>
                <button type="button" id="login_register-button">Register</button>
                </div>


                </form>

            </div>
        </div>
    </div>

    <script>

        $(document).ready(function(){
            // register
            $('button#register-button').click(function(event){
                event.preventDefault();
                var getName = $("input#reg-username").val();
                var getEmail = $("input#reg-email").val();
                var getPass = $("input#reg-password").val();
                var checkBok = $('select').val();
                console.log(checkBok);
                var x = 1;
                if(getName == ""){
                    $('p.err1').text("Vui long nhap name");
                    var x = 2;
                }else{
                    $('p.err1').text("");
                }
                if(getEmail == ""){
                    $('p.err2').text("Vui long nhap Email");
                    var x = 2;

                }else{
                    $('p.err2').text("");
                }
                if(getPass == ""){
                    $('p.err3').text("Vui long nhap Pass");
                    var x = 2;

                }else{
                    $('p.err3').text("");
                }
                if(x == 1){
                    $("div#login-container").show();
                    $("div#register-container").hide();
                    var user = {
                        username: getName,
                        email: getEmail,
                        pass: getPass,
                        level: checkBok
                    };

                    console.log(user);
                    $.ajax({
					method: "POST",
					url: "ajax/ajax_register.php", //	k co html va chi chay ngầm
					data: {
						user : user

					},
					success : function(res){
						
						// ket qua ben php tra ve lai
						console.log(res)

                        
						
					}
				    });
                }
            })
            //chuyển form
            $("button#register_login-button").click(function(event){
                event.preventDefault();
                $("div#login-container").show();
                $("div#register-container").hide();
            })
            $("button#login_sucess-button").click(function(event){
                event.preventDefault();
                var getName = $('input#login-username').val();
                var getPass = $('input#login-password').val();
                // console.log("Login Details - Username:", getName, "Password:", getPass);
                var x = 1;
                if(getName == ""){
                    $('p.err1').text("Vui long nhap name");
                    var x = 2;
                }else{
                    $('p.err1').text("");
                }
                if(getPass == ""){
                    $('p.err3').text("Vui long nhap Pass");
                    var x = 2;

                }else{
                    $('p.err3').text("");
                }
                if(x == 1){
                    var login = {
                        username: getName,
                        pass: getPass
                    };

                    console.log(login);
                    $.ajax({
					method: "POST",
					url: "ajax/ajax_login.php", //	k co html va chi chay ngầm
					data: {
						login : login

					},
					success : function(res){
						
						// ket qua ben php tra ve lai
						console.log(res)
                        if(res == 1){
                                $("form").attr("action", "admin.php");
                                $("form").submit();
                            }else if(res == 2){
                                $("form").attr("action", "index.php");
                                $("form").submit();
                            }
                            
                            else{
                                false
                            }
						
					}
				    });
                }
            })
            $("button#login_register-button").click(function(event){
                event.preventDefault();
                $("div#login-container").hide();
                $("div#register-container").show();
            })
            
        })

    </script>

</body>
</html>
