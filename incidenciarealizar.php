<?
  include ("funciones.php");

  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  conectarbd("bd");
  if ($opCancelar) //si se ha pulsado cancelar
  {
    if (empty($codigocancelar) || $codigocancelar == "")
    {
      mostrarTextoError ("Error",
          "Debe introducir el código de la incidencia a cancelar
            <A href=\"javascript:history.back();\">Volver a intentarlo");
    }
    else
    {
      //comprobar si la incidencia existe y si es del usuario actual
      if  ($tipousuario == "Administrador") //si es el administrador todas las incidencias
      {
        $sql = "SELECT codigo, codigousuario, estado
                FROM incidencias
                WHERE codigo = '" . $codigocancelar . "'";
      }
      else
      {
        $sql = "SELECT codigo, codigousuario, estado
                FROM incidencias
                WHERE codigo = '" . $codigocancelar .
                "' AND codigousuario='" . $codigousuario . "'";
      }
      $result = mysql_query($sql);
      if ($row = mysql_fetch_array($result))
      {
        //existe y es del usuario, la cancelamos
        $sqla = "UPDATE incidencias SET " .
                "estado='Cancelada'" .
                "WHERE codigo='" . $codigocancelar . "'";
        $resulta = mysql_query($sqla);
        if (!($resulta))
        {
          mostrarTextoError("Error",
              "No se ha podido cancelar la incidencia " . $codigocancelar .
              ", inténtelo en otro momento.");
        }
        else
        {
          $mensaje = "Se ha cancelado una incidencia: \n\n" .
              "Código incidencia: " . $codigocancelar .
              "\r\nCódigo Usuario: " . $codigousuario .
              "\r\nNombre Usuario: " . $nombreusuario;

          $from = 'incidencias@ajpdsoft.com';
          $headers = "From: $from";
          $resultado = @mail("incidencias@ajpdsoft.com",
              "Incidencia CANCELADA: " . $codigocancelar, $mensaje, $headers);

          mostrarTexto ("Proceso realizado",
              "La incidencia " . $codigocancelar . " ha sido cancelada correctamente.");
        }
      }
      else
      {
        mostrarTextoError ("Error",
            "No existe ninguna incidencia con el código: " . $codigocancelar
            .  "    <A href=\"javascript:history.back();\">Volver a intentarlo");
      }
    }
  }

  if ($opReactivar) //si se ha pulsado reactivar
  {
    if (empty($codigoreactivar) || $codigoreactivar == "")
    {
      mostrarTextoError ("Error",
          "Debe introducir el código de la incidencia a
          reactivar  <A href=\"javascript:history.back();\">Volver a intentarlo");
    }
    else
    {
      //comprobar si la incidencia existe y si es del usuario actual
      if  ($tipousuario == "Administrador") //si es el administrador todas las incidencias
      {
        $sql = "SELECT codigo, codigousuario, estado, resuelta
                FROM incidencias
                WHERE codigo = '" . $codigoreactivar . "'";
      }
      else
      {
        $sql = "SELECT codigo, codigousuario, estado, resuelta
                FROM incidencias
                WHERE codigo = '" . $codigoreactivar .
                "' AND codigousuario='" . $codigousuario . "'";
      }
      $result = mysql_query($sql);
      if ($row = mysql_fetch_array($result))
      {
        //existe y es del usuario, la reactivamos
        $sqla = "UPDATE incidencias SET " .
                "estado='Pendiente resolución'" . "," .
                "resuelta=0" . "," .
                "fecharesolucion=''" .
                "WHERE codigo='" . $codigoreactivar . "'";
        $resulta = mysql_query($sqla);
        if (!($resulta))
        {
          mostrarTextoError ("Error",
              "No se ha podido reactivar la incidencia " . $codigoreactivar .
              ", inténtelo en otro momento.");
        }
        else
        {
          $mensaje = "Se ha reactivado una incidencia: \n\n" .
              "Código incidencia: " . $codigoreactivar .
              "\r\nCódigo Usuario: " . $codigousuario .
              "\r\nNombre Usuario: " . $nombreusuario;
              
          $from = 'incidencias@ajpdsoft.com';
          $headers = "From: $from";
          $resultado = @mail("incidencias@ajpdsoft.com",
              "Incidencia REACTIVADA: " . $codigoreactivar, $mensaje, $headers);
          mostrarTexto ("Proceso realizado",
              "La incidencia  " . $codigoreactivar . "  ha sido reactivada correctamente.");
        }
      }
      else
      {
        mostrarTextoError ("Error",
            "No existe ninguna incidencia con el código: " . $codigoreactivar
            .  "    <A href=\"javascript:history.back();\">Volver a intentarlo");
      }
    }
  }

  if ($opDetalle) //si se ha pulsado Detalle
  {
    if (empty($codigodetalle) || $codigodetalle =="")
    {
      mostrarTextoError ("Error",
          "Debe introducir el código de la incidencia a mostrar
          <A href=\"javascript:history.back();\">Volver a intentarlo");
    }
    else
    {
      if  ($tipousuario == "Administrador") //si es el administrador todas las incidencias
      {
        //comprobar si la incidencia existe y si es del usuario actual
        $sql = "SELECT incidencias.*, programas.nombre NombrePrograma
                FROM incidencias, programas
                WHERE incidencias.codigo = '" . $codigodetalle . "'
                AND programas.codigo=incidencias.codigoprograma";
      }
      else
      {
        //comprobar si la incidencia existe y si es del usuario actual
        $sql = "SELECT incidencias.*, programas.nombre NombrePrograma
                FROM incidencias, programas
                WHERE incidencias.codigo = '" . $codigodetalle . "'
                AND incidencias.codigousuario='" . $codigousuario .
                "' AND programas.codigo=incidencias.codigoprograma";
      }
      $result = mysql_query($sql);
      if ($row = mysql_fetch_array($result))
      {
        //existe y es del usuario y no está cancelada
        if ($row["estado"] == "Cancelada")
        {
          mostrarTextoError ("Error",
              "La incidencia seleccionada está cancelada.  " .
              "<A href=\"javascript:history.back();\">Atrás");
        }
        else
        {
          //mostramos la incidencia
          detalleincidencia($row["codigo"], $row["tipo"], $row["fecha"],
              $row["NombrePrograma"], $row["estado"], $nombreusuario,
              $row["comentario"], $row["fecharesolucion"],
              $row["comentarioresolucion"], SiNo($row["resuelta"]));
        }
      }
      else
      {
        mostrarTextoError ("Error",
            "No existe ninguna incidencia con el código: " . $codigodetalle
            .  "    <A href=\"javascript:history.back();\">Volver a intentarlo");
      }
    }
  }


  if ($opEstado) //si se ha pulsado Estado
  {
    if (empty($codigoestado) || $codigoestado =="")
    {
      mostrarTextoError ("Error",
          "Debe introducir el código de la incidencia a
          mostrar  <A href=\"javascript:history.back();\">Volver a intentarlo");
    }
    else
    {
      //comprobar si la incidencia existe y si es del usuario actual
      if  ($tipousuario == "Administrador") //si es el administrador todas las incidencias
      {
        $sql = "SELECT estado, resuelta, fecharesolucion, comentarioresolucion
                FROM incidencias
                WHERE codigo = '" . $codigoestado . "'";
      }
      else
      {
        $sql = "SELECT estado, resuelta, fecharesolucion, comentarioresolucion
                FROM incidencias
                WHERE codigo = '" . $codigoestado . "'
                AND codigousuario='" . $codigousuario . "'";
      }
      $result = mysql_query($sql);
      if ($row = mysql_fetch_array($result))
      {
        //mostramos la incidencia
        mostrarTexto ("Proceso realizado", "");
        echo "<b><u>INCIDENCIA:</u></b> " . $codigoestado .
            "<br><b>Estado:</b> " . $row["estado"] .
            "<br><b>  Resuelta:</b> " . SiNo($row["resuelta"]);
        if ($row["resuelta"] == 1)
        {
          echo "<br><b>  Fecha resolución:</b> " . $row["fecharesolucion"];
          echo "<br><b>  Comentario resolución:</b><br>" . $row["comentarioresolucion"];
        }
      }
      else
      {
        mostrarTextoError ("Error",
            "No existe ninguna incidencia con el código: " . $codigoestado
            .  "    <A href=\"javascript:history.back();\">Volver a intentarlo");
      }
    }
  }

  
  if ($opEliminar) //si se ha pulsado Eliminar
  {
    if (empty($codigoeliminar) || $codigoeliminar =="")
    {
      mostrarTextoError ("Error",
          "Debe introducir el código de la incidencia a
          eliminar  <A href=\"javascript:history.back();\">Volver a intentarlo");
    }
    else
    {
      //comprobar si la incidencia existe y si es del usuario actual
      if  ($tipousuario == "Administrador") //si es el administrador todas las incidencias
      {
        $sql = "SELECT codigo, estado
                FROM incidencias
                WHERE codigo = '" . $codigoeliminar . "'";
      }
      else
      {
        $sql = "SELECT codigo, estado
                FROM incidencias
                WHERE codigo = '" . $codigoeliminar . "' AND codigousuario='"
                . $codigousuario . "'";
      }
      $result = mysql_query($sql);
      if ($row = mysql_fetch_array($result))
      {
        //eliminar incidencia
        $sql = "DELETE FROM incidencias
                WHERE codigo = '" . $codigoeliminar . "'";
        $result = mysql_query($sql);
        mostrarTexto ("Proceso realizado",
            "La incidencia " . $codigoeliminar . " ha sido eliminada correctamente.");
      }
      else
      {
        mostrarTextoError ("Error",
            "No existe ninguna incidencia con el código: " . $codigoeliminar
            .  "    <A href=\"javascript:history.back();\">Volver a intentarlo");
      }
    }
  }

  if ($opEnviar) //si se ha pulsado Enviar
  {
    if (empty($codigoenviar) || $codigoenviar =="")
    {
      mostrarTextoError ("Error",
          "Debe introducir el código de la incidencia a
          mostrar  <A href=\"javascript:history.back();\">Volver a intentarlo");
    }
    else
    {
      //obtener datos de la incidencia
      if  ($tipousuario == "Administrador") //si es el administrador mostrar todas las incidencias
      {
        $sql = "SELECT incidencias.*, programas.nombre NombrePrograma
                FROM incidencias, programas
                WHERE incidencias.codigo = '" . $codigoenviar .
                "' AND programas.codigo=incidencias.codigoprograma";
      }
      else
      {
        $sql = "SELECT incidencias.*, programas.nombre NombrePrograma
                FROM incidencias, programas
                WHERE incidencias.codigo = '" . $codigoenviar .
                "' AND incidencias.codigousuario='" . $codigousuario .
                "' AND programas.codigo=incidencias.codigoprograma";
      }
      $result = mysql_query($sql);
      if ($row = mysql_fetch_array($result))
      {
        //existe y es del usuario y no está cancelada
        if ($row["estado"] == "Cancelada")
        {
          mostrarTextoError ("Error",
              "La incidencia seleccionada está cancelada.  " .
              " <A href=\"javascript:history.back();\">Volver atrás");
        }
        else
        {
          //enviamos la incidencia
          $mensaje = "Código incidencia: " . $row["codigo"] .
            "\r\nEstado: " . $row["estado"] . "\r\nCódigo Usuario: " .
            $codigousuario . "\r\nNombre: " . $nombreusuario . "\r\nE-Mail: " .
            $emailusuario . "\r\nCódigo programa: " . $row["codigoprograma"] .
            "\r\nNombre programa: " . $row["NombrePrograma"] .
            "\r\n*************************\r\nComentario: " .
            $row["comentario"]  .
            "\r\n*************************\r\nComentario Resolución: " .
            $row["comentarioresolucion"] .
            "\r\n\r\n\r\nMás información en http://www.ajpdsoft.com";
          $from = 'incidencias@ajpdsoft.com';
          $headers = "From: $from";
          $resultado = @mail($emailusuario,
              "Incidencia AjpdSoft: " . $row["codigo"], $mensaje, $headers);
          if ($resultado == true)
          {
            mostrarTexto ("Proceso realizado",
                "La incidencia " . $codigoenviar ." ha sido enviada correctamente.");
          }
          else
          {
            mostrarTextoError ("Error",
                "Ha habido errores al intentar enviar la incidencia. La
                incidencia no ha podido ser enviada. Inténtelo en otro momento.");
          }
        }
      }
      else
      {
        mostrarTextoError ("Error",
            "No existe ninguna incidencia con el código: " . $codigoenviar
            .  " <A href=\"javascript:history.back();\">Volver a intentarlo");
      }
    }
  }
  echo ($tipoletranormal .
            "<br><p align=\"center\"> <A href=\"javascript:history.back();\">Volver atrás");
?>
