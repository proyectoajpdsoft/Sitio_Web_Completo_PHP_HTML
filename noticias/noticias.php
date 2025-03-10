<html>
<head>
<?php include "configuracion.php"; ?>
<title><?php echo "$title"; ?></title>
<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../estilos/estilo.css\">";
?>
</head>
<body>
<div align="center">
<table width="70%" border="0" cellspacing="0" cellpadding="3">
  <tr> 
    <td>
<?php
mysql_connect("$db_host","$db_user","$db_pass");
@mysql_select_db("$db_name") or die( "La base de datos seleccionada no está disponible en estos momentos.");
$query="SELECT * FROM news ORDER BY id DESC";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();


$i=0;
while ($i < $num) {
$newstitle=mysql_result($result,$i,"newstitle");
$newsdate=mysql_result($result,$i,"newsdate");       
$news=mysql_result($result,$i,"news"); 
echo "<table width=\"50%\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\" bordercolor=\"#6699CC\" BGCOLOR=\"#FFFFFF\">";
echo "<tr>";
echo "<td bgcolor=\"#6699CC\"><p align=\"left\"><strong>$newstitle<br>($newsdate)</td>";
echo "</tr>";
echo "<tr>";
echo "<td><p align=\"left\"><strong>$news</td>";
echo "</tr>";
echo "</table>";
echo "<br>";
++$i;
}
if(mysql_num_rows($result) == 0)
{
echo "<strong>¡No hay noticias actualmente!</strong>";
}
?>
<a href="noticianueva.php"><strong> Pulse aquí para añadir una noticia</a></strong><br><br>
<hr color="#333333" width="50%" align="left"><strong>AjpdSoft - Noticias</strong>
</div>
</td>
</tr>
</body>
</html>
