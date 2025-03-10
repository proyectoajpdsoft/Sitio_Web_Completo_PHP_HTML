<?php
include "proteccion.php";
include "configuracion.php";
?>
<html>
<head>
<title><?php echo "$title"; ?></title>
<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../estilos/estilo.css\">";
?>
</head>
<body>
<form name="notes" method="post" action="noticiainsertar.php">
<div align="center">
<table width="70%" border="0" cellspacing="0" cellpadding="3">
  <tr> 
    <td>
<p align="left"><strong>AjpdSoft - Noticias - Administración</strong></p>
  </td> 
    </tr>
  <tr> 
    <td>
<p><b>Fecha:<br>
      <input type="text" name="newsdate" value="<?php echo "$date"; ?>" size="30">
    </td>
  </tr>
    <td><p><b>Asunto:<br>
      <input type="text" name="newstitle" value="" size="30">
    </td>
  </tr>
  <tr> 
    <td><p"><b>Noticia:<br>
 <textarea rows="8" cols="40" name="news"></textarea>
    </td>
  </tr>
  <tr> 
    <td>
      <input type="submit" name="Submit" value="Añadir noticia">
</form>
    </td>
  </tr>
<tr>
<td>
<p align="left"><strong>Noticias previamente agregadas:</strong></p>
<?php
mysql_connect("$db_host","$db_user","$db_pass");
@mysql_select_db("$db_name") or die( "No se ha podido abrir la base de datos en este momento.");
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
echo "<strong>No hay noticias disponibles</strong>";
}
?>
<hr color="#333333" width="50%" align="left"><strong>AjpdSoft - Noticias</strong></p>
</td>
</tr>
</table>
</div>
</body>
</html>


