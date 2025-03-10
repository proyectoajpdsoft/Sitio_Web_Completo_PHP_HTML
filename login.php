<?
  include ("funciones.php");
  $tipoletranormal = "<font face=\"verdana\" style=\"font-size: 10pt\">";
  $encabezadoaviso = "<font size=\"2\" color=\"#008080\"><span style=\"font-family: Arial\"><b>Aviso</b></span></font><hr size=2 width=\"100%\" align=center>";
  $encabezadoerror = "<font size=\"2\" color=\"#008080\"><span style=\"font-family: Arial\"><b>Error</span></b></font><hr size=2 width=\"100%\" align=center>";
  //comprobando la contraseña
  if (!isset($password))
  {
    die ($encabezadoerror . $tipoletranormal .
        "No ha introducido la contraseña.
        <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
  }
  if (empty($password))
  {
    die ($encabezadoerror . $tipoletranormal .
        "No ha introducido la contraseña.
        <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
  }
  if ((strlen($password) < 5)  || (strlen($password) > 15))
  {
    die ($encabezadoerror . $tipoletranormal .
        "La longitud de la contraseña no es válida (entre 5 y 15 caracteres).
        <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
  }
  conectarbd ("bd");
  //se selecciona el código de cliente y se extraen los datos
  $sqlConsulta = "
      SELECT contrasena, nombre, tipo, codigo, numerovisitas
      FROM usuarios
      WHERE codigo = " . $codigousuario;
  $sqlResultado = mysql_query($sqlConsulta);
  if ($row = mysql_fetch_array($sqlResultado))
  {
    if ($password != $row["contrasena"])
    {
      die ($encabezadoerror . $tipoletranormal .
          "La contraseña introducida no coincide con la del usuario.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
  }
  else
  {
    die ($encabezadoerror . $tipoletranormal .
    "El código de usuario introducido no coincide con
    ninguno de los existentes.
    <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
  }
  $tipousuario = $row["tipo"];

  //actualizar la hora, la fecha de la visita y el contador de visitas
  $nvisitas = $row["numerovisitas"];
  $nvisitas = $nvisitas + 1;
  $sql = "UPDATE usuarios SET " .
      "fechaultimavisita='" . fechaactual() . "'," .
      "horaultimavisita='" . horaactual() . "'," .
      "numerovisitas='" . $nvisitas . "'" .
      "WHERE codigo='" . $codigousuario . "'";
  $result = mysql_query($sql);
  
  //según el usuario mostrar página personal
  $encabezadopersonal = "<font size=\"2\" color=\"#008080\"><span style=\"font-family: Arial\">Iniciada sesión: "
      . $row["nombre"] . "</span></font><hr size=2 width=\"100%\" align=center>";
  echo $encabezadopersonal;
  echo $tipoletranormal . "<br>Seleccione la tarea a realizar:<br><br>";
  if ($tipousuario == "Administrador")  //si es el administrador
  {
    echo $tipoletranormal . "<A href=\"programaalta.php\">Añadir programa</A><br>";
    echo $tipoletranormal . "<A href=\"usuariover.php?codigousuario=" .
        $codigousuario . "\">Lista de usuarios</A><br>";
    echo $tipoletranormal . "<A href=\"usuariogestionar.php?codigousuario=" .
        $codigousuario . "\">Gestionar usuarios</A><br>";
    echo $tipoletranormal . "<A href=\"programaver.php?codigousuario=" .
        $codigousuario . "\">Lista de programas</A><br>";
  }
  echo $tipoletranormal . "<A href=\"incidenciagestionar.php?codigousuario=" .
      $codigousuario . "\">Gestión de Incidencias de programas</A><br>";
  echo $tipoletranormal . "<br><A href=\"usuariodatos.php?" .
      "codigo=" . $codigousuario . "\">Cambiar datos del usuario</A><br>";
  echo $tipoletranormal . "<br><A href=\"usuarioeliminar.php?" .
      "codigo=" . $codigousuario . "\">Eliminar usuario</A><br>";
  echo $tipoletranormal . "<br><A href=\"ficherosubir.php?codigousuario=" .
      $codigousuario . "\">Subir un fichero (para resolver incidencias,
      para copia de seguridad, ...)</A><br>";

  //hipervínculo para adquirir programa
  echo $tipoletranormal . "<br><A href=\"programacomprar.php?codigousuario=" .
      $codigousuario . "\">Comprar un programa</A><br>";

  if ($tipousuario == "Pago" | $tipousuario == "Pago-Lista" |
      $tipousuario == "Administrador")  //si es de pago
  {
    //pondremos un hipervinculo para configuracion.ini por cada programa
    //que tenga registrado
    if ($tipousuario == "Administrador")  //si es el administrador (todos)
    {
      $sqlConsulta = "
          SELECT codigoprograma, codigousuario, programas.nombre NombrePrograma
          FROM usuariosprograma, programas
          WHERE programas.codigo=usuariosprograma.codigoprograma";
    }
    else
    {
      $sqlConsulta = "
          SELECT codigoprograma, codigousuario, programas.nombre NombrePrograma
          FROM usuariosprograma, programas
          WHERE programas.codigo=usuariosprograma.codigoprograma AND
          codigousuario = " . $codigousuario;
    }
    $sqlResultado = mysql_query($sqlConsulta);
    while ($row = mysql_fetch_array($sqlResultado))
    {
      echo "<b><br> * Para realizar actualizaciones automáticas de " .
          $row["NombrePrograma"] . ", descargue estos dos ficheros en
          la misma carpeta y ejecute el fichero: \"actualizar.exe\":</b>";
      echo $tipoletranormal . "<br><A href=\"httpdocs/usuactualiza/actualizar.exe\">
          Pulse aquí para descargar el fichero ejecutable</A><br>";
      echo $tipoletranormal . "<A href=\"httpdocs/usuactualiza/programa/" .
          $row["codigoprograma"] . "/configuracion.ini\">
          Pulse aquí para descargar el fichero de configuración</A><br>";
    }
  }

  //mostrar hipervínculo para lista de CD's
  if ($tipousuario == "Lista" | $tipousuario == "Pago-Lista"
      | $tipousuario == "Usuario-Lista" | $tipousuario == "Administrador")
  {
    echo $tipoletranormal . "<br><A href=\"cddatosver.php?codigousuario=" .
        $codigousuario . "\">Lista de CD's de datos</A><br>";
  }
?>
