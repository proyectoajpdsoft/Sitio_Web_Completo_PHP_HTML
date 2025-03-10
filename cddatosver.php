<html>
<head>
  <title>Listado de CD's de datos</title>
</head>
<?php
  $tipoletranormal = "<font face=\"verdana\" style=\"font-size: 10pt\">";
  $encabezadoerror = "<font size=\"2\" color=\"#008080\"><span style=\"font-family: Arial\"><b>Error</span></b></font><hr size=2 width=\"100%\" align=center>";
  if (empty($codigousuario) || $codigousuario == "")
  {
    die($encabezadoerror .$tipoletranormal .
        "Debe inciar la sesión. <A href=\"login.html\">Iniciar sesión</A>");
  }
?>
<body bgcolor="#FFFFFF" text="#000000">
<form name="FormVerCDDatos" method="post" action="cddatosver.php">
<table border="1" cellspacing=1 cellpadding=2 width="100%" style="font-size: 8pt"><tr>
<td><font face="verdana"><b>Código</b></font></td>
<td><font face="verdana"><b>Nombre CD</b></font></td>
</tr>
<?php
  include("funciones.php");
  
  $tipoletranormal = "<font face=\"verdana\" style=\"font-size: 10pt\">";
  $encabezado = "<font size=\"2\" color=\"#008080\"><span style=\"font-family: Arial\"><b>Listado de CD's de datos</span></font><hr size=2 width=\"100%\" align=center>";
  echo $encabezado;
  conectarbd ("bd");
  $query = "SELECT * FROM cddatos";
  $result = mysql_query($query);
  $numero = 0;
  while($row=mysql_fetch_array($result))
  {
    echo "<tr>";
    echo "<td><font face=\"verdana\">" . $row["codigo"] . "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["nombre"] . "</font></td>";
    echo "</tr>";
    $numero++;
  }
  echo "<tr><td colspan=\"15\"><font face=\"verdana\"><b>Número: " . $numero .
      "</b></font></td></tr></table></form>";
  echo ($tipoletranormal .
            "<br><p align=\"center\"> <A href=\"javascript:history.back();\">Volver atrás");
?>
</body>
</html>
