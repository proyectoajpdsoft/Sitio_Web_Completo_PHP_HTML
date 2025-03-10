<html>
<style>
</style>
<body>

<?php
  include("funciones.php");
  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  $tipoletranormal = "<font face=\"verdana\" style=\"font-size: 10pt\">";
  if ($enviar)
  {
    $seguir = true;
    //INICIO VALIDACION DATOS
    if (empty($mensaje))
    {
      $seguir = false;
      mostrarTextoError("Error",
          "No ha introducido el mensaje a enviar.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    //FIN VALIDACION DATOS
    if ($seguir == true)  //si la validación es correcta
    {
      //obtener la fecha y hora actual
      conectarbd ("bd");
      $sql = "SELECT nombre, email, envioinformacion
              FROM usuarios
              WHERE envioinformacion=1";
      $result = mysql_query($sql);
      $numeroerrores = 0;
      $numerovalidos = 0;
      mostrarTexto ("Resultado del envío masivo de E-Mail",
          "Estos son los resultados del envío masivo de E-Mail que usted ha realizado:<br><br>");
      while ($row = mysql_fetch_array($result))
      {
        $mensaje = "Comunicación desde AjpdSoft:\r\n\r\n" .
            $mensaje . "\r\n\r\n\r\nMás información en http://www.ajpdsoft.com";
        $from = "ajpdsoft@ajpdsoft.com";
        $headers = "From: $from";
        $resultado = @mail($row["email"], $titulomensaje, $mensaje, $headers);
        if ($resultado == false)
        {
          $numeroerrores++;
          echo $tipoletranormal . " - " . $row["nombre"] . " -> " . $row["email"] . " NO ENVIADO<br>";
        }
        else
        {
          $numerovalidos++;
          echo $tipoletranormal . " + " . $row["nombre"] . " -> " . $row["email"] . " ENVIADO<br>";
        }
      }
      if ($numerovalidos == 0)
      {
        echo $tipoletranormal .
            "<br><br><br>ATENCIÓN: el mensaje no se ha enviado a ningún usuario.";
      }
      else
      {
        echo $tipoletranormal .
            "<br><br><br>Proceso realizado, el mensaje ha sido enviado a " .
            $numerovalidos . " usuarios.";
        if ($numeroerrores > 0)
        {
          echo $tipoletranormal .
              "<br>Número de E-Mail no enviados: " .
              $nuemeroerrores;
        }
      }
    }
  }
  else //enviar
  {

?>

<FORM name="FormEnvioEMailMasivo" ACTION = "emailmasivo.php" METHOD = "POST">
<div align="left" style="width: 677; height: 368">
<font color="#008080"><span style="font-family: Arial"><font size=2><b>Envío de E-Mail masivo [

  <?
    echo $nombreusuario;
  ?>

]</b></span></font><div class=MsoNormal align=center style='text-align:center; width:657; height:28'>
<hr size=2 width="100%" align=center>
</div>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="97%" id="AutoNumber1">
    <tr>
      <td width="19%" align="left" valign="top" height="24"><b>
      <font face="Tahoma" size="2">Título:</font></b></td>
      <td width="85%" height="24">
      <input type=text name="titulomensaje" size=80></td>
    </tr>
    <tr>
      <td width="19%" align="left" valign="top" height="24"><b>
      <font face="Tahoma" size="2">Mensaje:</font></b></td>
      <td width="85%" height="24">
      <textarea name="mensaje" cols="60" rows="10"></textarea></td>
    </tr>
    <tr>
      <td width="19%" height="31">&nbsp;</td>
      <td width="85%" height="31">
      <p align="center"><font size="3" face="Arial"><b><input type="submit" name="enviar" value="Enviar E-Mail masivo"></b></td>
    </tr>
  </table><br>
</form>

<?

} //end if

?>

</body>

</html>
