<?PHP session_start(); ?>
<!DOCTYPE >
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC:100,300,400,500,700,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<?php 
	include("include/test_app_top.php");
?>

<title>商品狀態</title>
</head>
<style>
body{
    background:linear-gradient(#d7d2cc,#304352);
}
body header div p{
	font-weight: 600;
	font-size: 20px;
	font-family: 'Noto Sans TC', sans-serif;
}
body header div button{
	float: right;
	margin: 4px;
}
body header div button a{
	color: aliceblue;
}
body table{
	background: bisque;
	text-align: center;
	margin-left:auto; 
	margin-right:auto;
	
}
body div table  tr {
	border: 1px #000 solid;
}
body div table  tr th{
	border: 1px #000 solid;
	width:10%;
}
body div table  tr td{
	border: 1px #000 solid;
}
.phare{
	padding: 5px;
	text-align: center;
	font-size: 50px;
	font-weight: 700;
}
</style>
<body>
<header>
	<div class="container-fluid">
		<p>你好 <?php echo $_SESSION["email"]?>
		<button type="submit" class="btn btn-primary"><a href="add_boss.php">增加供應商</a></button>
		<button type="submit" class="btn btn-info"><a href="all_object.php">查看全部商品</a></button>
		<button name="login" type="submit" class="btn btn-danger"><a href="login.php">登出</a></button>
		</p>
	</div>
</header>
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
    
	<?PHP 
	$get_what_boss =  $_GET["sell"];
	
				$sql_query = "SELECT obj_number,obj_name,obj_price,size,obj_color,boss_name,buy_name,orders_time FROM `order_conect` JOIN object ON order_conect.obj_id = object.obj_id JOIN boss ON object.boss_id = boss.boss_id JOIN orders ON order_conect.ords_id = orders.ords_id WHERE boss_name = '$get_what_boss' " ;
			
				echo $sql_query;
				$repeat_query = mysql_query($sql_query); 
				$row_query = mysql_num_rows($repeat_query);
				$fields_query = mysql_num_fields($repeat_query);//取得資料表欄位數
			
		
	?>
    <div class="Container">
    	<table>
			<p class="phare">後台管理系統</p>
 			 <tr>
             	<th>商品數量</th>
                <th>商品名稱</th>
            	<th>商品價錢</th>
                <th>商品大小</th>
    			<th>商品顏色</th>
                <th>供應商</th>
                <th>購買人姓名</th> 
                <th>購買時間</th>                
			 </tr>
		<?PHP
		
		for($ax = 0 ; $ax <= $row_query ; $ax++ ){
			@$row_query = mysql_fetch_row($repeat_query);			
		?>
			<tr>
                <td><?PHP echo "$row_query[0]"; ?> </td>   		<?PHP //編號 ?>
                <td><?PHP echo "$row_query[1]"; ?> </td>   		
		    	<td><?PHP echo "$row_query[2]"; ?> </td>
                <td><?PHP echo "$row_query[3]"; ?> </td>
                <td><?PHP echo "$row_query[4]"; ?> </td>
                <td><?PHP echo "$row_query[5]"; ?> </td>
                <td><?PHP echo "$row_query[6]"; ?> </td>
                <td><?PHP echo "$row_query[7]"; ?> </td>
        	</tr> 
		<?PHP	
		}
	  	?> 
      </table> 
	</div>
</body>
</html>