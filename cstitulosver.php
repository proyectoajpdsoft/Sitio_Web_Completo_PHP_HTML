<html>
<body>

<?php
  include ("funciones.php");
  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  if (empty($ver)) //si es la primera vez que se ejecuta
  {
//    iniciarSesionPaginas();
    $ver = 0;
    $veranterior = 0;
    $numero = 0;
  }

  if (! empty($opBuscar)) //si se ha pulsado buscar por nombre de CD
  {
    if (empty($txtBuscar))
    {
      mostrarTextoError ("Faltan datos","Debe introducir el nombre del CD a buscar.");
    }
    else
    {
      $sql = "SELECT Referencia, Titulo, tipos.Nombre Tipo
              FROM titulos, tipos
              WHERE titulos.IDTipo=tipos.ID AND upper(Titulo) LIKE '%" .
              strtoupper($txtBuscar) . "%'
              ORDER BY Titulo";
    }
  }
  else
  {
    if (! empty($opBuscarPrograma)) //si se ha pulsado buscar por programa
    {
      if (empty($txtBuscarPrograma))
      {
        mostrarTextoError ("Faltan datos",
            "Debe introducir el nombre del programa a buscar.");
      }
      else
      {
        $sql = "SELECT tp.Titulo, tp.Idioma, tp.Comentario , tp.ID, t.Titulo TituloCD
                FROM titulosprogramas tp, titulos t
                WHERE tp.ID= t.Referencia AND upper(tp.Titulo) LIKE '%" .
                strtoupper($txtBuscarPrograma) . "%'
                ORDER BY tp.Titulo";
      }
    }
    else
    {
      $sql = "SELECT Referencia, Titulo, tipos.Nombre Tipo
            FROM titulos, tipos
            WHERE titulos.IDTipo=tipos.ID
            ORDER BY Titulo";
    }
  }
?>

<form method="post" action="cstitulosver.php">
<body bgcolor="#FFFFFF" text="#000000">
<table border="1" cellspacing=1 cellpadding=2 width="100%" style="font-size: 8pt"><tr>
<td width="50"><span><font face="verdana"><b>Ref.</b></font></span></td>
<td><font face="verdana"><b>Título</b></font></td>

<?
  if ($tipousuario == "Administrador")
  {
    if (empty($opBuscarPrograma))
    {
      echo "<td><font face=\"verdana\"><b>Tipo</b></font></td>";
    }
//    echo "<td><font face=\"verdana\"><b>Acción</b></font></td></tr>";
  }
  echo "<td><font face=\"verdana\"><b>Detalle CD</b></font></td>";
  $tipoletranormal = "<font face=\"verdana\" style=\"font-size: 10pt\">";
  mostrarTexto ("Lista de CD's de datos [ " . $nombreusuario . " ]","");
  //formulario para buscar
  echo "<form method=\"POST\">
          Introduzca el título del CD a buscar:<input type=\"text\" name=\"txtBuscar\" size=\"36\">
          <input type=\"submit\" value=\"Buscar\" name=\"opBuscar\"></p>
          Introduzca el nombre del programa a buscar:<input type=\"text\" name=\"txtBuscarPrograma\" size=\"36\">
          <input type=\"submit\" value=\"Buscar\" name=\"opBuscarPrograma\"></p>
        </form>";
  //listar todos los CDs
  conectarbd ("bd");
  $sql = $sql . " LIMIT " . $ver . ", 50";
  $result = mysql_query($sql);
  while ($row = mysql_fetch_array($result))
  {
    echo "<tr>";
    if (empty($opBuscarPrograma))
    {
      echo "<td><font face=\"verdana\">" . $row["Referencia"] . "</font></td>";
    }
    else
    {
      echo "<td><font face=\"verdana\">" . $row["ID"] . "</font></td>";
    }
    echo "<td><font face=\"verdana\">" . $row["Titulo"] . "</font></td>";
    if (empty($opBuscarPrograma))
    {
      echo "<td><font face=\"verdana\">" . $row["Tipo"] . "</font></td>";
      echo "<td><font face=\"verdana\"> <a href=\"cstitulosdetalle.php?codigotitulo=" .
          $row["Referencia"] .  "&nombretitulo=" . $row["Titulo"] .
          "\">Ver</a></font></td>";
    }
    else
    {
      echo "<td><font face=\"verdana\"> <a href=\"cstitulosdetalle.php?codigotitulo=" .
          $row["ID"] .  "&nombretitulo=" . $row["TituloCD"] .
          "\">Ver</a></font></td>";
    }
//    if ($tipousuario == "Administrador")
//    {
//      echo "<td><font face=\"verdana\"> <a href=\"cstitulosmodificar.php?codigotitulo=" .
//          $row["IDTitulo"] . "&nombretitulo=" . $row["Titulo"] .
//          "\">Modificar</a></font></td>";
//    }
    $numero = $numero + 1;
  }
  echo "<tr><td colspan=\"15\"><font face=\"verdana\"><b>Número: " .
      $numero . "</b></td></tr>";
  $ver = $ver + 50;
  if ($ver <= $numero)
  {
    echo "<tr><td colspan=\"15\"><font face=\"verdana\"><a href=\"cstitulosver.php?ver=" .
          $ver . "&numero=" . $numero ."\">Siguiente</a></td></tr>";
  }
  $veranterior = $ver - 50;
  if ($veranterior > 0)
  {
    echo "<tr><td colspan=\"15\"><font face=\"verdana\"><a href=\"cstitulosver.php?veranterior=" .
          $veranterior . "\">Anterior</a></td></tr>";
  }
?>

</table>
</form>

</body>

</html>
