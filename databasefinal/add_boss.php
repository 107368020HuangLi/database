<!DOCTYPE html PUBLIC >
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC:100,300,400,500,700,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<title>新增供應商</title>
</head>

<?php 
	include("include/test_app_top.php");
?>
<style>
body{
    background:linear-gradient(#d7d2cc,#304352);
}
body header div button{
	float: right;
	margin: 4px;
}
body header div button a{
	color: aliceblue;
}
body header div p{
	font-weight: 600;
	font-size: 20px;
	font-family: 'Noto Sans TC', sans-serif;
}
body div form{
	padding: 5px;
}
body div form p{
	padding: 5px;
	text-align: center;
	font-size: 50px;
	font-weight: 700;	
}
body div form input{
	margin: 6px;
	}
</style>
<body>
	<header>
		<div class="container-fluid">
			<p>你好 <?php echo $_SESSION["email"]?>
			<button type="submit" class="btn btn-primary"><a href="add_boss.php">增加供應商</a></button>
			<button type="submit" class="btn btn-info"><a href="all_object.php">查看全部商品</a></button>
			<button name="login" type="submit" class="btn btn-danger"><a href="logout.php?logout=1">登出</a></button>
			<button type="submit" class="btn btn-primary"><a href="object_part.php">返回新增商品頁面</a></button>
			</p>
		</div>
    </header>
    <?PHP
    	$boss_address =  $_POST["boss_address"] ; 
		$boss_name =  $_POST["boss_name"] ; 
	?>
    
	 <?PHP		
		$sql_data = "SELECT * FROM boss";		     // 資料表		
		$repeat = mysql_query($sql_data); 
		$row_num = mysql_num_rows($repeat);
		$fields_num = mysql_num_fields($repeat);//取得資料表欄位數
		
		for( $ars = 0 ; $ars < $row_num ; $ars++){
			$result_zero[$ars] = mysql_result($repeat,$ars);  //列印出第一列資訊
		}
		$count = $row_num +1 ;
		$final_boss_id =  "B0$count" ;	
	?>
    <div class="Container text-center">
     <form  class="form-group" action="" name="formAdd" id="formAdd" method="post">
		<p>後台管理系統</p>
　		 <input type="hidden" name="action1" value="add" />
		<div class="form-group-item text-center">
			<span class="btn-group">  
			<button type="button" class="btn btn-secondary">供應商位置:</button>
 			 <select name = "boss_address" class="btn btn-secondary" >
				<ul class="dropdown-menu" role="menu"> 
                	<li><option value="台北市"> <?PHP  echo '台北市' ?></option></li> 
					<li><option value="新北市"><?PHP  echo '新北市' ?> </option></li>
					<li><option value="基隆市"> <?PHP  echo '基隆市' ?></option></li>
					<li><option value="桃園市"><?PHP  echo '桃園市' ?> </option></li>
					<li><option value="新竹市"> <?PHP  echo '新竹市' ?></option></li>
					<li><option value="新竹縣"><?PHP  echo '新竹縣' ?> </option></li>
					<li><option value="苗栗縣"> <?PHP  echo '苗栗縣' ?></option></li> 
					<li><option value="台中市"><?PHP  echo '台中市' ?> </option></li>
					<li><option value="彰化縣"> <?PHP  echo '彰化縣' ?></option></li>
					<li><option value="雲林縣"><?PHP  echo '雲林縣' ?> </option></li>
					<li><option value="嘉義市"> <?PHP  echo '嘉義市' ?></option></li>
					<li><option value="嘉義縣"><?PHP  echo '嘉義縣' ?> </option></li>
					<li><option value="台南市"> <?PHP  echo '台南市' ?></option></li>
					<li><option value="高雄市"><?PHP  echo '高雄市' ?> </option></li>
					<li><option value="屏東縣"> <?PHP  echo '屏東縣' ?></option></li>
					<li><option value="宜蘭縣"><?PHP  echo '宜蘭縣' ?> </option></li>
					<li><option value="花蓮縣"> <?PHP  echo '花蓮縣' ?></option></li>
					<li><option value="台東縣"><?PHP  echo '台東縣' ?> </option></li>
					</ul>
             </select>
			</span>
		</div>
		<i class="far fa-building inputpositon"style="font-size:18px">          
        <input type="text" name="boss_name" placeholder="供應商名稱" size="12"/></i><br>
		<button type="submit" name="summit" id="new" class="btn btn-dark">新增供應商公司名稱</button>
	</form>
   </div>
     <?PHP
	 
		if ($_POST["action1"]=="add"){							//新增欄位
			$sql_query = "INSERT INTO boss ( boss_id , boss_address , boss_name ) VALUES ( '$final_boss_id' , '$boss_address'  , '$boss_name' )" ;			
			$insert_result = mysql_query($sql_query);
		    echo '<meta http-equiv=REFRESH CONTENT=1;url=object_part.php>';
		}	
	?>
</body>
</html>