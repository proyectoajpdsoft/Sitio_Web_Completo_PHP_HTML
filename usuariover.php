<html>
<head>
<title>Listado de usuarios</title>
</head>

<?php
  include ("funciones.php");
  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  if ($tipousuario != "Administrador")
  {
    mostrarTextoError("Error de acceso", "No tiene permisos para realizar esta operación");
  }
?>

<body bgcolor="#FFFFFF" text="#000000">
<form name="formverusuarios" method="post" action="verusuarios.php">
<table border="1" cellspacing=1 cellpadding=2 width="100%" style="font-size: 8pt"><tr>
<td width="50"><span><font face="verdana"><b>Cód.</b></font></span></td>
<td width="50"><span><font face="verdana"><b>Cód. personal</b></font></span></td>
<td><font face="verdana"><b>Nombre</b></font></td>
<td><font face="verdana"><b>E-Mail</b></font></td>
<td><font face="verdana"><b>E.Infor.</b></font></td>
<td><font face="verdana"><b>F. Alta</b></font></td>
<td><font face="verdana"><b>Tipo</b></font></td>
<td><font face="verdana"><b>DNI</b></font></td>
<td><font face="verdana"><b>Contr.</b></font></td>
<td><font face="verdana"><b>Dirección</b></font></td>
<td><font face="verdana"><b>Localidad</b></font></td>
<td><font face="verdana"><b>C.P.</b></font></td>
<td><font face="verdana"><b>Provincia</b></font></td>
<td><font face="verdana"><b>País</b></font></td>
<td><font face="verdana"><b>F. últ. vis.</b></font></td>
<td><font face="verdana"><b>H. últ. vis.</b></font></td>
<td><font face="verdana"><b>Nº visitas</b></font></td>
</tr>

<?php
  $encabezado = "<font size=\"2\" color=\"#008080\"><span style=\"font-family:
      Arial\"><b>Listado de usuarios [ " . $nombreusuario . " ]</span></font><hr size=2
      width=\"100%\" align=center>";
  echo $encabezado;
  conectarbd ("bdajpdsoft");
  $query = "SELECT * FROM usuarios";
  $result = mysql_query($query);
  $numero = 0;
  while($row=mysql_fetch_array($result))
  {
    echo "<tr>";
    echo "<td><font face=\"verdana\">" . $row["codigo"] . "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["codigousuario"] . "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["nombre"] . "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["email"]. "</font></td>";
    echo "<td><font face=\"verdana\">" . SiNo($row["envioinformacion"]). "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["fechaalta"]. "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["tipo"] . "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["dni"] . "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["contrasena"] . "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["direccion"] . "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["localidad"]. "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["codigopostal"]. "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["provincia"]. "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["pais"]. "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["fechaultimavisita"]. "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["horaultimavisita"]. "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["numerovisitas"]. "</font></td>";
    echo "</tr>";
    $numero++;
  }
  echo "<tr><td colspan=\"15\"><font face=\"verdana\"><b>Número: " . $numero .
      "</b></font></td></tr>";
?>
</table>
</form>
<?
  echo ("<br><p align=\"center\"> <A href=\"javascript:history.back();\">Volver atrás");
?>
</body>
</html>
