<?
  include "funciones.php";
  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  if ($opSubir)
  {
    if (subirFTP ("ftp.ajpdsoft.com", "subir", "aaa",
        $subira, $ficherosubir) == True)
    {
      conectarbd("bd");
      $sql = "SELECT codigo
              FROM ficherossubidos
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
      $sql = "INSERT INTO ficherossubidos (codigo, codigousuario, ficherolocal,
          ficheroservidor, fecha, hora, codigoincidencia, comentario)";
      $sql .= "VALUES ('$codigo', '$codigousuario', '$ficherosubir',
          '$subira', '$fecha', '$hora',  '$codigoincidencia', '$comentario')";
      $result = mysql_query($sql);
      if (!($result))
      {
        mostrarTextoError ("Error",
            "El Fichero " . $ficherosubir .
            " ha sido subido correctamente a nuestro servidor con el nombre " .
            $subira . ". Aunque no se ha podido guardar el fichero
            subido en nuestra base de datos.");
      }
      else
      {
        mostrarTexto ("Aviso", "El Fichero ha sido subido correctamente a
            nuestro servidor con el nombre " .
            $subira .
            ".<br><br> Gracias por su colaboración y perdone las molestias.");
      }
    }
    else
    {
      mostrarTexto ("Error", "No se ha podido subir el fichero, inténtelo en
          otro momento o pruebe a cambiar el nombre al fichero.");
    }
  }
  else
  {
    mostrarTexto ("Subir fichero [ " . $nombreusuario . " ]", "<br>Seleccione el fichero que desee subir a
        nuestro servidor para su posterior supervisión (imágenes de captura de
        pantalla, ficheros de bases de datos, ficheros log de errores, ...)");
    echo "<form enctype=multipart/form-data method=post action=ficherosubir.php>
        1. Seleccione el fichero de su equipo que desee subir a nuestro servidor:<br>
        <input type=File name=ficherosubir size=50>
        <br><br>2. Introduzca un nombre para el fichero (este nombre será el que nosotros veamos):<br>
        <input type=text name=subira size=50 value=\"" . "fichero" .
        $codigousuario . ".jpg\">
        <br><br>3. Comentario:<br>
        <textarea name=\"comentario\" cols=\"64\" rows=\"5\"></textarea></td>
        <br><br>4.<INPUT TYPE=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"2097152\">
        <input type=submit name=opSubir value=\"Subir fichero\">";
  }
?>
