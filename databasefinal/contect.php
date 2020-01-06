<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body background="background/ADDM.jpg">

<?php 
	include("include/test_app_top.php");
	include("include/test_configure.php");
?>

<body>
	<?PHP		
		$sql_data = "SELECT * FROM member";		     // 資料表		
		$repeat = mysql_query($sql_data); 
		$row_num = mysql_num_rows($repeat);
		$fields_num = mysql_num_fields($repeat);//取得資料表欄位數
		
		for( $ars = 0 ; $ars < $row_num ; $ars++){
			$result_zero[$ars] = mysql_result($repeat,$ars);  //列印出第一列資訊
			//echo $result_zero[$ars] ;
		}
		
		echo $result_zero[$row_num-1] ;
	?> 

</body>
</html>