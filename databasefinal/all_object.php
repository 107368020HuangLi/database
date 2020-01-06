<!DOCTYPE >
<html >
<?php
include("include/test_app_top.php"); 	
?>

<?php 
	$dbms='mysql';     //数据库类型
	$host='localhost'; //数据库主机名
	$dbName='database_final';    //使用的数据库
	$user='root';      //数据库连接用户名
	$pass='123456789';          //对应的密码
	$dsn="$dbms:host=$host;dbname=$dbName";
	
	$dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
	$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_PERSISTENT => true));
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>全部商品</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
	<link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC:100,300,400,500,700,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<style>
body{
    background:linear-gradient(#d7d2cc,#304352);
}
body header div button{
	float: right;
	margin: 4px;
}
body div p{
	padding: 5px;
	text-align: center;
	font-size: 50px;
	font-weight: 700;
}
body div table thead tr th{
	border: 1px #000 solid;
}
body div table tbody tr td{
	border: 1px #000 solid;
}
.photosize{
	width: 225px;
	height:225px;
}		
</style>

<header>
	<div class="container-fluid">		
		<button type="submit" class="btn btn-primary " style="font-size:medium;"><a href="object_part.php" style="color: aliceblue;">返回新增商品頁面</a></button>
	</div>
</header>
<body>
	
    <?PHP
		$sqlTotal = "SELECT count(1) FROM object  ";

		$total = $db->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];
		//每頁幾筆
		$numPerPage = 5;

		// 總頁數
		$totalPages = ceil($total/$numPerPage); 

		//目前第幾頁
		$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

		//若 page 小於 1，則回傳 1
		$page = $page < 1 ? 1 : $page;
	?>
   
    
    <?PHP
		$sql_data = 'SELECT obj_id , obj_img , size , obj_name , obj_price ,obj_color FROM object ORDER BY object.obj_id ASC ';	 		
		$arrParam = [($page - 1) * $numPerPage, $numPerPage];
	    $stmt = $db->prepare($sql_data);
        $stmt->execute($arrParam);		
	?>
    
    <div class="Container">
		<p>後台管理系統</p>
    <table>
        <thead>
            <tr>
			
                <th>商品大小</th>
                <th>商品名稱</th>
                <th>商品價格</th>
                <th>商品顏色</th>
                <th>商品照片</th>
                <th>商品編輯</th>
            </tr>
        </thead>
        
        <tbody>
        <tr> 
        <?PHP        
		
        	if($stmt->rowCount() > 0) {
            	$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

            	for($i = 0 ; $i < count($arr) ; $i++) {  
        ?>
                <td><?php echo $arr[$i]['size']; ?></td>
                <td><?php echo $arr[$i]['obj_name']; ?></td>
                <td><?php echo $arr[$i]['obj_price']; ?></td>
                <td><?php echo $arr[$i]['obj_color']; ?></td>
                
                <td>
                
                <?php 
					if($arr[$i]['obj_img'] !== NULL) {
				?>
                    <img class="photosize" src="./photo/
					<?php 
						echo $arr[$i]['obj_img']; 
					?>
                    ">
                <?php 
					}
				?>
                </td>
             
				<td>
				<form action="" name="people" id="people" method="GET" enctype="multipart/form-data">
					<button type='submit' name='Submit' class="btn btn-danger" value='刪除'>刪除</button>
                    <input type='hidden' name='id' value='<?php echo $arr[$i]['obj_id']; ?>'/>
                </form>
                </td>
            </tr>
                <?PHP
				}
			} 
				
			else {
     	?>
        	    <tr>
            	    <td>沒有資料</td>
            	</tr>
        	<?php
        		}
        	?>
        </tbody>
        
        <tfoot>
            <tr>
                <td class="border" colspan="5">
                <?php for($i = 1; $i <= $totalPages; $i++){ ?>
                    <a href="?page=<?= $i ?>"><?= $i ?></a>                   
                <?php } ?>
                </td>
            </tr>
        </tfoot>
    </table>
	</div>
    
	<?PHP
	$id =!empty($_GET["id"])?$_GET["id"] :"" ;	
	$Submit = !empty($_GET["Submit"]) ? $_GET["Submit"] : null ;
		
    	if($Submit == "刪除"){
			$sqaa ="DELETE FROM object WHERE obj_id='$id'";
			mysql_query($sqaa) or die('SQL執行有誤');		
			echo '<meta http-equiv=REFRESH CONTENT=1;url=all_object.php>';    //跳至編輯頁
		}
	
    ?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>