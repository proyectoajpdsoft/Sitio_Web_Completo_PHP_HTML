<?php
  include ("funciones.php");
  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  //para búsqueda por título
  if (! empty($opBuscar)) //si no se ha pulsado buscar título
  {
    if (empty($txtBuscar))
    {
      mostrarTextoError ("Fantan datos","Debe introducir el texto del título del truco a buscar.");
    }
    else
    {
      $sql = "SELECT *
              FROM trucos
              WHERE upper(Titulo) LIKE '%" . strtoupper($txtBuscar) . "%'
              ORDER BY Codigo";
    }
  }
  else
  {
    if (! empty($opBuscarComentario)) //para búsqueda por comentario
    {
      if (empty($txtBuscarComentario))
      {
        mostrarTextoError ("Fantan datos","Debe introducir el texto del comentario del truco a buscar.");
      }
      else
      {
        $sql = "SELECT *
                FROM trucos
                WHERE Comentario LIKE '%" . $txtBuscarComentario . "%'
                ORDER BY Codigo";
      }
    }
    else
    {
      $sql = "SELECT *
              FROM trucos";
    }
  }

?>

<form method="post" action="trucover.php">
<body bgcolor="#FFFFFF" text="#000000">
<table border="1" cellspacing=1 cellpadding=2 width="100%" style="font-size: 8pt"><tr>

<?
//  if ($tipousuario == "Administrador")  //si es el administrador
//  {
    echo "<td><font face=\"verdana\"><b>Cód.</b></font></td>";
//  }
?>

<td width="50"><span><font face="verdana"><b>Título</b></font></span></td>
<td><font face="verdana"><b>S.O.</b></font></td>
<td><font face="verdana"><b>Ver</b></font></td>


<?
  if ($tipousuario == "Administrador")  //si es el administrador
  {
    echo "<td><font face=\"verdana\"><b>Acción</b></font></td>";
  }
?>

</tr>

<?
  $tipoletranormal = "<font face=\"verdana\" style=\"font-size: 10pt\">";
  mostrarTexto ("Lista de trucos [ " . $nombreusuario . " ]","");
  echo "<form method=\"POST\">
          Título a buscar:<input type=\"text\" name=\"txtBuscar\" size=\"36\">
          <input type=\"submit\" value=\"Buscar\" name=\"opBuscar\"></p>
          Comentario a buscar:<input type=\"text\" name=\"txtBuscarComentario\" size=\"36\">
          <input type=\"submit\" value=\"Buscar\" name=\"opBuscarComentario\"></p>
        </form>";
  //listar todos los trucos
  conectarbd ("bdajpdsoft");
  $result = mysql_query($sql);
  $numero = 0;
  while ($row = mysql_fetch_array($result))
  {
    echo "<tr>";
//    if ($tipousuario == "Administrador")  //si es el administrador
//    {
      echo "<td><font face=\"verdana\">" . $row["codigo"] . "</font></td>";
//    }
    echo "<td><font face=\"verdana\">" . $row["titulo"] . "</font></td>";
    echo "<td><font face=\"verdana\">" . $row["so"] . "</font></td>";
    echo "<td><font face=\"verdana\"> <a href=\"trucodetalle.php?codigotruco=" .
        $row["codigo"] . "\">Ver</a></font></td>";

    //echo "<td><font face=\"verdana\">" . $row["fichero"] . "</font></td>";
    if ($tipousuario == "Administrador")
    {
      echo "<td><font face=\"verdana\"> <a href=\"trucoeditar.php?codigotruco=" .
          $row["codigo"] . "\">Modificar</a></font></td>";
    }
    //echo "</tr><td width=\"100%\" colspan=\"15\"><font face=\"verdana\">" .
    //    $row["comentario"] . "</font></td></tr>";
    $numero++;
  }
  echo "<tr><td colspan=\"15\"><font face=\"verdana\"><b>Número: " .
      $numero . "</b></td></tr>";
?>

</table>
</form>

</body>

</html>
