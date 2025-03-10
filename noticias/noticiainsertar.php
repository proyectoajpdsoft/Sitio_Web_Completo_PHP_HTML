<?php
include "configuracion.php";
$where_form_is="http".($HTTP_SERVER_VARS["HTTPS"]=="on"?"s":"")."://".$SERVER_NAME.strrev(strstr(strrev($PHP_SELF),"/"));
$link = mysql_connect("$db_host","$db_user","$db_pass");
mysql_select_db("$db_name",$link);
$query="insert into news (newsdate,newstitle,news) values ('".$newsdate."','".$newstitle."','".$news."')";
mysql_query($query);
header("Refresh: 0;url=hecho.php");

?>
