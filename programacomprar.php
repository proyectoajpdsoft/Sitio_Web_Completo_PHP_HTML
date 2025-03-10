<html>
<style>
</style>
<body>

<?php
  include("funciones.php");
  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  if ($enviar)
  {
    $seguir = true;
    //INICIO VALIDACION DATOS
    if (empty($codigoprograma))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "No ha introducido el Programa a comprar.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    //FIN VALIDACION DATOS
    if ($seguir == true)  //si la validación es correcta
    {
      //obtener la fecha y hora actual
      $fecha = fechaactual();
      $hora = horaactual();
      conectarbd ("bd");
      $sql = "SELECT codigo
              FROM peticionescompra
              ORDER BY codigo DESC";
      $result = mysql_query($sql);
      if ($row = mysql_fetch_array($result))
      {
         $codigopeticion = $row["codigo"];
         $codigopeticion = $codigopeticion + 1;
      }
      else
      {
        $codigopeticion = 1;
      }
      $sql = "INSERT INTO peticionescompra (codigo, fecha, hora, codigousuario, codigoprograma)";
      $sql .= "VALUES ('$codigopeticion', '$fecha', '$hora', '$codigousuario', '$codigoprograma')";
      $result = mysql_query($sql);
      if (!($result))
      {
        mostrarTextoError ("Error",
            "No se ha podido gestionar su petición. Por favor,
            inténtelo en otro momento.");
      }
      //obtenemos el nombre del programa
      $sql = "SELECT nombre
              FROM programas
              WHERE codigo='" . $codigoprograma . "'";
      $result = mysql_query($sql);
      $row = mysql_fetch_array($result);
      $nombreprograma = $row["nombre"];
      //enviamos la petición al E-Mail
      $mensaje = "PETICIÓN DE COMPRA DE PROGRAMA: \r\nCódigo Usuario: " .
          $codigousuariopropio . "\r\nNombre: " . $nombreusuario .
          "\r\nE-Mail: " . $emailusuario . "\r\nCódigo programa: " . $codigoprograma .
          "\r\nNombre programa: " . $nombreprograma .
          "\r\n\r\n\r\nMás información en http://www.ajpdsoft.com";
       $from = 'ajpdsoft@ajpdsoft.com';
       $headers = "From: $from";
       $resultado = @mail("ajpdsoft@ajpdsoft.com",
           "Petición de compra de programa: " . $codigopeticion, $mensaje, $headers);
       mostrarTexto ("Proceso realizado",
         "Su petición de compra ha sido enviada correctamente. En breve
         recibirá un mensaje con los datos del programa y la forma de pago
         (si está interesado).");
    }
    else
    {
      mostrarTextoError ("Error",
          "Faltan datos necesarios para enviar la petición de compra.");
    }
  }
  else //enviar
  {

?>

<FORM name="FormProgramaComprar" ACTION = "programacomprar.php" METHOD = "POST">
<div align="left" style="width: 677; height: 368">
<font color="#008080"><span style="font-family: Arial"><font size=2><b>Petición de compra de programa [

  <?
    echo $nombreusuario;
  ?>

]</b></span></font><div class=MsoNormal align=center style='text-align:center; width:657; height:28'>
<hr size=2 width="100%" align=center>
</div>
<font size="2" color="#333366" face="Verdana">Esta petición de compra no
supondrá compromiso alguno por su parte.<br> Nos pondremos en contacto con
usted para enviarle toda la información del programa
(precio, características, ...) mediante su dirección de E-Mail:
  <?
    echo " " . $emailusuario . ". Si no es correcta o la ha cambiado,
      <A href=\"usuariodatos.php\">pulse aquí</A> para cambiar su E-Mail por
      uno válido.<br><br> Seleccione el programa por el que esté interesado
      y pulse en \"Enviar petición\" </font><b><br>
    <select size=\"1\" name=\"codigoprograma\">";
    conectarbd ("bd");
    //mostrar sólo los programas de pago
    $sql = "SELECT nombre, codigo, libre
            FROM programas
            WHERE libre=0
            ORDER BY nombre";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_row($result))
    {
      echo "<option value=\"" .
          $row[1] . "\">" . $row[0] . "</option>";
    }
  ?>
</select></td>
<font size="3" face="Arial"><b><input type="submit" name="enviar" value="Enviar petición"></b></td>
</form>

<?

} //end if

?>

</body>

</html>
