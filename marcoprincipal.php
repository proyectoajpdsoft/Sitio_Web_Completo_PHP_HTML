<?
  session_start();
  echo "<html>
      <head>
      <title>Sesión iniciada - AjpdSoft</title>
      </head>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
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
      SELECT contrasena, nombre, tipo, codigo, codigousuario,
      numerovisitas, email, fechaultimavisita
      FROM usuarios
      WHERE codigousuario = '" . $codigousuario . "'";
  $sqlResultado = mysql_query($sqlConsulta);
  if (@$row = mysql_fetch_array($sqlResultado))
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
        "El código de usuario introducido no es correcto.
        <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
  }
  $tipousuario = $row["tipo"];
  $nombreusuario = $row["nombre"];
  $contrasenausuario = $row["contrasena"];
  $emailusuario = $row["email"];
  $fechaultimoacceso = $row["fechaultimavisita"];
  $codigousuario = $row["codigo"]; //el codigo generado automaticamente
  $codigousuariopropio = $row["codigousuario"]; //el codigo que el usuario ha introducido

  //actualizar la hora, la fecha de la visita y el contador de visitas
  $nvisitas = $row["numerovisitas"];
  $nvisitas = $nvisitas + 1;
  $sql = "UPDATE usuarios SET " .
      "fechaultimavisita='" . fechaactual() . "'," .
      "horaultimavisita='" . horaactual() . "'," .
      "numerovisitas='" . $nvisitas . "'" .
      "WHERE codigo='" . $codigousuario . "'";
  $result = mysql_query($sql);
  iniciarSesionUsuario();
?>

<frameset cols="125,*">
  <frame name="contenido" target="principal" src="menuprincipal.php">
  <frame name="principal" src="inicio.php">
  <noframes>
  <body>

  <p>Esta página usa marcos, pero su explorador no los admite, <A href=\"menuprincipal.php\">pulse aquí para continuar</A></p>

  </body>
  </noframes>
</frameset>
</html>
