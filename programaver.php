<html>
<head>
<title>Listado de programas</title>
</head>

<?php
  include ("funciones.php");
  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  if ($tipousuario != "Administrador")
  {
    mostrarTextoError("Error de acceso",
    "No tiene permisos para realizar esta operación");
  }
?>


<body bgcolor="#FFFFFF" text="#000000">
<form name="formverprogramas" method="post" action="verprogramas.php">
<table border="1" cellspacing=1 cellpadding=2 style="font-size: 8pt"><tr>
<td><font face="verdana"><b>Código</b></font></td>
<td><font face="verdana"><b>Nombre</b></font></td>
<td><font face="verdana"><b>Versión</b></font></td>
<td><font face="verdana"><b>S.O.</b></font></td>
<td><font face="verdana"><b>Tamaño</b></font></td>
<td><font face="verdana"><b>Precio</b></font></td>
<td><font face="verdana"><b>Tipo</b></font></td>
<td><font face="verdana"><b>Finalizado</b></font></td>
<td><font face="verdana"><b>Libre</b></font></td>
<td><font face="verdana"><b>Fecha</b></font></td>
</tr>
<?php
  $encabezado = "<font size=\"2\" color=\"#008080\"><span style=\"font-family:
  Arial\"><b>Listado de programas [ " . $nombreusuario . " ]</span></font><hr size=2 width=\"100%\" align=center>";
  echo $encabezado;

  conectarbd ("bd");
  
  $query = "SELECT * FROM programas";
  $result = mysql_query($query);
  $numero = 0;
  while($row = mysql_fetch_array($result))
  {
    echo "<tr><td width=\"25%\"><font face=\"verdana\">" . $row["codigo"] . "</font></td>";
    echo "<td width=\"25%\"><font face=\"verdana\">" . $row["nombre"] . "</font></td>";
    echo "<td width=\"25%\"><font face=\"verdana\">" . $row["version"] . "</font></td>";
    echo "<td width=\"25%\"><font face=\"verdana\">" . $row["so"] . "</font></td>";
    echo "<td width=\"25%\"><font face=\"verdana\">" . $row["tamano"]. "</font></td>";
    echo "<td width=\"25%\"><font face=\"verdana\">" . $row["precio"]. "</font></td>";
    echo "<td width=\"25%\"><font face=\"verdana\">" . $row["tipo"]. "</font></td>";
    echo "<td width=\"25%\"><font face=\"verdana\">" . SiNo($row["finalizado"]). "</font></td>";
    echo "<td width=\"25%\"><font face=\"verdana\">" . SiNo($row["libre"]). "</font></td>";
    echo "<td width=\"25%\"><font face=\"verdana\">" . $row["fecha"]. "</font></td>";
    echo "</tr><td width=\"100%\" colspan=\"15\"><font face=\"verdana\">" . $row["comentario"] . "</font></td></tr>";
    $numero++;
  }
  echo "<tr><td colspan=\"15\"><font face=\"verdana\"><b>Número: " . $numero . "</b></font></td></tr>";
?>
</table>
</form>
<?
  echo ("<br><p align=\"center\"> <A href=\"javascript:history.back();\">Volver atrás");
?>
</body>
</html>
