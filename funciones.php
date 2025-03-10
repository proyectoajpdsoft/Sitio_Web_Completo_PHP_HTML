<?
  $encabezadoerror = "<font size=\"2\" color=\"#008080\"><span style=\"font-family:
      Arial\"><b>Error</span></b></font><hr size=2 width=\"100%\" align=center>";
  $encabezadoaviso = "<font size=\"2\" color=\"#008080\"><span style=\"font-family:
        Arial\"><b>Aviso</span></b></font><hr size=2 width=\"100%\"align=center>";

  //muestra encabezado y texto y continúa la ejecución
  function mostrarTexto ($textoTitulo, $textoMensaje)
  {
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
//    $tipoletranormal = "<font face=\"verdana\" style=\"font-size: 10pt\">";
    $encabezado = "<font size=\"2\" color=\"#008080\"><span style=\"font-family:
        Arial\"><b>" . $textoTitulo . "</span></b></font><hr size=2 width=\"100%\"align=center>";
    echo $encabezado . $textoMensaje;
  }

  //muestra encabezado y texto y finaliza la ejecución
  function mostrarTextoError ($textoTitulo, $textoMensaje)
  {
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
//    $tipoletranormal = "<font face=\"verdana\" style=\"font-size: 10pt\">";
    $encabezado = "<font size=\"2\" color=\"#008080\"><span style=\"font-family:
        Arial\"><b>" . $textoTitulo . "</span></b></font><hr size=2 width=\"100%\"align=center>";
    die ($encabezado . $textoMensaje);
  }

  //para conectarse a la base de datos
  function conectarbd($bd)
  {
//    $tipoletranormal = "<font face=\"verdana\" style=\"font-size: 10pt\">";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
    $encabezadoerror = "<font size=\"2\" color=\"#008080\"><span style=\"font-family:
        Arial\"><b>Error</span></b></font><hr size=2 width=\"100%\" align=center>";
    $link = @mysql_connect("localhost", "root","aaaa")
      or die ("<br>" . $encabezadoerror . $tipoletranormal .
      "No se pudo conectar a la base de datos, inténtelo en otro momento.");
    @mysql_select_db($bd, $link)
      or die ($encabezadoerror . $tipoletranormal .
      "No se pudo conectar a la base de datos, inténtelo en otro momento.");
  }
  
  //obtiene la hora actual (formato: H:M:S)
  function horaactual()
  {
    $num = 0;
    foreach (localtime() as $valor)
    {
      if($num == 0) //segundo
      {
        $segundo = $valor;
      }
      if($num == 1) //minuto
      {
        $minuto = $valor;
      }
      if($num == 2) //hora
      {
        $hora = $valor;
      }
      $num++;
    }
    $hora = $hora . ":" . $minuto . ":" . $segundo;
    return $hora;
  }

  //obtiene la fecha actual (formato: aaaa:mm:dd)
  function fechaactual()
  {
    $dia = date ("d");
    $mes = date ("m");
    $ano = date ("Y");
    $fecha = $ano . "-" . $mes . "-" . $dia;
    return $fecha;
  }
  
  //obtiene el tipo de usuario según el código
  function tipoUsuario($codigousuario)
  {
    conectarbd ("gestionintegral");
    $sqlConsulta = "SELECT tipo, codigo FROM usuarios WHERE codigo = " .
        $codigousuario;
    $sqlResultado = mysql_query($sqlConsulta);
    if ($row = mysql_fetch_array($sqlResultado))
    {
      return $row["tipo"];
    }
    else
    {
      return "0";
    }
  }

  //comprueba si existe un usuario
  function existeUsuario($codigousuario)
  {
    conectarbd ("bd");
    $sqlConsulta = "SELECT codigo, email FROM usuarios WHERE codigo = " .
        $codigousuario;
    $sqlResultado = mysql_query($sqlConsulta);
    if ($row = mysql_fetch_array($sqlResultado))
    {
      return $row["email"];
    }
    else
    {
      return "0";
    }
  }

  //se le pasa como parámetro un 0 ó 1 y devuelve Sí o No
  function SiNo ($valor)
  {
    if ($valor == 1)
    {
      return "Sí";
    }
    else
    {
      return "No";
    }
  }

  //muestra el detalle de una incidencia para imprimir
  function detalleincidencia($codigo, $tipo, $fecha, $programa, $estado, $usuario,
      $comentario, $fecharesolucion, $comentarioresolucion, $resuelta)
  {
    echo "<font size=\"2\" color=\"#008080\">
      <span style=\"font-family: Arial\">
      <b>DETALLE DE LA INCIDENCIA: " . $codigo .
                  "</span></font><hr size=2 width=\"100%\" align=center>";
            echo "<table border=\"2\" cellpadding=\"2\" style=\"border-collapse: collapse\" bordercolor=\"#808080\" width=\"100%\" id=\"AutoNumber1\" cellspacing=\"0\">
            <tr>
            <td width=\"21%\"><b><font face=\"Verdana\" size=\"2\">Código</font></b></td>
            <td width=\"79%\"><font face=\"Verdana\" size=\"2\">" .
            $codigo . "</font></td>" . "
            </tr>
            <tr>
            <td width=\"21%\"><b><font face=\"Verdana\" size=\"2\">Tipo</font></b></td>
            <td width=\"79%\"><font face=\"Verdana\" size=\"2\">" .
            $tipo . "</font></td>" . "
            </tr>
            <tr>
            <td width=\"21%\"><b><font face=\"Verdana\" size=\"2\">Fecha</font></b></td>
            <td width=\"79%\"><font face=\"Verdana\" size=\"2\">" .
            $fecha . "</font></td>" . "
            </tr>
            <tr>
            <td width=\"21%\"><b><font face=\"Verdana\" size=\"2\">Programa</font></b></td>
            <td width=\"79%\"><font face=\"Verdana\" size=\"2\">" .
            $programa . "</font></td>" . "
            </tr>
            <tr>
            <td width=\"21%\"><b><font face=\"Verdana\" size=\"2\">Estado</font></b></td>
            <td width=\"79%\"><font face=\"Verdana\" size=\"2\">" .
            $estado . "</font></td>" . "
            </tr>
            <tr>
            <td width=\"21%\"><b><font face=\"Verdana\" size=\"2\">Resuelta</font></b></td>
            <td width=\"79%\"><font face=\"Verdana\" size=\"2\">" .
            $resuelta . "</font></td>" . "
            </tr>
            <tr>
            <td width=\"100%\" colspan=\"2\"><b><font face=\"Verdana\" size=\"2\">Descripción</font></b></td>
            </tr>
            <tr>
            <td width=\"100%\" colspan=\"2\" align=\"left\"><font face=\"Verdana\" size=\"2\">" .
            $comentario . "
            </font></td>
            </tr>
            <tr>
            <td width=\"21%\"><b><font face=\"Verdana\" size=\"2\">Fecha resol.</font></b></td>
            <td width=\"79%\"><font face=\"Verdana\" size=\"2\">" .
            $fecharesolucion . "</font></td>" . "
            </tr>
            <tr>
            <td width=\"100%\" colspan=\"2\"><b><font face=\"Verdana\" size=\"2\">Comentario resolución</font></b></td>
            </tr>
            <tr>
            <td width=\"100%\" colspan=\"2\" align=\"left\"><font face=\"Verdana\" size=\"2\">" .
            $comentarioresolucion . "
            </font></td>
            </tr>
            </table>";
            echo "<form><input type=\"button\" name=\"Imprimir\" value=\"Imprimir\" onclick=\"window.print();\"></form>";
  }
  
  
  function subirFTP ($servidor, $usuario, $contrasena, $archivoservidor, $archivolocal)
  {
//    $tipoletranormal = "<font face=\"verdana\" style=\"font-size: 10pt\">";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
    $encabezadoerror = "<font size=\"2\" color=\"#008080\"><span style=\"font-family:
        Arial\"><b>Error</span></b></font><hr size=2 width=\"100%\" align=center>";
    $ftp = @ftp_connect($servidor)
        or die ($encabezadoerror .
        "No se ha podido conectar al servidor. Inténtelo en otro momento.
        <A href=\"javascript:history.back();\">Volver atrás");
    @ftp_login ($ftp, $usuario, $contrasena)
        or die ("La conexión ha sido rechazada, es posible que no tenga permisos suficientes
        para realizar esta operación. Consulte al administrador enviando un
        mensaje a: mailto:incidencias@ajpdsoft.com");
    $a = @ftp_put ($ftp, $archivoservidor, $archivolocal, FTP_BINARY);
    if ($a == 1)
    {
      ftp_quit($ftp);
      return true;
    }
    else
    {
      ftp_quit($ftp);
      return false;
    }
  }
  
  function enviarEMail($destinatario, $titulo, $mensaje, $remiteEMail, $remiteNombre)
  {
    $cabecera = "From: " . $remitenteNombre . "<" . $remiteEMail . ">\n";
    if(mail($destinatario, $titulo, $mensaje, $cabecera))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  
  
  //iniciamos la sesión para LOGIN
  function iniciarSesionUsuario()
  {
    session_register('codigousuario');
    session_register('codigousuariopropio');
    session_register('tipousuario');
    session_register('nombreusuario');
    session_register('emailusuario');
    session_register('fechaultimoacceso');
    session_encode();
  }


  //iniciar sesión para las demás páginas
  function iniciarSesionPaginas()
  {
    @session_start();

    //$tipoletranormal = "<font face=\"verdana\" style=\"font-size: 10pt\">";
    $encabezadoaviso = "<font size=\"2\" color=\"#008080\"><span style=\"font-family: Arial\"><b>Aviso</b></span></font><hr size=2 width=\"100%\" align=center>";
    $encabezadoerror = "<font size=\"2\" color=\"#008080\"><span style=\"font-family: Arial\"><b>Error</span></b></font><hr size=2 width=\"100%\" align=center>";

    if (!(session_is_registered('codigousuario')))
    {
      @session_unset();
      @session_destroy();
      echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
      die($encabezadoerror .
          "Debe inciar la sesión o registrarse (si no lo ha hecho).<br>
          <A target=\"_blank\" href=\"login.html\">Iniciar sesión</A><br>
          <A href=\"registro.html\">Registrar usuario</A>");
    }
  }
?>
