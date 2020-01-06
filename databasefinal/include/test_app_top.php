<?php
 include("include/test_configure.php");
 include("include/test_function.php");
 inputFilter();
 tep_db_connect() or die("xxxx");
 mysql_query("SET NAMES 'utf8'");
 ini_set('default_charset','utf-8');
 

 ?>