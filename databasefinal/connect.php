<?php session_start(); ?>
<?php include("include/test_app_top.php"); ?>
<!--上方語法為啟用session，此語法要放在網頁最前方-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//連接資料庫
//只要此頁面上有用到連接MySQL就要include它
$email = $_POST["email"];
$pwd = $_POST["password"];
$member_type =  $_POST["member_type"] ; 

//搜尋資料庫資料

	if(  ( $email == "" ) ||  ( $pwd == ""  )  ){
		echo '登入失敗! 帳密不可為空值';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=test1.php>';
	}
	
$sql = "SELECT * FROM member where email = '$email'";

$result = mysql_query($sql);

$row = mysql_fetch_array($result) or die(mysql_error());  //


//判斷帳號與密碼是否為空白
//以及MySQL資料庫裡是否有這個會員
	if( $email != '' && $pwd != '' && $row[1] == $email && $row[2] == $pwd && $row[3] == 'A' ){
        //將帳號寫入session，身份:管理(供應)
        $_SESSION['email'] = $email;
        echo '登入成功!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=object_part.php>';
	}
	
	elseif( $email != '' && $pwd != '' && $row[1] == $email && $row[2] == $pwd && $row[3] == 'N' ){
        //將帳號寫入session，身份:一般
        $_SESSION['email'] = $email;
        echo '登入成功!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=obj.php>';
	}
	
	
	else {
        echo '登入失敗!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=test1.php>';
	}
	
?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
</head>

<body>
</body>
</html>