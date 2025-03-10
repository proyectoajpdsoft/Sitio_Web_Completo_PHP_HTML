<?
  include ("funciones.php");
  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  if ($tipousuario != "Administrador")  //si no es el administrador
  {
    mostrarTextoError("Error de acceso", "No tiene permisos para realizar esta operación.");
  }

  if ($opCambiar) //si se ha pulsado cambiar tipo
  {
    if (empty($codigocambiartipo) || $codigocambiartipo == "")
    {
      mostrarTextoError ("Error",
          "Debe introducir el código del usuario para cambiar el tipo
           <A href=\"javascript:history.back();\">Volver a intentarlo");
    }
    else
    {
      //comprobar si el usuario existe
      conectarbd ("bdajpdsoft");
      $sql = "SELECT codigo, tipo, nombre
              FROM usuarios
              WHERE codigo = '" . $codigocambiartipo . "'";
      $result = mysql_query($sql);
      if ($row = mysql_fetch_array($result))
      {
        //existe
        $nombreusuario = $row["nombre"];
        $sql = "UPDATE usuarios SET " .
            "tipo='" . $opTipoUsuario . "'" .
            "WHERE codigo='" . $codigocambiartipo . "'";
        $result = mysql_query($sql);
        if (!($result))
        {
          mostrarTextoError ("Error", "No se ha podido cambiar el tipo de
              usuario a " . $nombreusuario . ", inténtelo en otro momento.");
        }
        else
        {
          mostrarTexto ("Proceso realizado",
              "El tipo del usuario " . $nombreusuario .
              " ha sido cambiado correctamente a " . $opTipoUsuario);
        }
      }
      else
      {
        mostrarTextoError ("Error",  "No existe ningún usuario con el
            código: " . $codigocambiartipo
            .  "    <A href=\"javascript:history.back();\">Volver a intentarlo");
       }
    }
  }

  if ($opAsignar) //si se ha pulsado asignar
  {
    if (empty($codigoasignar) || $codigoasignar == "")
    {
      mostrarTextoError ("Error", "Debe introducir el código del usuario a
          asignar  <A href=\"javascript:history.back();\">Volver a intentarlo");
    }
    else
    {
      //comprobar si existe el usuario
      conectarbd ("bdajpdsoft");
      $sql = "SELECT codigo, nombre, tipo FROM usuarios WHERE codigo = '" .
          $codigoasignar . "'";
      $result = mysql_query($sql);
      if ($row = mysql_fetch_array($result))
      {
        //existe
        $nombreusuario = $row["nombre"];
        $sql = "INSERT INTO usuariosprograma (codigoprograma, codigousuario)";
        $sql .= "VALUES ('$opCodigoProgramaAsignar', '$codigoasignar')";
        $result = mysql_query($sql);
        if (!($result))
        {
          mostrarTextoError ("Error",  "No se ha podido asignar el programa " .
              $opCodigoProgramaAsignar .
              " al usuario " . $nombreusuario . ", inténtelo en otro momento.");
        }
        else
        {
          mostrarTexto ("Proceso realizado",  "El programa " .
              $opCodigoProgramaAsignar .
              " ha sido asignado correctamente a " . $nombreusuario . "\n");
        }
      }
      else
      {
        mostrarTextoError ("Error",  "No existe ningún usuario con el
            código: " . $codigoasignar
            .  "    <A href=\"javascript:history.back();\">Volver a intentarlo");
       }
    }
  }

  if ($opEliminar) //si se ha pulsado Eliminar
  {
    if (empty($codigoeliminar) || $codigoeliminar =="")
    {
      mostrarTextoError ("Error",
          "Debe introducir el código del usuario a
          eliminar  <A href=\"javascript:history.back();\">Volver a intentarlo");
    }
    else
    {
      //eliminar usuario
      conectarbd ("bdajpdsoft");
      $sql = "DELETE FROM usuarios WHERE codigo = '" . $codigoeliminar . "'";
      $result = mysql_query($sql);
      mostrarTexto ("Proceso realizado",
          "El usuario " . $codigoeliminar . " ha sido eliminado correctamente.");
    }
  }
  echo ("<br><p align=\"center\"> <A href=\"javascript:history.back();\">Volver atrás");
?>
