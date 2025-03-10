<?
  include "funciones.php";
  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  if ($tipousuario != "Administrador")
  {
    mostrarTextoError("Error de acceso", "No tiene permisos para realizar esta operación");
  }

  if ($opNuevoTruco)
  {
    conectarbd("bdajpdsoft");
    //obtenemos el código del último truco
    $sql = "SELECT codigo
            FROM trucos
            ORDER BY codigo DESC";
    $result = mysql_query($sql);
    if ($row = mysql_fetch_array($result))
    {
       $codigo = $row["codigo"];
       $codigo = $codigo + 1;
    }
    else
    {
      $codigo = 1;
    }
    $fecha = fechaactual();
    $hora = horaactual();
    $sql = "INSERT INTO trucos (codigo, titulo, comentario, so, fecha, hora, fichero, codigousuario, tipo, tipousuario)";
    $sql .= "VALUES ('$codigo', '$titulo', '$comentario',
          '$so', '$fecha', '$hora', '$fichero', '$codigousuario', '$tipotruco', '$tipousuariotruco')";
    $result = mysql_query($sql);
    if (!($result))
    {
      mostrarTextoError ("Error",
        "El truco no ha podido añadirse. Inténtelo en otro momento.");
    }
    else
    {
      mostrarTexto ("Operación realizada correctamente",
          "El truco se ha añadido correctamente con el código: " . $codigo);
    }
  }
  else
  {
    mostrarTexto ("Añadir truco [ " . $nombreusuario . " ]",
        "Introduzca los datos del truco:");
    echo "<form method=post action=trucoalta.php>
        Título:<input type=text name=titulo size=90>
        <br>S.O.:<input type=text name=\"so\" size=20>
        <br>Tipo usuario:<select size=\"1\" name=\"tipousuariotruco\">
        <option selected value=\"Básico\">Básico</option>
        <option value=\"Intermedio\">Intermedio</option>
        <option value=\"Avanzado\">Avanzado</option></select>
        <br>Tipo truco:<input type=text name=\"tipotruco\" size=20>
        <br>Comentario:<br>
        <textarea name=\"comentario\" cols=\"68\" rows=\"12\"></textarea></td>
        <br>Fichero:<input type=text name=\"fichero\" size=50>
        <input type=submit name=opNuevoTruco value=\"Añadir truco\">";
  }
?>
