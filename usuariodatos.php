<html>
<body>

<?php
  include ("funciones.php");
  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  if ($enviar)
  {
    $seguir = true;
    //INICIO VALIDACION DATOS
    if (empty($codigomodificar))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "No ha introducido el código de usuario.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
//    elseif (((strlen($codigomodificar) < 5) || (strlen($codigomodificar) > 15)))
//    {
//      $seguir = false;
//      mostrarTextoError ("Error",
//          "El código debe ser de más de 5 caracteres y de menos
//          de 15 caracteres (se pueden introducir números y
//          letras).  <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
//    }
    if (empty($nombre))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "No ha introducido el Nombre.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    if (empty($contrasena) || (empty($ccontrasena)))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "No ha introducido la Contraseña.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    elseif (((strlen($contrasena) < 5) || (strlen($contrasena) > 15)))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "La contraseña debe ser de más de 5 caracteres y de menos
          de 15 caracteres (se pueden introducir números y
          letras).  <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    elseif (!($contrasena === $ccontrasena))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "Las contraseñas no coinciden. Debe introducir la contraseña
          dos veces para confirmarla.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }

    if (!isset($email))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "El E-Mail no es correcto. Introdúzcalo correctamente.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    if(empty($email))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "El E-Mail no es correcto. Introdúzcalo correctamente.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    if ( (strlen($email) < 3) || (strlen($email) > 200))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "El E-Mail es muy largo o muy corto.
           <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    elseif(!ereg("@",$email))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "El E-Mail no es correcto, no se ha introducido el símbolo de @.
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
      mostrarTextoError ("Error", "El E-Mail no es correcto.
         El nombre de usuario o el nombre del servidor no son
         válidos.  <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    else
    {
      $seguir = true;
    }

    conectarbd ("bdajpdsoft");

    //Comprobar código de usuario no duplicado
    $sql = "SELECT email, codigo
            FROM usuarios
            WHERE codigousuario = '" . $codigomodificar . "'";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_row($result))
    {
      if ($codigousuario <> $row[1])
      {
        $seguir = false;
        mostrarTextoError ("Error",
            "El código de usuario introducido no es correcto, deberá utilizar otro.
             <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
      }
    }

    //comprobar si el email se ha modificado y si es así comprobar que no exista
    $sql = "SELECT email, codigo
            FROM usuarios
            WHERE email = '" . $email . "'";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_row($result))
    {
      if ($codigousuario <> $row[1])
      {
        $seguir = false;
        mostrarTextoError ("Error",
            "El E-Mail introducido ya ha sido dado de alta. Introduzca
             otro.  <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
      }
    }
    //FIN VALIDACION DATOS
    if ($seguir == true)  //si la validación es correcta
    {
      if ($envioinformacion == "")
      {
         $envioinformacion = 0;
      }
      else
      {
        $envioinformacion = 1;
      }
      $sql = "UPDATE usuarios SET " .
             "codigousuario='" . $codigomodificar . "'," .
             "dni='" . $dni . "'," .
             "nombre='" . $nombre . "'," .
             "contrasena='" . $contrasena . "'," .
             "localidad='" . $localidad . "'," .
             "provincia='" . $provincia . "'," .
             "pais='" . $pais . "'," .
             "email='" . $email . "'," .
             "direccion='" . $direccion . "'," .
             "codigopostal='" . $codigopostal . "'," .
             "envioinformacion='" . $envioinformacion . "'" .
             "WHERE codigo='" . $codigousuario . "'";
      $result = mysql_query($sql);
      if (!($result))
      {
        mostrarTextoError ("Error",
            "No se han podido modificar los datos del usuario " . $nombre .
            " inténtelo en otro momento.");
      }
      else
      {
        session_unset();
        session_destroy();
        mostrarTexto ("Proceso realizado",
            "<br><br>Los datos han sido modificados correctamente. Deberá
            volver a iniciar la sesión para que los cambios tengan efecto:
            <A target=\"_blank\" href=\"login.html\">Iniciar sesión</A>\n");
      }
    }
    else
    {
      mostrarTextoError ("Error",
          "Faltan datos necesarios para actualizar el usuario.");
    }
  }
  else //enviar
  {

?>

<form method="post" action="usuariodatos.php">
<p><b><font color="#008080"><span style="font-family: Arial"><font size="2"><b>

<?
  $tipoletranormal = "<font face=\"verdana\" style=\"font-size: 10pt\">";
  if (! empty($codigousuario))
  {
    //comprobar si el codigo existe y obtener datos
    conectarbd ("bdajpdsoft");
    $sql = "SELECT * FROM usuarios WHERE codigo = '" . $codigousuario . "'";
    $result = mysql_query($sql);
    if ($row = mysql_fetch_array($result))
    {
      $codigo = $row["codigousuario"];
      $nombre = $row["nombre"];
      $email = $row["email"];
      $dni = $row["dni"];
      $direccion = $row["direccion"];
      $contrasena = $row["contrasena"];
      $localidad = $row["localidad"];
      $codigopostal = $row["codigopostal"];
      $provincia = $row["provincia"];
      $pais = $row["pais"];
      $envioinformacion = $row["envioinformacion"];
    }
    else
    {
      mostrarTextoError ("Error",
          "Debe inciar la sesión. <A href=\"login.html\">Iniciar sesión</A>");
    }
  }
  else
  {
    mostrarTextoError ("Error",
        "Debe inciar la sesión. <A href=\"login.html\">Iniciar sesión</A>");
  }
  echo "Modificar datos [ " . $nombre . " ]</font></span></b>";
?>

<div class=MsoNormal align=center style='text-align:center; width:657; height:28'>
  <hr size=2 width="100%" align=center>
</div>
<font face="verdana" style="font-size: 10pt">
<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#cccccc" width="81%" id="AutoNumber1" height="148">
    <tr>
      <td width="25%" height="22">
      <font style="font-size: 10pt; font-weight:700">Código de usuario:</td>
      <td width="75%" height="22" colspan="3">
      <input type="Text" name="codigomodificar" size="15" maxlength="15"

      <?
        echo " value=\"" . $codigousuariopropio . "\"></td>";
      ?>

    </tr>

    <tr>
      <td width="25%" height="22">
      <font style="font-size: 10pt; font-weight:700">Nombre y apellidos (o
      nombre de la empresa):</td>
      <td width="75%" height="22" colspan="3">
      <input type="Text" name="nombre" size="52" maxlength="150"
      
      <?
        echo " value=\"" . $nombre . "\"></td>";
      ?>

    </tr>
    <tr>
      <td width="25%" height="22"><font style="font-size: 10pt">DNI/CIF:</td>
      <td width="75%" height="22" colspan="3"><input type="Text" name="dni" size="13" maxlength="15"

      <?
        echo " value=\"" . $dni . "\"></td>";
      ?>

    </tr>
    <tr>
      <td width="25%" height="22">
      <font style="font-size: 10pt; font-weight:700">Contraseña:</td>
      <td width="75%" height="22" colspan="3"><input type="password" name="contrasena" size="17" maxlength="15"

      <?
        echo " value=\"" . $contrasena . "\">";
      ?>

      &nbsp;<font size="1">(entre 5 y 15 caracteres)</font></td>
    </tr>
    <tr>
      <td width="25%" height="22">
      <font style="font-size: 10pt; font-weight:700">Confirmar contraseña:</td>
      <td width="75%" height="22" colspan="3"><input type="password" name="ccontrasena" size="17" maxlength="15"
      <?
        echo " value=\"" . $contrasena . "\">";
      ?>
      <font size="1" face="verdana">&nbsp;
      (entre 5 y 15 caracteres)</font></td>
    </tr>
    <tr>
      <td width="25%" height="22">
      <font style="font-size: 10pt; font-weight:700">E-Mail:</td>
      <td width="75%" height="22" colspan="3">
      <input type="Text" name="email" size="52" maxlength="200"

      <?
        echo " value=\"" . $email . "\"></td>";
      ?>

    </tr>
    <tr>
      <td width="25%" height="22"><font style="font-size: 10pt">Dirección:</td>
      <td width="75%" height="22" colspan="3">
      <input type="Text" name="direccion" size="52" maxlength="100"

      <?
        echo " value=\"" . $direccion . "\"></td>";
      ?>

    </tr>
    <tr>
      <td width="25%" height="22"><font style="font-size: 10pt">Localidad:</td>
      <td width="50%" height="22">
      <input type="Text" name="localidad" size="33" maxlength="30"
      
      <?
        echo " value=\"" . $localidad . "\"></td>";
      ?>

      <td width="10%" height="22">
      <p align="right"><font style="font-size: 10pt" face="verdana">C.P.:</td>
      <td width="17%" height="22">
  <font face="verdana" style="font-size: 10pt">
      <input type="Text" name="codigopostal" size="6" maxlength="5"
      
      <?
        echo " value=\"" . $codigopostal . "\"></td>";
      ?>

    </tr>

    <tr>
      <td width="25%" height="22"><font style="font-size: 10pt">Provincia:</td>
      <td width="75%" height="22" colspan="3">
      <input type="Text" name="provincia" size="27" maxlength="30"
      
      <?
        echo " value=\"" . $provincia . "\"></td>";
      ?>
      
    </tr>
    <tr>
      <td width="25%" height="22"><font style="font-size: 10pt">País:</td>
      <td width="75%" height="22" colspan="3">
      <input type="Text" name="pais" size="27" maxlength="30"
      
      <?
        echo " value=\"" . $pais . "\"></td>";
      ?>

    </tr>
    <tr>
      <td width="25%" height="22">
  <font face="verdana" style="font-size: 10pt">
      <input type="checkbox" name="envioinformacion"
      
      <?
        if ($envioinformacion == 1)
        {
          echo " value=\"1\" checked></td>";
        }
        else
        {
          echo " value=\"0\"></td>";
        }
      ?>

      <td width="75%" height="22" colspan="3">
      <font style="font-size: 10pt" face="verdana">Marque esta casilla si desea que se le envíe un E-Mail cuando haya nuevas actualizaciones o nuevos programas</td>
    </tr>
    <tr>
      <td width="100%" height="56" colspan="4">
      <div align="center">
      <input type="submit" name="enviar" value="Modificar datos"></td>
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
