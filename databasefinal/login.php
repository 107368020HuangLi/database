<?php 
	include("include/test_app_top.php");
?>
<html>


	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
	<link rel="stylesheet" href="./style.css">
		<title>登入</title>
	<style>
	body{
		font-family: 'Noto Sans TC', sans-serif;
		color: #333;
	}
	.tsai-mar{
		margin: 10px;
	}
	.in{
		border: 1px solid #999;
		border-radius: 4px;
		padding: 10px 15px;
		color:#333;
	}
	.in::placeholder{
		color: #ccc;
	}
	i{
		width: 30px;
	}
	.logo-img{
		border-radius: 4px;
		width: 400px;
	}
	.wrap{
		background: #FFF;
		padding: 20px;
		border-radius: 5px;
		box-shadow: 0 3px 6px rgb(70, 66, 87);
		transition: .5s;

	}
	.wrap:hover{
		transform: translateY(-5px);
		transition: .5s;
	}
	.box{
		width: 500px;
		margin: 100px auto;
	}
	</style>
    </head>
	<body>
		<div class="container-fluid text-right">
			<button type="submit" class="btn btn-primary " style="font-size:medium;"><a href="index.php" style="color: aliceblue;">返回購物頁面</a></button>
		</div>
		<div class="box justify-content-end">
			<div class="wrap">
				<div class="text-center">  
					<div id="logo">
						<img class="logo-img" src="eCommerceAssets/images/Untitled design.png">
					</div>
					<form name="form" action="connect.php" method="post">
						<div class="form-group tsai-mar">  
							<i class="fas fa-user iconsize"></i> 
							<input class="in" name="email" type="text"  placeholder="會員帳號"/>                                
						</div>  
						<div class="form-group tsai-mar"> 		
							<i class="fas fa-key iconsize"></i> 
							<input class="in" name="password" type="password" placeholder="會員密碼" />
						</div>                    
						<input class="in" type="hidden" name="action" value="new"> 
						<button name="login" type="submit" class="btn btn-success">登入</button>
						<button name="delete" type="reset" class="btn btn-default">清除</button>
						<button type="button" class="btn btn-secondary" >
							<a href="register.php" style="color:rgb(112, 51, 51);">註冊</a>
						</button>
					</form> 
				</div>
			</div>
		</div>
		
		
	</body>
</html>