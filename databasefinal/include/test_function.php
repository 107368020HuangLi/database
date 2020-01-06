<?php
  function tep_db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE, $link = 'db_link') {
    global $$link;

    if (USE_PCONNECT == 'true') {
      $$link = mysql_pconnect($server, $username, $password);
    } else {
      $$link = mysql_connect($server, $username, $password);
    }

    if ($$link) mysql_select_db($database);

    return $$link;
  }
  
  function tep_db_query($query, $link = 'db_link') {
    global $$link;

    if (defined('STORE_DB_TRANSACTIONS') && (STORE_DB_TRANSACTIONS == 'true')) {
      error_log('QUERY ' . $query . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }

    $result = mysql_query($query, $$link) or tep_db_error($query, mysql_errno(), mysql_error());

    if (defined('STORE_DB_TRANSACTIONS') && (STORE_DB_TRANSACTIONS == 'true')) {
       $result_error = mysql_error();
       error_log('RESULT ' . $result . ' ' . $result_error . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }

    return $result;
  }
  
  function tep_db_fetch_array($db_query) {
    return mysql_fetch_array($db_query, MYSQL_ASSOC);
  }
  
  function tep_db_error($query, $errno, $error) { 
    die('<font color="#000000"><b>' . $errno . ' - ' . $error . '<br><br>' . $query . '<br><br><small><font color="#ff0000">[TEP STOP]</font></small><br><br></b></font>');
  }
  
  function tep_db_insert_id() {
    return mysql_insert_id();
  }
  
  function tep_db_data_seek($db_query, $num){
	return mysql_data_seek($db_query, $num);
  }
  
  function tep_db_num_rows($db_query){
	return mysql_num_rows($db_query);
  }
  
  function tep_encrypt_password($plain) {
    $password = '';

    for ($i=0; $i<10; $i++) {
      $password .= tep_rand();
    }

    $salt = substr(md5($password), 0, 2);

    $password = md5($salt . $plain) . ':' . $salt;

    return $password;
  }
  
  function tep_validate_password($plain, $encrypted) {
    if (tep_not_null($plain) && tep_not_null($encrypted)) {
// split apart the hash / salt
      $stack = explode(':', $encrypted);

      if (sizeof($stack) != 2) return false;

      if (md5($stack[1] . $plain) == $stack[0]) {
        return true;
      }
    }

    return false;
  }
  
  function tep_rand($min = null, $max = null) {
    static $seeded;

    if (!isset($seeded)) {
      mt_srand((double)microtime()*1000000);
      $seeded = true;
    }

    if (isset($min) && isset($max)) {
      if ($min >= $max) {
        return $min;
      } else {
        return mt_rand($min, $max);
      }
    } else {
      return mt_rand();
    }
  }
  
  function tep_not_null($value) {
    if (is_array($value)) {
      if (sizeof($value) > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
        return true;
      } else {
        return false;
      }
    }
  }
  
  function tep_date_raw($date, $reverse = false) {
	if ($reverse) {
		return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
	} else {
		return substr($date, 6, 4) . substr($date, 0, 2) . substr($date, 3, 2);
	}
  }
  
  function tep_create_random_value($length, $type = 'mixed') {
    if ( ($type != 'mixed') && ($type != 'chars') && ($type != 'digits')) return false;

    $rand_value = '';
    while (strlen($rand_value) < $length) {
      if ($type == 'digits') {
        $char = tep_rand(0,9);
      } else {
        $char = chr(tep_rand(0,255));
      }
      if ($type == 'mixed') {
        if (eregi('^[a-z0-9]$', $char)) $rand_value .= $char;
      } elseif ($type == 'chars') {
        if (eregi('^[a-z]$', $char)) $rand_value .= $char;
      } elseif ($type == 'digits') {
        if (ereg('^[0-9]$', $char)) $rand_value .= $char;
      }
    }

    return $rand_value;
  }
  
  function user_get_type($type){
	switch($type){
		case 0:
			return "Normal User";
			break;
		case 1:
			return "Senior User";
			break;
		case 100:
			return "Administrator";
			break;
	}
  }
  
function utf8RawUrlDecode ($source) {
    $decodedStr = "";
    $pos = 0;
    $len = strlen ($source);
    while ($pos < $len) {
        $charAt = substr ($source, $pos, 1);
        if ($charAt == '%') {
            $pos++;
            $charAt = substr ($source, $pos, 1);
            if ($charAt == 'u') {
                // we got a unicode character
                $pos++;
                $unicodeHexVal = substr ($source, $pos, 4);
                $unicode = hexdec ($unicodeHexVal);
                $entity = "&#". $unicode . ';';
                $decodedStr .= utf8_encode ($entity);
                $pos += 4;
            }
            else {
                // we have an escaped ascii character
                $hexVal = substr ($source, $pos, 2);
                $decodedStr .= chr (hexdec ($hexVal));
                $pos += 2;
            }
        } else {
            $decodedStr .= $charAt;
            $pos++;
        }
    }
    return $decodedStr;
} 

function utf8Str2vertical($str){
	$ret = '';
	$arr = str_split($str);
	for($i=0; $i<count($arr); $i++){
		if($arr[$i]=='&'){
			if($arr[$i+1]=='#'){
				$utf8str = '&#';
				$index = 2;
				while($arr[$i+$index]!=';'){
					$utf8str .= $arr[$i+$index];
					$index++;
				}
				$i+=7;
				$ret .= utf8_encode($utf8str.';')."<br/>";
			}else{
			
			}
		}else{
			$ret .= $arr[$i]."<br/>";
		}
	}
	return $ret;
}

function mbStr2vertical($str){
	$array = preg_split('//u', $str);
	return implode("<br/>", $array);
}

function replaceTag($content){
	//$content = "abcdefg!\n[IMG]12345[/IMG]lmnoq\nrs[IMG]45435[/IMG]tuv[IMG]1[/IMG]"; 
	// IMG
	$pattern = "/\[IMG\]([^\']+?)\[\/IMG\]/";
	preg_match_all($pattern, $content, $matches);
	//print_r($matches); 
	
	for($i=0;$i<count($matches[0]);$i++){
		$image_file_name = $matches[1][$i];
		//echo "SELECT * FROM image WHERE image_id = $id;";
		//$query_result = tep_db_query("SELECT * FROM image WHERE image_id = $id;");
		//$row = tep_db_fetch_array($query_result);
		//$image_file_name = "uploads/".$row['image_url'];
		
		/*方法1:使用GetImageSize,取得圖片尺寸可能造成讀取速度緩慢
		$image_resolution = GetImageSize($image_file_name); 
		if ($image_resolution[0] < 850) { //假如寬度小於850px，則直接顯示
		$content = str_replace($matches[0][$i], "<p><img src='$image_file_name'/></p>", $content);
		}
		else {$content = str_replace($matches[0][$i], "<p><img src='$image_file_name' width='850'/></p>", $content);} //假如寬度大於850px, 則限制圖片寬度為850px
		*/
		
		/*方法二:使用css*/
		$content = str_replace($matches[0][$i], "<div class=div_pic><img src='$image_file_name'/></div>", $content);
		
		//echo ",$matches[1][1],$matches[1][2]";
	}
	//	blockquote
	$pattern="/\[BLOCKQUOTE\]([^\']+?)\[\/BLOCKQUOTE\]/";
	preg_match_all($pattern, $content, $matches);
		for($i=0; $i<count($matches[0]);$i++){ //1st layer
		$BQ_str = $matches[1][$i];
		$content = str_replace($matches[0][$i], "<blockquote>$BQ_str</blockquote>", $content);
			$pattern="/\[BLOCKQUOTE\]([^\']+?)\[\/BLOCKQUOTE\]/";
			preg_match_all($pattern, $content, $matches);
			for($j=0; $i<count($matches[0]);$j++){ //2nd layer
				$BQ_str = $matches[1][$j];
				$content = str_replace($matches[0][$j], "<blockquote>$BQ_str</blockquote>", $content);
				$pattern="/\[BLOCKQUOTE\]([^\']+?)\[\/BLOCKQUOTE\]/";
				preg_match_all($pattern, $content, $matches);
				for($k=0; $i<count($matches[0]);$k++){ //3rd layer
					$BQ_str = $matches[1][$k];
					$content = str_replace($matches[0][$k], "<blockquote>$BQ_str</blockquote>", $content);
				}				
			}
	}	

	// BOLD
	$pattern="/\[B\](.+?)\[\/B\]/";
	preg_match_all($pattern, $content, $matches);
	for($i=0; $i<count($matches[0]);$i++){
		$bold_str = $matches[1][$i];
		$content = str_replace($matches[0][$i], "<b>$bold_str</b>", $content);
	}
	// Italics
	$pattern="/\[I\](.+?)\[\/I\]/";
	preg_match_all($pattern, $content, $matches);
	for($i=0; $i<count($matches[0]);$i++){
		$str = $matches[1][$i];
		$content = str_replace($matches[0][$i], "<i>$str</i>", $content);
	}
	// Underline
	$pattern="/\[U\](.+?)\[\/U\]/";
	preg_match_all($pattern, $content, $matches);
	for($i=0; $i<count($matches[0]);$i++){
		$str = $matches[1][$i];
		$content = str_replace($matches[0][$i], "<u>$str</u>", $content);
	}
	// center
	$pattern="/\[C\](.+?)\[\/C\]/";
	preg_match_all($pattern, $content, $matches);
	for($i=0; $i<count($matches[0]);$i++){
		$str = $matches[1][$i];
		$content = str_replace($matches[0][$i], "<center>$str</center>", $content);
	}
	// link
	$pattern="/\[LINK\]([^\']+?)\[\/LINK\]/";
	preg_match_all($pattern, $content, $matches);
	for($i=0; $i<count($matches[0]);$i++){
		$str = $matches[1][$i];
		$content = str_replace($matches[0][$i], "<a target='_blank' href='$str'>$str</a>", $content);
	}
	// mail
	$pattern="/\[MAIL\]([^\']+?)\[\/MAIL\]/";
	preg_match_all($pattern, $content, $matches);
	for($i=0; $i<count($matches[0]);$i++){
		$str = $matches[1][$i];
		$content = str_replace($matches[0][$i], "<a href='mailto:'$str'>$str</a>", $content);
	}	
	// route
	$pattern="/\[ROUTE\](.+?)\[\/ROUTE\]/";
	preg_match_all($pattern, $content, $matches);
	for($i=0; $i<count($matches[0]);$i++){
		$str = $matches[1][$i];
		$content = str_replace($matches[0][$i], "<div><iframe src='route_iframe.php?rid=$str' width='640' height=240'></iframe></div>" , $content);
		//auto01//$content = str_replace($matches[0][$i], "<div><iframe id='RouteFrameID' onload='javascript:{dyniframesize('RouteFrameID');}' marginwidth=0 marginheight=0 frameborder=0 scrolling=no src='route_iframe.php?rid=$str' width=640 ></iframe></div>" , $content);
		//$content = str_replace($matches[0][$i], "<div><iframe src='route_iframe.php?rid=$str' id='frameid' frameborder='0' width='640'></iframe></div>" , $content);
		//<iframe src="route_iframe.php?rid=$str" id="frameid" frameborder="0"></iframe> 
		//larry//$content = str_replace($matches[0][$i], "<u>$str</u>", $content);
	}
	return $content;
}

function replaceTag2none($content){

	$pattern = "/\[IMG\]([^\']+?)\[\/IMG\]/";
	preg_match_all($pattern, $content, $matches);
	
	for($i=0;$i<count($matches[0]);$i++){
		$image_file_name = $matches[1][$i];
		$content = str_replace($matches[0][$i], "", $content);
	}
	//	blockquote
	$pattern="/\[BLOCKQUOTE\]([^\']+?)\[\/BLOCKQUOTE\]/";
	preg_match_all($pattern, $content, $matches);
		for($i=0; $i<count($matches[0]);$i++){ //1st layer
		$BQ_str = $matches[1][$i];
		$content = str_replace($matches[0][$i], "", $content);
			$pattern="/\[BLOCKQUOTE\]([^\']+?)\[\/BLOCKQUOTE\]/";
			preg_match_all($pattern, $content, $matches);
			for($j=0; $i<count($matches[0]);$j++){ //2nd layer
				$BQ_str = $matches[1][$j];
				$content = str_replace($matches[0][$j], "", $content);
				$pattern="/\[BLOCKQUOTE\]([^\']+?)\[\/BLOCKQUOTE\]/";
				preg_match_all($pattern, $content, $matches);
				for($k=0; $i<count($matches[0]);$k++){ //3rd layer
					$BQ_str = $matches[1][$k];
					$content = str_replace($matches[0][$k], "", $content);
				}				
			}
	}	

	// BOLD
	$pattern="/\[B\](.+?)\[\/B\]/";
	preg_match_all($pattern, $content, $matches);
	for($i=0; $i<count($matches[0]);$i++){
		$bold_str = $matches[1][$i];
		$content = str_replace($matches[0][$i], "$bold_str", $content);
	}
	// Italics
	$pattern="/\[I\](.+?)\[\/I\]/";
	preg_match_all($pattern, $content, $matches);
	for($i=0; $i<count($matches[0]);$i++){
		$str = $matches[1][$i];
		$content = str_replace($matches[0][$i], "$str", $content);
	}
	// Underline
	$pattern="/\[U\](.+?)\[\/U\]/";
	preg_match_all($pattern, $content, $matches);
	for($i=0; $i<count($matches[0]);$i++){
		$str = $matches[1][$i];
		$content = str_replace($matches[0][$i], "$str", $content);
	}
	// center
	$pattern="/\[C\](.+?)\[\/C\]/";
	preg_match_all($pattern, $content, $matches);
	for($i=0; $i<count($matches[0]);$i++){
		$str = $matches[1][$i];
		$content = str_replace($matches[0][$i], "$str", $content);
	}
	// link
	$pattern="/\[LINK\]([^\']+?)\[\/LINK\]/";
	preg_match_all($pattern, $content, $matches);
	for($i=0; $i<count($matches[0]);$i++){
		$str = $matches[1][$i];
		$content = str_replace($matches[0][$i], "$str", $content);
	}
	// mail
	$pattern="/\[MAIL\]([^\']+?)\[\/MAIL\]/";
	preg_match_all($pattern, $content, $matches);
	for($i=0; $i<count($matches[0]);$i++){
		$str = $matches[1][$i];
		$content = str_replace($matches[0][$i], "$str", $content);
	}	
	// route
	$pattern="/\[ROUTE\](.+?)\[\/ROUTE\]/";
	preg_match_all($pattern, $content, $matches);
	for($i=0; $i<count($matches[0]);$i++){
		$str = $matches[1][$i];
		$content = str_replace($matches[0][$i], "" , $content);
	}
	return $content;
}

function splitFilename($filename)
{
    $pos = strrpos($filename, '.');
    if ($pos === false)
    { // dot is not found in the filename
        return array($filename, ''); // no extension
    }
    else
    {
        $basename = substr($filename, 0, $pos);
        $extension = substr($filename, $pos+1);
        return array($basename, $extension);
    }
} 

function showImage($filename, $class='postUserImg', $height=120, $width=120, $type=""){
	if($filename==""){
		if ($type=='date') {$filename = "imgs/date_icon.jpg";} 
		else { $filename = "imgs/no_image.jpg"; }
		//$filename = "../images/no_icon.gif";
	}else if ($image_size = @getimagesize("uploads/$filename")) {
        if ($width==0 && $height!=0) {
          $ratio = $height / $image_size[1];
          $width = $image_size[0] * $ratio;
        } elseif ($width!=0 && $height==0) {
          $ratio = $width / $image_size[0];
          $height = $image_size[1] * $ratio;
        } elseif ($width==0 && $height==0) {
          $width = $image_size[0];
          $height = $image_size[1];
        }
		$filename = "uploads/$filename";
    } elseif (IMAGE_REQUIRED == 'false') {
		return false;
    }
	echo "<img src='$filename' width='$width' height='$height'  class='$class'/>";
}

function inputFilter(){
	$_POST = securityFilter($_POST);
	$_GET = securityFilter($_GET);
}

function securityFilter($array){
	while(list($key, $value)=each($array)){
		// sql injection by filter ";"
		$array[$key] = str_replace(";", "", $value);
		// xss by htmlentities
		$array[$key] = htmlspecialchars($value);
		//echo $array[$key].",";
	}
	return $array;
}

function singleFilter($str){
	// sql injection by filter ";"
	$str = str_replace(";", "", $str);
	// xss by htmlentities
	$str = htmlspecialchars($str);
	$str = addslashes($str);
	return $str;
}

function rotate_right90($im)
{
 $wid = imagesx($im);
 $hei = imagesy($im);
 $im2 = imagecreatetruecolor($hei,$wid);

 for($i = 0;$i < $wid; $i++)
 {
  for($j = 0;$j < $hei; $j++)
  {
   $ref = imagecolorat($im,$i,$j);
   imagesetpixel($im2,$hei - $j,$i,$ref);
  }
 }
 return $im2;
}

function getDateString($datetime){
	$dateArray = split(" ", $datetime);
	return $dateArray[0];
}

function getArticleTimeFormat($datetime){
	$time = strftime("%Y-%m-%d %H:%M %p", strtotime($datetime));
	return $time;
}

function getUserName($uid){
	$user_query = tep_db_query("SELECT user_name, user_nickname FROM user WHERE user_id = $uid");
	$user_row = tep_db_fetch_array($user_query);
	return $user_row['user_nickname']==""?$user_row['user_name']:$user_row['user_nickname'];
	
}

function file_check($imgFile,$long_side,$short_side,$img_size){
	$uptypes = array (
		'image/jpg',
		'image/jpeg',
		'image/pjpeg',
		'image/gif',
		'image/png',
		'image/x-png'
	);
	//$max_file_size = 2097152;
	$max_file_size = $img_size;
	if ($imgFile['size'] > $max_file_size) {
		return false;
    /*檢查文件類型 */
    } elseif(in_array($imgFile['type'], $uptypes)) {
		/*上傳圖片類型為jpg,pjpeg,jpeg */
		if (strstr($imgFile['type'], "jp")) {
			if(!($source = @ imageCreatefromjpeg($imgFile['tmp_name']))){
				//echo '檔案類型錯誤';
				return false;
			}
		/*上傳圖片類型為png */
		}elseif(strstr($imgFile['type'], "png")) {
			if(!($source = @ imagecreatefrompng($imgFile['tmp_name']))){
				//echo '檔案類型錯誤';
				return false;
			}
		/*上傳圖片類型為gif */
		}elseif(strstr($imgFile['type'], "gif")) {
			if(!($source = @ imagecreatefromgif($imgFile['tmp_name']))){
				//echo '檔案類型錯誤';
				return false;
			}
		/*其他例外圖片排除 */
		} else {
			//echo '檔案類型錯誤';
			return false;
		}
		$w = imagesx($source); /*取得圖片的寬 */
		$h = imagesy($source); /*取得圖片的高 */
		/*檢查檔案最小尺寸 160px*160px */
		if ($w >= $h && $w > $long_side || $h>$short_side){
			//echo '橫式檔案過大';
			return false;
		}else if($w<$h && $w>$short_side || $h>$long_side) {
			// echo '直式檔案過大';
			return false;
		}
		return true;
	}
}

function file_check_old($imgFile){
	$uptypes = array (
		'image/jpg',
		'image/jpeg',
		'image/pjpeg',
		'image/gif',
		'image/png',
		'image/x-png'
	);
	$max_file_size = 2097152;
	if ($imgFile['size'] > $max_file_size) {
		return false;
    /*檢查文件類型 */
    } elseif(in_array($imgFile['type'], $uptypes)) {
		/*上傳圖片類型為jpg,pjpeg,jpeg */
		if (strstr($imgFile['type'], "jp")) {
			if(!($source = @ imageCreatefromjpeg($imgFile['tmp_name']))){
				//echo '檔案類型錯誤';
				return false;
			}
		/*上傳圖片類型為png */
		}elseif(strstr($imgFile['type'], "png")) {
			if(!($source = @ imagecreatefrompng($imgFile['tmp_name']))){
				//echo '檔案類型錯誤';
				return false;
			}
		/*上傳圖片類型為gif */
		}elseif(strstr($imgFile['type'], "gif")) {
			if(!($source = @ imagecreatefromgif($imgFile['tmp_name']))){
				//echo '檔案類型錯誤';
				return false;
			}
		/*其他例外圖片排除 */
		} else {
			//echo '檔案類型錯誤';
			return false;
		}
		$w = imagesx($source); /*取得圖片的寬 */
		$h = imagesy($source); /*取得圖片的高 */
		/*檢查檔案最小尺寸 160px*160px */
		if ($w >= $h && $w > 800 || $h>600){
			//echo '橫式檔案過大';
			return false;
		}else if($w<$h && $w>600 || $h>800) {
			// echo '直式檔案過大';
			return false;
		}
		return true;
	}
}

function lable2none($str){
$f=array("[B]","[/B]","[IMG]","[/IMG]","[I]","[/I]","[BLOCKQUOTE]","[/BLOCKQUOTE]","[U]","[/U]","[C]","[/C]","[LINK]","[/LINk]","[MAIL]","[/MAIL]");
$h=array("","","","","","","","","","","","","","","","");
return str_replace($f,$h,$str);
}

function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
/*
$interval can be:
yyyy - Number of full years
q - Number of full quarters
m - Number of full months
y - Difference between day numbers
(eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
d - Number of full days
w - Number of full weekdays
ww - Number of full weeks
h - Number of full hours
n - Number of full minutes
s - Number of full seconds (default)
*/

if (!$using_timestamps) {
$datefrom = strtotime($datefrom, 0);
$dateto = strtotime($dateto, 0);
}
$difference = $dateto - $datefrom; // Difference in seconds

switch($interval) {

case 'yyyy': // Number of full years
 
$years_difference = floor($difference / 31536000);
if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
$years_difference--;
}
if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
$years_difference++;
}
$datediff = $years_difference;
break;
 
case "q": // Number of full quarters
 
$quarters_difference = floor($difference / 8035200);
while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
$months_difference++;
}
$quarters_difference--;
$datediff = $quarters_difference;
break;
 
case "m": // Number of full months
 
$months_difference = floor($difference / 2678400);
while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
$months_difference++;
}
$months_difference--;
$datediff = $months_difference;
break;
 
case 'y': // Difference between day numbers
 
$datediff = date("z", $dateto) - date("z", $datefrom);
break;
 
case "d": // Number of full days
 
$datediff = floor($difference / 86400);
break;
 
case "w": // Number of full weekdays
 
$days_difference = floor($difference / 86400);
$weeks_difference = floor($days_difference / 7); // Complete weeks
$first_day = date("w", $datefrom);
$days_remainder = floor($days_difference % 7);
$odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
if ($odd_days > 7) { // Sunday
$days_remainder--;
}
if ($odd_days > 6) { // Saturday
$days_remainder--;
}
$datediff = ($weeks_difference * 5) + $days_remainder;
break;
 
case "ww": // Number of full weeks
 
$datediff = floor($difference / 604800);
break;
 
case "h": // Number of full hours
 
$datediff = floor($difference / 3600);
break;
 
case "n": // Number of full minutes
 
$datediff = floor($difference / 60);
break;
 
default: // Number of full seconds (default)
 
$datediff = $difference;
break;
} 
 
return $datediff;
 
}


?>