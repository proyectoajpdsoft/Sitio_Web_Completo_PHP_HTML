<html>
<body>

<?php
  include ("funciones.php");
  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  $tipoletranormal = "<font face=\"verdana\" style=\"font-size: 10pt\">";

  conectarbd ("bd");

  $sql = "SELECT *
          FROM titulosprogramas
          WHERE ID='" . $codigotitulo . "'";
  $result = mysql_query($sql);
  if (!($result))
  {
    mostrarTextoError ("Error",
        "El título " . $nombretitulo .
        " está vacío. Inténtelo en otro momento.");
  }
  else
  {
    echo "
    <table border=\"1\" cellspacing=1 cellpadding=2 width=\"100%\" style=\"font-size: 8pt\"><tr>
    <td width=\"50\"><span><font face=\"verdana\"><b>Título</b></font></span></td>
    <td><font face=\"verdana\"><b>S.O.</b></font></td>
    <td><font face=\"verdana\"><b>Idioma</b></font></td>
    <td><font face=\"verdana\"><b>Comentario</b></font></td>";

    mostrarTexto ("Detalle del título " . $nombretitulo . " [ " . $nombreusuario . " ]",
        "<br>");
    while ($row = mysql_fetch_array($result))
    {
      echo "<tr>";
      echo "<td><font face=\"verdana\">" . $row["Titulo"] . "</font></td>";
      echo "<td><font face=\"verdana\">" . $row["SO"] . "</font></td>";
      echo "<td><font face=\"verdana\">" . $row["Idioma"] . "</font></td>";
      echo "<td><font face=\"verdana\">" . $row["Comentario"] . "</font></td>";
      $numero = $numero + 1;
    }
  }
//  echo "<form><input type=\"button\" name=\"Imprimir\" value=\"Imprimir\" onclick=\"window.print();\"></form>";
?>

</form>

</body>

</html>
