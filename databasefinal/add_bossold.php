<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新增供應商</title>
</head>

<?php 
	include("include/test_app_top.php");
?>

<body background="background/ADDM.jpg">
	
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
    
     <form action="" name="formAdd" id="formAdd" method="post">
   		<center>
　		 <input type="hidden" name="action1" value="add" />
 		供應商位置:	 <select name = "boss_address" > 
                		<option value="台北市"> <?PHP  echo '台北市' ?></option> 
                	    <option value="新北市"><?PHP  echo '新北市' ?> </option>
                        <option value="基隆市"> <?PHP  echo '基隆市' ?></option> 
                	    <option value="桃園市"><?PHP  echo '桃園市' ?> </option>
                        <option value="新竹市"> <?PHP  echo '新竹市' ?></option> 
                	    <option value="新竹縣"><?PHP  echo '新竹縣' ?> </option>
                        <option value="苗栗縣"> <?PHP  echo '苗栗縣' ?></option> 
                	    <option value="台中市"><?PHP  echo '台中市' ?> </option>
                        <option value="彰化縣"> <?PHP  echo '彰化縣' ?></option> 
                	    <option value="雲林縣"><?PHP  echo '雲林縣' ?> </option>
                        <option value="嘉義市"> <?PHP  echo '嘉義市' ?></option> 
                	    <option value="嘉義縣"><?PHP  echo '嘉義縣' ?> </option>
                        <option value="台南市"> <?PHP  echo '台南市' ?></option> 
                	    <option value="高雄市"><?PHP  echo '高雄市' ?> </option>
                        <option value="屏東縣"> <?PHP  echo '屏東縣' ?></option> 
                	    <option value="宜蘭縣"><?PHP  echo '宜蘭縣' ?> </option>
                        <option value="花蓮縣"> <?PHP  echo '花蓮縣' ?></option> 
                	    <option value="台東縣"><?PHP  echo '台東縣' ?> </option>
                     </select>
                     
        供應商名稱:     <input type="text" name="boss_name" />
        
　			 		<input type="submit" name="summit" id="new" value="新增供應商公司名稱"
			 		style=" width:300px; height:40px; border:2px  #000000 dashed; 		
                        	background-color:pink; font-size:20px;" />
		</center>
	</form>
   
     <?PHP
	 
		if ($_POST["action1"]=="add"){							//新增欄位
			$sql_query = "INSERT INTO boss ( boss_id , boss_address , boss_name ) VALUES ( '$final_boss_id' , '$boss_address'  , '$boss_name' )" ;			
			$insert_result = mysql_query($sql_query);
		    echo '<meta http-equiv=REFRESH CONTENT=1;url=object_part.php>';
		}	
	?>
    
     <table border="0" align="center" cellpadding="4">
			<tr>
				<td><p><a href="object_part.php">返回新增商品頁面</a><p></td>
			</tr>
	</table>
</body>
</html>