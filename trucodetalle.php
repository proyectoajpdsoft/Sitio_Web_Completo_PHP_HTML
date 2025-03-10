<html>
<body>

<?php
  include ("funciones.php");
  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  conectarbd ("bdajpdsoft");
  $sql = "SELECT *
          FROM trucos
          WHERE codigo=" . $codigotruco;
  $result = mysql_query($sql);
  if (!($result))
  {
    mostrarTextoError ("Error",
        "No se ha encontrado el truco " . $codigotruco .
        ". Inténtelo en otro momento.");
  }
  else
  {
    $row = mysql_fetch_array($result);
    $titulo = $row["titulo"];
    $comentario = $row["comentario"];
    $fichero = $row["fichero"];
    $so = $row["so"];
    mostrarTexto ("Detalle del truco " . $codigotruco . " [ " . $nombreusuario . " ]",
            "<br>");
    echo "<table border=\"2\" cellpadding=\"2\" style=\"border-collapse: collapse\" bordercolor=\"#808080\" width=\"100%\" id=\"AutoNumber1\" cellspacing=\"0\">
        <tr>
        <td width=\"21%\"><b><font face=\"Verdana\" size=\"2\">Título</font></b></td>
        <td width=\"79%\"><font face=\"Verdana\" size=\"2\">" .
        $titulo . "</font></td>" . "
        </tr>
        <tr>
        <td width=\"21%\"><b><font face=\"Verdana\" size=\"2\">S.O.</font></b></td>
        <td width=\"79%\"><font face=\"Verdana\" size=\"2\">" .
        $so . "</font></td>" . "
        </tr>
        <tr>
        <td width=\"21%\"><b><font face=\"Verdana\" size=\"2\">Fichero</font></b></td>
        <td width=\"79%\"><font face=\"Verdana\" size=\"2\">" .
        $fichero . "</font></td>" . "
        </tr>
        <tr>
        <td width=\"21%\"><b><font face=\"Verdana\" size=\"2\">Comentario</font></b></td>
        <td width=\"79%\"><font face=\"Verdana\" size=\"2\">\"
        </tr>
        <tr>
        <td width=\"100%\" colspan=\"2\" align=\"left\"><font face=\"Verdana\" size=\"2\">" .
        $comentario . "
        </font></td>
        </tr>
        </table>";
    echo "<form><input type=\"button\" name=\"Imprimir\" value=\"Imprimir\" onclick=\"window.print();\"></form>";
  }
?>

</form>

</body>

</html>
