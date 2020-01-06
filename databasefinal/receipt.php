<?PHP session_start(); ?>
<!DOCTYPE >
<html>
<?php
include("include/test_app_top.php"); 	
?>
<head>
<title>購買紀錄</title>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC:100,300,400,500,700,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<style>

body{
    background:linear-gradient(#d7d2cc,#304352);
}
.phase{
    font-size: 20px;
    font-weight:800;
}
body table{
	border: 1px #000 solid;
	background:#ffcdd2 ;
}
body table tr th{
	width: 20%;
	border: 1px #000 solid;	
}
body table tr th td{
	width: 20%;
	border: 1px #000 solid;	
}
</style>
<body>
<?php 
	$dbms='mysql';     //数据库类型
	$host='localhost'; //数据库主机名
	$dbName='database_final';    //使用的数据库
	$user='root';      //数据库连接用户名
	$pass='123456789';          //对应的密码
	$dsn="$dbms:host=$host;dbname=$dbName";
	
	$dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
	$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_PERSISTENT => true));
	$db2 = new PDO($dsn, $user, $pass, array(PDO::ATTR_PERSISTENT => true));
?>
	<?PHP
		$the_buy_email = $_SESSION["email"];
	?>
  <?php //echo $_SESSION["email"]."<br>"?>
  <?PHP // echo $the_buy_email."<br>" ?>
  
 <?PHP

$sqlTotal = "SELECT count(1) FROM object";

//取得總筆數
$total = $db->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];

//每頁幾筆
$numPerPage = 9;

// 總頁數
$totalPages = ceil($total/$numPerPage); 

//目前第幾頁
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

//若 page 小於 1，則回傳 1
$page = $page < 1 ? 1 : $page;
?>
<?php
        //SQL 敘述
		$sql = "SELECT * FROM object ORDER BY obj_id ASC ";
		//$sql2 = "SELECT * FROM object WHERE obj_id = 'T01' OR obj_id = 'T02' ORDER BY obj_id ASC ";			

        //查詢分頁後的學生資料
        $stmt = $db->prepare($sql);
		$stmt->execute($arrParam);
		$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);	    

		for($x = 0; $x < count($arr); $x++) {
			if(isset($_GET[$arr[$x]['obj_id']])){
				$new_GET[$x] = " obj_id = "."'".$_GET[$arr[$x]['obj_id']]."'" ;
			}
		}
		@$the_new_GET = implode(" OR ",$new_GET);
		
		//echo $sql2;
  ?>  
	  <?PHP
      //	echo $buy_name;
	//	echo $buy_address;
	//	echo $buy_phone;
	  ?>
      
      <?PHP
	  	for($numx = 0 ; $numx < count($arr2)  ; $numx++){
			$zzz[$numx] =!empty($_POST["$numx"]) ? $_POST["$numx"] : "" ;
		}
			 		
		 if($_POST["action_com"]=="com_obj"){
			$sql_query_insert_orders = "INSERT INTO  orders ( ords_id , buy_name , buy_address , buy_phone , mem_id ) VALUES ( '$final_orders_id' , '$buy_name' , '$buy_address' , '$buy_phone', '$row_member[0]' )" ;
			mysql_query($sql_query_insert_orders);
			
			for($numx2 = 0 ; $numx2 < count($arr2)  ; $numx2++){
				$the_buy_num[$numx2] = $_POST["$numx2"];	
				
				$sql_order_conect[$numx2] = "SELECT * FROM order_conect";		     //  給訂單明細編號		
				$repeat_order_conect[$numx2] = mysql_query($sql_order_conect[$numx2]); 
				$row_num_order_conect[$numx2] = mysql_num_rows($repeat_order_conect[$numx2]);
				//echo $row_num_order_conect[$numx2]."<br>";
				$count_order_conect[$numx2] = $row_num_order_conect[$numx2] + 1 ;
				$final_order_conect_id[$numx2] =  "C0$count_order_conect[$numx2]" ;	
				
				//echo $arr2[$numx2]['obj_id']."<br>";
				$buy_obj_final_id[$numx2] = $arr2[$numx2]['obj_id'];              //給obj編號
				
				//echo $buy_obj_final_id[$numx2]."<br>";
				//echo $the_buy_num[$numx2];
				$sql_query_insert_order_conect_id[$numx2] = "INSERT INTO  order_conect ( obj_number , obj_id , ords_id ) VALUES ( '$the_buy_num[$numx2]' , '$buy_obj_final_id[$numx2]' , '$final_orders_id' ) " ;
				//echo $sql_query_insert_order_conect_id[$numx2]."<br>";
				mysql_query($sql_query_insert_order_conect_id[$numx2]); 
			 }
		}
      ?>
      
      <?PHP		  
	  	$sql_final_price = "SELECT * FROM order_conect JOIN object ON order_conect.obj_id = object.obj_id JOIN orders ON order_conect.ords_id = orders.ords_id JOIN member ON orders.mem_id = member.mem_id AND member.email = '$the_buy_email' " ; 
		$repeat_sql_final_price = mysql_query($sql_final_price); 
		//$row_sql_final_price = mysql_fetch_row($repeat_sql_final_price);      // 取陣列第0項
		$price_num = mysql_num_rows($repeat_sql_final_price);
		?>
	<?PHP 
	  	$sql_orders = "SELECT * FROM orders";		     //  給訂單編號		
		$repeat_orders = mysql_query($sql_orders); 
		$row_num_orders = mysql_num_rows($repeat_orders);
		
		$count_orders = $row_num_orders + 1 ;
		$final_orders_id =  "O0$count_orders" ;	
	//	echo $count_orders;
	//	echo $final_orders_id;
	  ?>
	<?PHP		
	   									
		$sql_member = "SELECT mem_id FROM member WHERE email = '$the_buy_email' " ;  //找誰訂的
		$repeat_member = mysql_query($sql_member); 
		$row_member = mysql_fetch_row($repeat_member);      // 取陣列第0項
		//echo $row_member[0] ;
		?>
									   
									   
	<?PHP
		$buy_name =  $_POST["buy_name"] ; 
		$buy_address = $_POST["buy_address"] ;
		$buy_phone = $_POST["buy_phone"] ;
	?>
    <div class="container-fluid text-right">
		<button type="submit" class="btn btn-primary " style="font-size:medium;"><a href="obj.php" style="color: aliceblue;">返回購物頁面</a></button>
	</div>
	<table class="Container text-center">
 		<tr>
            <p class="phase text-center"><?php echo $_SESSION["email"]?>的購買紀錄</p>
            <th>商品名稱</th>
            <th>價錢</th>
			<th>數量</th>
            <th>單品總價</th>
			<th>下訂時間</th>
		</tr>
		<?PHP
		
		for($ax = 1 ; $ax <= $price_num ; $ax++ ){
			$row_price = mysql_fetch_row($repeat_sql_final_price);			
		?>
			<tr>
                <td><?PHP echo "$row_price[7]"; ?> </td>   		<?PHP //編號 ?>
		    	<td><?PHP echo "$row_price[8]"; ?> </td>
                <td><?PHP echo "$row_price[1]"; ?> </td>
                <td><?PHP echo $row_price[8] * $row_price[1]; ?> </td>
                <td><?PHP echo "$row_price[15]";?></td> 
        	</tr> 
		<?PHP	
		}
	  	?> 
      </table>
</body>
</html>