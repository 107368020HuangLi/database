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

<?PHP
	 	$the_size =  $_GET["the_size"] ; 
		$the_price_low = $_GET["the_price_low"] ;
		$the_price_high = $_GET["the_price_high"] ;
		$the_name = $_GET["the_name"];
		$the_color = $_GET["the_color"];
		
		$the_boss = $_GET["the_boss"];
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>天天購物</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="eCommerceAssets/styles/eCommerceStyle.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/montserrat:n4:default;source-sans-pro:n2:default.js" type="text/javascript"></script>
</head>
<body>
<div id="mainWrapper">
    <div id="logo"> <img src="eCommerceAssets/images/Untitled design.png" > </div>
    <div id="headerLinks"><a href="login.php" title="Login/Register">Login | 登入會員</a>
      <a href="#" title="Cart"><i class="fas fa-receipt" style="color: #FFAC55; position: relative; right: 30px;">購買紀錄</i></a> 
    </div> 
  
  
  <div id="topbanner">
   <img src="eCommerceAssets/images/Web banner1.png">
  </div>
  
  <div id="content">
    <section class="sidebar"> 
      <div id="menubar">
        <nav class="menu">
        <p style="font-size: large;">商品查詢<i class="fas fa-search iconsize1"></i></p>
          <hr>
          <form action=""  name="formAdd" id="formAdd"   method="get"  enctype="multipart/form-data" >
              <input type="hidden" name="search" value="aa" />            
              <i class="fas fa-sort-amount-down inputpositon"style="font-size:18px">
              <input  type="text" name="the_size" size="15" placeholder="商品大小" /></i>
              <i class="fas fa-funnel-dollar inputpositon ">
              <input  type="text" name="the_price_low" size="15" placeholder="價格下限"/></i>
              <i class="fas fa-funnel-dollar inputpositon">
              <input  type="text" name="the_price_high" size="15" placeholder="價格上限"/></i>
              <i class="fas fa-tshirt inputpositon " style="font-size:18px">
              <input  type="text" name="the_name" size="15" placeholder="商品名稱"/></i>
              <i class="fas fa-palette inputpositon"style="font-size:18px">
              <input  type="text" name="the_color"  size="15" placeholder="商品顏色"/></i>
              <i class="far fa-building inputpositon"style="font-size:18px"> 			
              <input  type="text" name="the_boss" size="15" placeholder="品牌"/></i><br>
              <button type="submit" name="sub_query" id="sub_query"><i class="fas fa-search-plus" >尋找</i></button> 
            </form>
        </nav>
      </div>
    </section>
    
  	 <section class="mainContent">
   
   
    <?php
        //SQL 敘述
		if($the_price_low != '' && $the_price_high != ''){
        	$sql = "SELECT * FROM object JOIN boss ON object.boss_id = boss.boss_id WHERE size LIKE '$the_size%' AND 
														 obj_price >= $the_price_low AND obj_price <= $the_price_high AND
														 obj_name LIKE '%$the_name%' AND
														 obj_color LIKE '%$the_color%' AND
														 boss.boss_name LIKE '%$the_boss%' ORDER BY obj_id ASC ";
		//	echo $sql;	
		}
		
		elseif($the_price_low == '' && $the_price_high != ''){
        	$sql = "SELECT * FROM object JOIN boss ON object.boss_id = boss.boss_id WHERE size LIKE '$the_size%' AND 
														 obj_price <= $the_price_high AND
														 obj_name LIKE '%$the_name%' AND
														 obj_color LIKE '%$the_color%' AND
														 boss.boss_name LIKE '%$the_boss%' ORDER BY obj_id ASC ";
			//echo $sql;	
		}
		
		elseif($the_price_low != '' && $the_price_high == ''){
        	$sql = "SELECT * FROM object JOIN boss ON object.boss_id = boss.boss_id WHERE size LIKE '$the_size%' AND 
														 obj_price >= $the_price_low AND
														 obj_name LIKE '%$the_name%' AND
														 obj_color LIKE '%$the_color%' AND
														 boss.boss_name LIKE '%$the_boss%' ORDER BY obj_id ASC ";		
			//echo $sql;	
		}
		
		elseif($the_price_low == '' && $the_price_high == ''){
        	$sql = "SELECT * FROM object JOIN boss ON object.boss_id = boss.boss_id WHERE size LIKE '$the_size%' AND 
														 obj_name LIKE '%$the_name%' AND
														 obj_color LIKE '%$the_color%' AND
														 boss.boss_name LIKE '%$the_boss%' ORDER BY obj_id ASC ";		
			//echo $sql;	
		}
		
		
		
        //設定繫結值
        $arrParam = [($page - 1) * $numPerPage, $numPerPage];

        //查詢分頁後的學生資料
        $stmt = $db->prepare($sql);
        $stmt->execute($arrParam);

        //資料數量大於 0，則列出所有資料
        if($stmt->rowCount() > 0) {
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            for($i = 0; $i < count($arr); $i++) {
        ?>
      <div class="productRow">
          <div id='productphoto'>
          	<img alt="sample" src="./photo/<?php echo $arr[$i]['obj_img']; ?>">
          </div>
          
          <p class="price"><?php echo $arr[$i]['size']; ?></p>
          <p class="price">$<?php echo $arr[$i]['obj_price']; ?></p>
          <p class="productName"><?php echo $arr[$i]['obj_name']; ?></p>
          <p class="productName"><?php echo $arr[$i]['obj_color']; ?></p>
          <form action="#" name="form_buy" id="form_buy" method="get" enctype="multipart/form-data">
          <input type="checkbox"  name= "<?PHP echo $arr[$i]['obj_id'] ?>" value="<?PHP echo $arr[$i]['obj_id'] ?>" class="buyButton">
      </div>
      <?php
           }
    }?>   <button type="submit" name="buy_object" class="buttonposition1" ><i class="fas fa-shopping-cart">
    購買</i></button>
    </section>
  </div>
       
        
 	<footer> 
    <div>
      <p>天天購物的宗旨，價格親民。</p>
    </div>
    <div >
      <p style="color: black; font-size:18px;">Develop By 
        <i class="fab fa-html5 iconsize2" style="color: coral;"></i>
        <i class="fab fa-css3-alt iconsize2" style="color: #0277bd ;"></i>
        <i class="fab fa-js iconsize2" style="color: darkorange;"></i>
        <i class="fab fa-php iconsize2"style="color: cornflowerblue;"></i></p>
    </div>
    <div class="footerlinks">
      <p><a href="#" title="Link">關於我們</a></p>
      <p><a href="#" title="Link">聯絡我們</a></p>
      <p><a href="#" title="Link">客服中心</a></p>
    </div>
  </footer>
 
 </div>   
</body>
</html>