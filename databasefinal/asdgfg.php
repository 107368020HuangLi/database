<?php include("include/test_app_top.php"); ?>
<?php

//SQL 敘述: 取得 students 資料表總筆數
$sqlTotal = "SELECT count(1) FROM `item`";




//每頁幾筆
$numPerPage = 9;

// 總頁數
$totalPages = ceil($total/$numPerPage); 

//目前第幾頁
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

//若 page 小於 1，則回傳 1
$page = $page < 1 ? 1 : $page;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>天天購物</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="eCommerceAssets/styles/eCommerceStyle.css" rel="stylesheet" type="text/css">
<script>var __adobewebfontsappname__="dreamweaver"</script><script src="http://use.edgefonts.net/montserrat:n4:default;source-sans-pro:n2:default.js" type="text/javascript"></script>
</head>
<body>
<div id="mainWrapper">
  <header> 
    <!-- This is the header content. It contains Logo and links -->
    <div id="logo"> <img src="eCommerceAssets/images/Untitled design.png" > 
      <!-- Company Logo text --> 
    </div>
    <div id="headerLinks"><a href="./logout.php?logout=1" title="Logout/Register">Logout | 你好 <?php echo $_SESSION['username']?></a><a href="#" title="Cart">Cart</a></div>
  </header>
  <div id="topbanner"> <img src="eCommerceAssets/images/Web banner1.png">
  </div>
  <div id="content">
    <section class="sidebar"> 
      <!-- This adds a sidebar with 1 searchbox,2 menusets, each with 4 links -->
      <input type="text"  id="search" value="search">
      <div id="menubar">
        <nav class="menu">
          <h2><!-- Title for menuset 1 -->MENU </h2>
          <hr>
          <ul>
            <!-- List of links under menuset 1 -->
            <li><a href="#" title="Link">衣服</a></li>
            <li><a href="#" title="Link">鞋子</a></li>
            <li><a href="#" title="Link">配件</a></li>
          </ul>
        </nav>
      </div>
    </section>
    
    <section class="mainContent">
    <?php
        //SQL 敘述
        $sql = "SELECT `id`, `itemName`, `itemprice`,`itemImg`
                FROM `item` 
                ORDER BY `id` ASC 
                LIMIT ?, ? ";

        //設定繫結值
       // $arrParam = [($page - 1) * $numPerPage, $numPerPage];

        //查詢分頁後的學生資料
        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);

        //資料數量大於 0，則列出所有資料
        if($stmt->rowCount() > 0) {
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            for($i = 0; $i < count($arr); $i++) {
        ?>
      <div class="productRow"><!-- Each product row contains info of 3 elements -->
          <div id='productphoto'><img alt="sample" src="./photo/<?php echo $arr[$i]['itemImg']; ?>"></div>
          <p class="price">$<?php echo $arr[$i]['itemprice']; ?></p>
          <p class="productName"><?php echo $arr[$i]['itemName']; ?></p>
          <input type="button" name="button" value="加入購物車" class="buyButton">
      </div>
      <?php
            } }?>
    </section>
  </div>
  <footer> 
    <!-- This is the footer with default 3 divs -->
    <div>
      <p>天天購物的宗旨，價格親民。</p>
    </div>
    <div>
      <p>CEO Ethen Tseng </p>
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