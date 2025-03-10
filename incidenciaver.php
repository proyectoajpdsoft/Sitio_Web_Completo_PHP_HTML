<html>
<head>
  <title>Mostrar incidencias</title>
</head>

<?php
  include ("funciones.php");
  iniciarSesionPaginas();
?>

<body bgcolor="#FFFFFF" text="#000000">
<form name="formVerIncidencias" method="post" action="incidenciaver.php">
<?php
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  if ($ver == "todas")
  {
    $tipolistado = " (TODAS)";
  }
  if ($ver == "noresueltas")
  {
    $tipolistado = " (No resueltas)";
  }
  if ($ver == "siresueltas")
  {
    $tipolistado = " (Sí resueltas)";
  }
  $encabezado = "<font size=\"2\" color=\"#008080\"><span style=\"font-family: Arial\"><b>
     Listado de incidencias " .
     $tipolistado . " [" . $nombreusuario . "]</span></font><hr size=2 width=\"100%\" align=center>";
  echo $encabezado;
?>

<table border="1" cellspacing=1 cellpadding=2 style="font-size: 8pt"><tr>
<tr bgcolor=#cccccc>

<td><font face="verdana"><b>Cód.</b></font></td>

<?
  if ($tipousuario == "Administrador")  //si es el administrador
  {
    echo "<td><font face=\"verdana\"><b>C.Usuario</b></font></td>";
  }
?>

<td><font face="verdana"><b>C.Programa</b></font></td>
<td><font face="verdana"><b>Fecha</b></font></td>
<td><font face="verdana"><b>Hora</b></font></td>
<td><font face="verdana"><b>Tipo</b></font></td>

<?
  if ($tipousuario == "Administrador")  //si es el administrador
  {
    echo "<td><font face= \"verdana\"><b>Estado</b></font></td>";
  }
?>

<td><font face="verdana"><b>Resuelta</b></font></td>
<td><font face="verdana"><b>Fecha Res.</b></font></td>
<td><font face="verdana"><b>Comentario</b></font></td>
</tr>

<?
  if ($tipousuario == "Administrador")  //si es el administrador
  {
    if ($ver == "todas")
    {
      $query = "SELECT *
                FROM incidencias
                ORDER BY codigousuario, fecha, hora";
    }
    if ($ver == "noresueltas")
    {
      $query = "SELECT *
                FROM incidencias
                WHERE resuelta=0
                ORDER BY fecha";
    }
    if ($ver == "siresueltas")
    {
      $query = "SELECT *
                FROM incidencias
                WHERE resuelta=1
                ORDER BY fecha, hora";
    }
  }
  else  //usuario normal
  {
    if ($ver == "todas")
    {
      $query = "SELECT * FROM incidencias WHERE codigousuario ='" .
          $codigousuario . "' AND estado<>'Cancelada' ORDER BY fecha, hora";
    }
    if ($ver == "noresueltas")
    {
      $query = "SELECT * FROM incidencias WHERE codigousuario ='" . $codigousuario .
         "' AND resuelta=0 AND estado<>'Cancelada' ORDER BY fecha, hora";
    }
    if ($ver == "siresueltas")
    {
      $query = "SELECT * FROM incidencias WHERE codigousuario ='" . $codigousuario .
         "' AND resuelta=1 AND estado<>'Cancelada' ORDER BY fecha, hora";
    }
  }
  conectarbd("bd");
  $result = mysql_query($query);
  $numero = 0;
  while ($row = mysql_fetch_array($result))
  {
    echo "<tr>";
    echo "<td><font face=\"verdana\">" . $row["codigo"] . "</font></td>";
    if ($tipousuario == "Administrador")
    {
      echo "<td><font face=\"verdana\">" . $row["codigousuario"] . "</font></td>";
    }
    echo "<td><font face=\"verdana\">" . $row["codigoprograma"] . "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["fecha"] . "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["hora"] . "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["tipo"] . "</font></td>";
    if ($tipousuario == "Administrador")
    {
      echo "<td><font face=\"verdana\">" . $row["estado"]. "</font></td>";
    }
    echo "<td><font face=\"verdana\">" . SiNo($row["resuelta"]) . "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["fecharesolucion"]. "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["comentarioresolucion"]. "</font></td>";
    echo "</tr><td width=\"100%\" colspan=\"15\"><font face=\"verdana\">" . $row["comentario"]. "</font></td></tr>";
    $numero++;
  }
  echo "<tr><td colspan=\"15\"><font face=\"verdana\"><b>Número: " . $numero . "</b></td></tr>";
?>
</table>
</form>

<?
  echo ("<br><p align=\"center\"> <A href=\"javascript:history.back();\">Volver atrás");
?>

</body>
</html>
