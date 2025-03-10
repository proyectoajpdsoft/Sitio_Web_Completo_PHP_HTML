<html>
<body>

<?php
  include ("funciones.php");
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  if (empty($ver)) //si es la primera vez que se ejecuta
  {
    iniciarSesionPaginas();
    $ver = 0;
    $veranterior = 0;
    $numero = 0;
  }

  if (empty($opBuscar)) //si no se ha pulsado buscar
  {
    $sql = "SELECT Referencia, Titulo, grupos.Nombre Grupo
            FROM cdmusica, grupos
            WHERE IDGrupo=grupos.ID
            ORDER BY grupos.Nombre, Titulo";
  }
  else
  {
    if (empty($txtBuscar))
    {
      mostrarTextoError ("Faltan datos","Debe introducir el texto del título a buscar.");
    }
    else
    {
      $sql = "SELECT Referencia, Titulo, grupos.Nombre Grupo
              FROM cdmusica, grupos
            WHERE IDGrupo=grupos.ID AND upper(Titulo) LIKE '%" .
            strtoupper($txtBuscar) . "%'
            ORDER BY grupos.Nombre, Titulo";
    }
  }
?>

<form method="post" action="csmusicaver.php">
<body bgcolor="#FFFFFF" text="#000000">
<table border="1" cellspacing=1 cellpadding=2 width="100%" style="font-size: 8pt"><tr>
<td width="50"><span><font face="verdana"><b>Ref.</b></font></span></td>
<td><font face="verdana"><b>Grupo</b></font></td>
<td><font face="verdana"><b>Título</b></font></td>

<?
  if ($tipousuario == "Administrador")
  {
    echo "<td><font face=\"verdana\"><b>Acción</b></font></td></tr>";
  }
  $tipoletranormal = "<font face=\"verdana\" style=\"font-size: 10pt\">";
  mostrarTexto ("Lista de CD's de música [ " . $nombreusuario . " ]","");
  //formulario para buscar
  echo "<form method=\"POST\">
          Introduzca el título a buscar:<input type=\"text\" name=\"txtBuscar\" size=\"36\">
          <input type=\"submit\" value=\"Buscar\" name=\"opBuscar\"></p>
        </form>";
  //listar todos los CDs
  conectarbd ("bd");
  $sql = $sql . " LIMIT " . $ver . ", 50";
  $result = mysql_query($sql);
  while ($row = mysql_fetch_array($result))
  {
    echo "<tr>";
    echo "<td><font face=\"verdana\">" . $row["Referencia"] . "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["Grupo"] . "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["Titulo"] . "</font></td>";
    if ($tipousuario == "Administrador")
    {
      echo "<td><font face=\"verdana\"> <a href=\"cstitulosmodificar.php?codigotitulo=" .
          $row["Referencia"] . "&nombretitulo=" . $row["Titulo"] .
          "\">Modificar</a></font></td>";
    }
    $numero = $numero + 1;
  }
  echo "<tr><td colspan=\"15\"><font face=\"verdana\"><b>Número: " .
      $numero . "</b></td></tr>";
  $ver = $ver + 50;
  if ($ver <= $numero)
  {
    echo "<tr><td colspan=\"15\"><font face=\"verdana\"><a href=\"csmusicaver.php?ver=" .
          $ver . "&numero=" . $numero ."\">Siguiente</a></td></tr>";
  }
  $veranterior = $ver - 50;
  if ($veranterior > 0)
  {
    echo "<tr><td colspan=\"15\"><font face=\"verdana\"><a href=\"csmusicaver.php?veranterior=" .
          $veranterior . "\">Anterior</a></td></tr>";
  }
?>

</table>
</form>

</body>

</html>
