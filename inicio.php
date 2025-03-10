<?
  include ("funciones.php");
  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  //número de no resueltas
  if ($tipousuario == "Administrador")  //si es el administrador
  {
    $sql = "SELECT codigo
            FROM incidencias
            WHERE resuelta=0 AND estado<>'Cancelada'";
  }
  else  //usuario normal
  {
    $sql = "SELECT codigo
            FROM incidencias
            WHERE resuelta=0 AND codigousuario='" . $codigousuario . "'
            AND estado<>'Cancelada'";
  }
  conectarbd("bd");
  $result = mysql_query($sql);
  $noresueltas = mysql_num_rows($result);
  mysql_free_result ($result);
  
  //número de resueltas
  if ($tipousuario == "Administrador")  //si es el administrador
  {
    $sql = "SELECT codigo
            FROM incidencias
            WHERE resuelta=1 AND estado<>'Cancelada'";
  }
  else  //usuario normal
  {
    $sql = "SELECT codigo
            FROM incidencias
            WHERE resuelta=1 AND codigousuario='" . $codigousuario . "'
            AND estado<>'Cancelada'";
  }
  $result = mysql_query($sql);
  $resueltas = mysql_num_rows($result);
  mysql_free_result ($result);

  //número de trucos
  $sql = "SELECT codigo
          FROM trucos";
  $result = mysql_query($sql);
  $numerotrucos = mysql_num_rows($result);
  mysql_free_result ($result);
  
  //número de programas
  $sql = "SELECT codigo
          FROM programas";
  $result = mysql_query($sql);
  $numeroprogramas = mysql_num_rows($result);
  mysql_free_result ($result);

  //número de usuarios
  if ($tipousuario == "Administrador")  //si es el administrador
  {
    $sql = "SELECT codigo
            FROM usuarios";
    $result = mysql_query($sql);
    $numerousuarios = mysql_num_rows($result);
    mysql_free_result ($result);
  }

  //número de peticiones de compra
  if ($tipousuario == "Administrador")  //si es el administrador
  {
    $sql = "SELECT codigo
            FROM peticionescompra";
    $result = mysql_query($sql);
    $numeropeticionescompra = mysql_num_rows($result);
    mysql_free_result ($result);
  }

  //ultimo acceso
  $sql = "SELECT numerovisitas, codigo
          FROM usuarios
          WHERE codigo='" . $codigousuario . "'";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  $numerovisitas = $row["numerovisitas"];
  mysql_free_result ($result);

  echo "
  <table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" width=\"100%\" id=\"AutoNumber1\" align=\"left\" height=\"58\" bgcolor=\"#000000\" bordercolorlight=\"#000000\" bordercolordark=\"#000000\">
  <tr>
    <td width=\"29%\" align=\"center\" bgcolor=\"#0000FF\" height=\"14\">
    <p><b><font face=\"Verdana\" size=\"2\" color=\"#00FF00\">Incidencias pendientes</font></b></td>
    <td width=\"30%\" align=\"center\" bgcolor=\"#0000FF\" height=\"14\"><b>
    <font face=\"Verdana\" size=\"2\" color=\"#00FF00\">
    Incidencias resueltas</font></b></td>
    <td width=\"25%\" align=\"center\" bgcolor=\"#0000FF\" height=\"14\"><b>
    <font face=\"Verdana\" size=\"2\" color=\"#00FF00\">Último
    acceso</font></b></td>
    <td width=\"16%\" align=\"center\" bgcolor=\"#0000FF\" height=\"14\"><b>
    <font face=\"Verdana\" size=\"2\" color=\"#00FF00\">Nº
    accesos</font></b></td>
  </tr>
  <tr>
    <td width=\"29%\" align=\"center\" height=\"3\" bgcolor=\"#C0C0C0\">
    <p><b><font face=\"Verdana\" size=\"2\"><span lang=\"es\">" .
    $noresueltas . "</span></font></b></td>
    <td width=\"30%\" align=\"center\" height=\"3\" bgcolor=\"#C0C0C0\">
    <p><b><font face=\"Verdana\" size=\"2\"><span lang=\"es\">" .
    $resueltas . "</span></font></b></td>
    <td width=\"25%\" align=\"center\" height=\"3\" bgcolor=\"#C0C0C0\">
    <p align=\"center\"><b><font face=\"Verdana\" size=\"2\"><span lang=\"es\">" .
    $fechaultimoacceso . "</span></font></b></td>
    <td width=\"16%\" align=\"center\" height=\"3\" bgcolor=\"#C0C0C0\"><b>
    <font face=\"Verdana\" size=\"2\"><span lang=\"es\">" .
    $numerovisitas . "</span></font></b></td>
  </tr>
  </table>";
  //segunda tabla
  echo " <p>&nbsp;</p> <p>&nbsp;</p>
  <table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" width=\"100%\" id=\"AutoNumber2\" align=\"left\" height=\"58\" bgcolor=\"#000000\" bordercolorlight=\"#000000\" bordercolordark=\"#000000\">
  <tr>
    <td width=\"29%\" align=\"center\" bgcolor=\"#0000FF\" height=\"14\">
     <p><b><font face=\"Verdana\" size=\"2\" color=\"#00FF00\">Trucos</font></b>
    </td>";
    //número de peticiones de compra
    if ($tipousuario == "Administrador")  //si es el administrador
    {
      echo "
        <td width=\"30%\" align=\"center\" bgcolor=\"#0000FF\" height=\"14\"><b>
        <font face=\"Verdana\" size=\"2\" color=\"#00FF00\">Nº de usuarios</font></b>
        </td>";
    }
    echo "
    <td width=\"25%\" align=\"center\" bgcolor=\"#0000FF\" height=\"14\"><b>
    <font face=\"Verdana\" size=\"2\" color=\"#00FF00\">Nº de programas</font></b>
    </td>";
    if ($tipousuario == "Administrador")  //si es el administrador
    {
      echo "
        <td width=\"16%\" align=\"center\" bgcolor=\"#0000FF\" height=\"14\"><b>
        <font face=\"Verdana\" size=\"2\" color=\"#00FF00\">Nº peticiones compra</font></b>
        </td>";
    }
    echo "
  </tr>
  <tr>
    <td width=\"29%\" align=\"center\" height=\"3\" bgcolor=\"#C0C0C0\">
      <p><b><font face=\"Verdana\" size=\"2\"><span lang=\"es\">" .
      $numerotrucos . "</span></font></b>";
    if ($tipousuario == "Administrador")  //si es el administrador
    {
      echo "
      </td>
        <td width=\"30%\" align=\"center\" height=\"3\" bgcolor=\"#C0C0C0\">
        <p><b><font face=\"Verdana\" size=\"2\"><span lang=\"es\">" .
        $numerousuarios . "</span></font></b>
      </td>";
    }
    echo "
    <td width=\"25%\" align=\"center\" height=\"3\" bgcolor=\"#C0C0C0\">
      <p align=\"center\"><b><font face=\"Verdana\" size=\"2\"><span lang=\"es\">" .
      $numeroprogramas . "</span></font></b>
    </td>";
    if ($tipousuario == "Administrador")  //si es el administrador
    {
      echo "
      <td width=\"16%\" align=\"center\" height=\"3\" bgcolor=\"#C0C0C0\"><b>
        <font face=\"Verdana\" size=\"2\"><span lang=\"es\">" .
        $numeropeticionescompra . "</span></font></b>
      </td>";
    }
    echo "
  </tr>
  </table>";
?>
