<html>
<body>

<?php
  include ("funciones.php");
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  if ($enviar)
  {
    $seguir = true;
    //INICIO VALIDACION DATOS
    if (empty($nombre))
    {
      $seguir = false;
      mostrarTextoError("Error",
          "No ha introducido el Nombre.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    if (empty($codigo))
    {
      $seguir = false;
      mostrarTextoError("Error",
          "No ha introducido el código de usuario.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    elseif (((strlen($codigo) < 5) || (strlen($codigo) > 15)))
    {
      $seguir = false;
      mostrarTextoError("Error",
          "El código de usuario debe ser de más de 5 caracteres y de menos de
          15 caracteres (se pueden introducir números y letras).
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    if (empty($contrasena) || (empty($ccontrasena)))
    {
      $seguir = false;
      mostrarTextoError("Error","No ha introducido la Contraseña. <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    elseif (((strlen($contrasena) < 5) || (strlen($contrasena) > 15)))
    {
      $seguir = false;
      mostrarTextoError("Error",
          "La contraseña debe ser de más de 5 caracteres y de menos de
          15 caracteres (se pueden introducir números y letras).
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    elseif (!($contrasena === $ccontrasena))
    {
      $seguir = false;
      mostrarTextoError("Error",
          "Las contraseñas no coinciden. Debe introducir la contraseña
          dos veces para confirmarla.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }

    if (!isset($email))
    {
      $seguir = false;
      mostrarTextoError("Error", "El E-Mail no es correcto.
          Introdúzcalo correctamente.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    if(empty($email))
    {
      $seguir = false;
      mostrarTextoError("Error", "El E-Mail no es correcto.
          Introdúzcalo correctamente.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    if ( (strlen($email) < 3) || (strlen($email) > 200))
    {
      $seguir = false;
      mostrarTextoError("Error", "El E-Mail es muy largo o muy
          corto.  <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    elseif(!ereg("@",$email))
    {
      $seguir = false;
      mostrarTextoError("Error", "El E-Mail no es correcto,
          no se ha introducido el símbolo de @.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    else
    {
      $seguir = true;
    }
    list($username,$hostname) = split("@",$email);
    if ( (empty($username)) or (empty($hostname)) )
    {
      $seguir = false;
      mostrarTextoError("Error",
          "El E-Mail no es correcto. El nombre de usuario o el nombre
          del servidor no son válidos.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    else
    {
      $seguir = true;
    }
    //comprobar si el email ya existe
    conectarbd ("bdajpdsoft");
    $sql = "SELECT email FROM usuarios WHERE email = '" . $email ."'";
    $result = mysql_query($sql);
    if ($row = mysql_fetch_array($result))
    {
      $seguir = false;
      mostrarTextoError("Error",
          "El E-Mail " . $email . " ya está registrado.");
    }
    //comprobar si el codigo ya existe
    $sql = "SELECT codigousuario FROM usuarios WHERE codigousuario = '" . $codigo ."'";
    $result = mysql_query($sql);
    if ($row = mysql_fetch_array($result))
    {
      $seguir = false;
      mostrarTextoError("Error",
          "El código de usuario:  " . $codigo . ", ya ha sido registrado por otro usuario.");
    }

    //FIN VALIDACION DATOS
    if ($seguir == true)  //si la validación es correcta
    {
      $fechaalta = fechaactual();
      $fechaultimavisita = fechaactual();
      $horaultimavisita = horaactual();
      if ($envioinformacion == "1")
      {
         $envioinformacion = 1;
      }
      else
      {
        $envioinformacion = 0;
      }
      $sql = "INSERT INTO usuarios (dni, nombre, codigousuario, contrasena, localidad,
          provincia, pais, fechaalta, email, direccion, codigopostal,
          fechaultimavisita, horaultimavisita, envioinformacion)";
      $sql .= "VALUES ('$dni', '$nombre', '$codigo', '$contrasena', '$localidad',
          '$provincia', '$pais', '$fechaalta', '$email', '$direccion',
          '$codigopostal', '$fechaultimavisita', '$horaultimavisita',
          '$envioinformacion')";
      $result = mysql_query($sql);
      if (!($result))
      {
        mostrarTextoError("Error",
            "No se ha podido dar de alta al usuario " . $nombre .
            " inténtelo en otro momento.");
      }
      mostrarTexto("Proceso realizado",
          "Código de usuario para inicio de sesión: " . $codigo .
          "<br><br>El usuario ha sido dado de alta
          correctamente. Guarde el código mostrado arriba.
          Se le pedirá este código y su contraseña cuando desee iniciar
          su sesión en este Sitio Web.");
      //enviar mensaje al administrador
      $mensaje = "Estos son los datos del registro que usted
            ha realizado en http://www.ajpdsoft.com\r\nNombre: " .
            $nombre . "\r\nDNI: " . $dni ."\r\nContraseña: " . $contrasena .
            "\r\nCódigo de usuario: " . $codigo . "\r\nDirección: " . $direccion .
            "\r\nCódigo Postal: " . $codigopostal. "\r\nLocalidad: " .
            $localidad . "\r\nProvincia: " . $provincia . "\r\nPaís: " .
            $pais . "\r\nE-Mail: " . $email;
      $from = 'ajpdsoft@ajpdsoft.com';
      $headers = "From: $from";
      $resultado = mail("ajpdsoft@ajpdsoft.com",
            "Registro nuevo USUARIO (AjpdSoft)", $mensaje, $headers);
      if ($enviaremail == "1")
      {
        $resultado = mail($email, "Datos de registro en AjpdSoft", $mensaje, $headers);
        if ($resultado == true)
        {
        //  mostrarTextoError("Proceso realizado", "Sus datos de registro han sido
        //        enviados a la dirección de correo: " . $email;
        }
      }
    }
    else
    {
      mostrarTextoError("Error",
          "Faltan datos necesarios para registrar el usuario.");
    }
  }
  else //enviar
  {

?>

<form method="post" action="usuarioalta.php">

<p><b><font color="#008080"><span style="font-family: Arial"><font size="2"><b>Registro de usuario</font></span></b>
<div class=MsoNormal align=center style='text-align:center; width:657; height:28'>
<hr size=2 width="100%" align=center>
</div>
  <font face="verdana" style="font-size: 10pt">
  <table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#cccccc" width="81%" id="AutoNumber1" height="148">
    <tr>
      <td width="25%" height="22">
      <font style="font-size: 10pt; font-weight:700">Nombre y apellidos (o
      nombre de la empresa):</td>
      <td width="75%" height="22" colspan="3">
      <input type="Text" name="nombre" size="52" maxlength="150"></td>
    </tr>
    <tr>
      <td width="25%" height="22"><font style="font-size: 10pt">DNI/CIF:</td>
      <td width="75%" height="22" colspan="3"><input type="Text" name="dni" size="13" maxlength="15"></td>
    </tr>
    <tr>
      <td width="25%" height="22">
      <font style="font-size: 10pt; font-weight:700">Código:</td>
      <td width="75%" height="22" colspan="3"><input type="text" name="codigo" size="17" maxlength="15">&nbsp;
      <font size="1">(entre 5 y 15 caracteres, servirá para poder iniciar la sesión)</font></td>
    </tr>
    <tr>
      <td width="25%" height="22">
      <font style="font-size: 10pt; font-weight:700">Contraseña:</td>
      <td width="75%" height="22" colspan="3"><input type="password" name="contrasena" size="17" maxlength="15">&nbsp;
      <font size="1">(entre 5 y 15 caracteres)</font></td>
    </tr>
    <tr>
      <td width="25%" height="22">
      <font style="font-size: 10pt; font-weight:700">Confirmar contraseña:</td>
      <td width="75%" height="22" colspan="3"><input type="password" name="ccontrasena" size="17" maxlength="15"><font size="1" face="verdana">&nbsp;&nbsp;
      (entre 5 y 15 caracteres)</font></td>
    </tr>
    <tr>
      <td width="25%" height="22">
      <font style="font-size: 10pt; font-weight:700">E-Mail:</td>
      <td width="75%" height="22" colspan="3">
      <input type="Text" name="email" size="52" maxlength="200"></td>
    </tr>
    <tr>
      <td width="25%" height="22"><font style="font-size: 10pt">Dirección:</td>
      <td width="75%" height="22" colspan="3">
      <input type="Text" name="direccion" size="52"maxlength="100"></td>
    </tr>
    <tr>
      <td width="25%" height="22"><font style="font-size: 10pt">Localidad:</td>
      <td width="50%" height="22">
      <input type="Text" name="localidad" size="33" maxlength="30"></td>
      <td width="10%" height="22">
      <p align="right"><font style="font-size: 10pt" face="verdana">C.P.:</td>
      <td width="17%" height="22">
  <font face="verdana" style="font-size: 10pt">
      <input type="Text" name="codigopostal" size="6" maxlength="5"></td>
    </tr>

    <tr>
      <td width="25%" height="22"><font style="font-size: 10pt">Provincia:</td>
      <td width="75%" height="22" colspan="3">
      <input type="Text" name="provincia" size="27" maxlength="30"></td>
    </tr>
    <tr>
      <td width="25%" height="22"><font style="font-size: 10pt">País:</td>
      <td width="75%" height="22" colspan="3">
      <input type="Text" name="pais" size="27" maxlength="30"></td>
    </tr>
    <tr>
      <td width="25%" height="22">
  <font face="verdana" style="font-size: 10pt">
      <input type="checkbox" name="envioinformacion" value="1" checked></td>
      <td width="75%" height="22" colspan="3">
      <font style="font-size: 10pt" face="verdana">Marque esta casilla si desea que se le envíe un E-Mail cuando haya nuevas actualizaciones o nuevos programas</td>
    </tr>
    <tr>
      <td width="25%" height="22">
  <font face="verdana" style="font-size: 10pt">
      <input type="checkbox" name="enviaremail" value="1" checked></td>
      <td width="75%" height="22" colspan="3">
      <font style="font-size: 10pt" face="verdana">Marque esta casilla si desea recibir un E-Mail con los datos de registro</td>
    </tr>
    <tr>
      <td width="100%" height="56" colspan="4">
      <div align="center">
      <input type="submit" name="enviar" value="Registrar usuario"></td>
      </div>
    </tr>
    <tr>
      <td width="100%" height="56" colspan="4">
      <b><font size="2">Nota: los campos en negrita son obligatorios.</font></b></tr>
</table>

</form>

<?

} //end if

?>

</body>

</html>
