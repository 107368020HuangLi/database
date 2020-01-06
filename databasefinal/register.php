<!DOCTYPE >
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC:100,300,400,500,700,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="./style.css">
<title>註冊頁面</title>
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
<?php 
	include("include/test_app_top.php");
	include("include/test_configure.php");
?>
        
    <?PHP
    	$email =  $_POST["email"] ; 
		$password =  $_POST["password"] ; 
		$phone =  $_POST["phone"] ; 
		$member_type =  $_POST["member_type"] ;  
	?>
    
    <?PHP		
		$sql_data = "SELECT * FROM member";		     // 資料表		
		$repeat = mysql_query($sql_data); 
		$row_num = mysql_num_rows($repeat);
		$fields_num = mysql_num_fields($repeat);//取得資料表欄位數
		
		for( $ars = 0 ; $ars < $row_num ; $ars++){
			$result_zero[$ars] = mysql_result($repeat,$ars);  //列印出第一列資訊
		}
		$count = $row_num +1 ;
		$final_id =  "M0$count" ;		
	?>
	<body>
    <div class=" text-center ">
		
			<div class="box formposition ">
				<div class="wrap">
					<img class="logo-img" src="eCommerceAssets/images/Untitled design.png" title="天天購物LOGO">
					<h3>天天購物會員註冊</h3>
					<form action="" name="formAdd" id="formAdd" method="post">
						<div class="tsai-mar">
					　		 <input class="in" type="hidden" name="action1" value="add" />
							<div class="tsai-mar">
								<i class="fas fa-user iconsize"></i>
								<input class="in" type="text" name="email" placeholder="帳號" />
							</div>
							<div class="tsai-mar">
								<i class="fas fa-key iconsize"></i> 
								<input class="in" type="password" name="password" placeholder="密碼" />
							</div>
							<div class="tsai-mar">   
								<i class="fas fa-phone iconsize"></i>   
								<input class="in" type="text" name="phone" placeholder="電話號碼"/>
							</div>
							<div class="tsai-mar">
								<span class="btn-group">
								<button type="button" class="btn btn-info">使用者類別</button>
								<select name="member_type" class="btn btn-info btnsize" >
									<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><option value= "A" >  <?PHP  echo "供應商" ?> </option></li>
										<li><option value= "N" >  <?PHP  echo "一般會員" ?> </option></li>
									</ul>	       
								</select>
								</span>
							</div>
						</div>
						<br>
				　		<button type="submit"  name="summit" id="new" class="btn btn-success">確認</button>
						<button type="button" class="btn btn-secondary" >
							<a href="login.php" style="color:rgb(112, 51, 51);">返回登入頁面</a>
						</button>
					</form>
				</div>
				
			</div>
		
		
    </div>
     <?PHP
	 
		if ($_POST["action1"]=="add"){							//新增欄位
			$sql_query = "INSERT INTO member ( mem_id , email , password , member_type , phone ) VALUES ( '$final_id' , '$email'  , '$password' , '$member_type' , '$phone' )" ;			
			$insert_result = mysql_query($sql_query);
		    echo '<meta http-equiv=REFRESH CONTENT=2;url=login.php>';}?>
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	</body>
</html>