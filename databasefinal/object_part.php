<?PHP session_start(); 

?>
<!DOCTYPE >
<html >

<?php 
	include("include/test_app_top.php");
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC:100,300,400,500,700,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<title>商品上架</title>
</head>
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
	#inputposition{
		position: relative;
		left: 60px;
	}
	</style>
<body>
	<header>
		<div class="container-fluid">
			<p>你好 <?php echo $_SESSION["email"]?>
			<button type="submit" class="btn btn-primary"><a href="add_boss.php">增加供應商</a></button>
			<button type="submit" class="btn btn-info"><a href="all_object.php">查看全部商品</a></button>
			<button name="login" type="submit" class="btn btn-danger"><a href="logout.php?logout=1">登出</a></button>
			</p>
		</div>
    </header>
	<?PHP
    	$size =  $_POST["size"] ; 
		$obj_name =  $_POST["obj_name"] ; 
		$price =  $_POST["price"] ;  
		$color = $_POST["color"]; 
		$itemImg = $_POST["itemImg"];
	?>
	
    <?PHP		
		$sql_data = "SELECT * FROM object";		     // 資料表		
		$repeat = mysql_query($sql_data); 
		$row_num = mysql_num_rows($repeat);
		$fields_num = mysql_num_fields($repeat);//取得資料表欄位數
		
		$count = $row_num +1 ;
		$final_obj_id =  "T0$count" ;	
	?>
    	
     <?PHP		
		$sql_data2 = "SELECT * FROM boss";		     // 資料表		
		$repeat2 = mysql_query($sql_data2); 
		$row_num22 = mysql_num_rows($repeat2);
		$fields_num2 = mysql_num_fields($repeat2);//取得資料表欄位數
		
		$result = mysql_query("SELECT boss_id , boss_name FROM boss");
		$storeArray = Array();
		
		while($row =  mysql_fetch_array($result, MYSQL_ASSOC)) {
 		   $storeArray[] =  $row['boss_id'];
		   $storeArray[] =  $row['boss_name'];
		}
	?>
    

    <?PHP
    	$boss_id = $_POST["boss_id"];
    ?>
    
	<div class="Container">
        <form  class="form-group"action="" name="formAdd" id="formAdd" method="post">
　		 	<input type="hidden" name="action1" value="add_obj" />
			<p>後台管理系統</p>
			<div class="form-group-item text-center"id="inputposition" >
				<i class="fas fa-image"></i>
				<input type="file" name="itemImg" maxlength="10" placeholder="商品照片"/>
			</div>
			<div class="form-group-item text-center">
				<i class="fas fa-sort-amount-down"style="font-size:18px"></i>
				<input type="text" name="size" placeholder="商品大小"/>
			</div>
			<div class="form-group-item text-center">
				<i class="fas fa-tshirt" style="font-size:18px"></i>
				<input type="text" name="obj_name" placeholder="商品名稱"/>
			</div>
			<div class="form-group-item text-center">
				<i class="fas fa-dollar-sign" style="width: 22px;font-size:18px;"></i>
				<input type="text" name="price" placeholder="商品價格"/>
			</div>
			<div class="form-group-item text-center">
				<i class="fas fa-palette"style="font-size:18px"></i>
				<input type="text" name="color" placeholder="商品顏色"/>
			</div>
			<div class="form-group-item text-center">
				<span class="btn-group">  
					<button type="button" class="btn btn-secondary">品牌供應商:</button>	
				<select name="boss_id" class="btn btn-secondary">
					<?PHP
						 for( $i = 0 ; $i < count($storeArray) ; $i+=2 ){
					?>	
					<ul class="dropdown-menu" role="menu">
						<li><option value= <?PHP echo $storeArray[$i] ?> >  <?PHP  echo $storeArray[$i+1] ?> </option></li>
					</ul>	 
					<?PHP  
								//前傳後顯
                    	 }	
					?>
                    </select>
				　			 </span>  
				<button type="submit" name="summit" id="upload_obj" class="btn btn-dark">上架</button>
			</div> 
			</form>		
	</div>
   
     <?PHP
	 
		if ($_POST["action1"]=="add_obj"){							//新增商品
			$sql_query = "INSERT INTO object ( obj_id , obj_img , size , obj_name , obj_price , obj_color , boss_id ) VALUES ( '$final_obj_id' , '$itemImg', '$size'  , '$obj_name' , '$price' , '$color' , '$boss_id' )" ;			
			$insert_result = mysql_query($sql_query);
		//	echo $sql_query ; 
		   // echo '<meta http-equiv=REFRESH CONTENT=1;url=test1.php>';
		}
	?>
     <?PHP		
		$sql_data3 = "SELECT * FROM boss";		     // 資料表		
		$repeat3 = mysql_query($sql_data3); 
		$row_num3 = mysql_num_rows($repeat3);
		$fields_num3 = mysql_num_fields($repeat3);//取得資料表欄位數
		
		$result3 = mysql_query("SELECT boss_name FROM boss");
		$nowbossArray = Array();
		
		while($row_now_boss =  mysql_fetch_array($result3, MYSQL_ASSOC)) {
		   $nowbossArray[] =  $row_now_boss['boss_name'];
		}
	?>
    	<?PHP //object_state.php ?>
		<div class="Container text-center">
        	<form action="object_state.php" name="formNow" id="formNow" method="get">
				<span class="btn-group">  
					<button type="button" class="btn btn-secondary">目前品牌售出商品狀況:</button>	
						<select name="sell" class="btn btn-secondary" onChange="this.form.submit()" >
						<li><option value = "" ><?PHP echo 請選擇 ?> </option></li>		       			
			<?PHP
				for( $i2 = 0 ; $i2 < count($nowbossArray) ; $i2++ ){					
			?>	

			<ul class="dropdown-menu" role="menu">
				<li><option value = "<?PHP echo $nowbossArray[$i2] ?>" ><?PHP echo $nowbossArray[$i2] ?> </option></li>
	   		</ul>
			<?PHP 	 
                }	
			?>                   　			 
						</select>	            　			 
			</form>
		</div>
        <?PHP
		/* 
		for( $i3 = 0 ; $i3 < count($nowbossArray) ; $i3++ ){
			if($_POST["$nowbossArray[$i3]"]=="$nowbossArray[$i3]"){							//新增商品
				echo "d" ;
				echo $_POST["$nowbossArray[$i3]"];
				//echo '<meta http-equiv=REFRESH CONTENT=1;url=object_state.php>';
			}
		}
		*/
		?>
</body>
</html>