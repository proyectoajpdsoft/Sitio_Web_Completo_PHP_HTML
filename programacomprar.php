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
    if ($seguir == true)  //si la validaci�n es correcta
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
            "No se ha podido gestionar su petici�n. Por favor,
            int�ntelo en otro momento.");
      }
      //obtenemos el nombre del programa
      $sql = "SELECT nombre
              FROM programas
              WHERE codigo='" . $codigoprograma . "'";
      $result = mysql_query($sql);
      $row = mysql_fetch_array($result);
      $nombreprograma = $row["nombre"];
      //enviamos la petici�n al E-Mail
      $mensaje = "PETICI�N DE COMPRA DE PROGRAMA: \r\nC�digo Usuario: " .
          $codigousuariopropio . "\r\nNombre: " . $nombreusuario .
          "\r\nE-Mail: " . $emailusuario . "\r\nC�digo programa: " . $codigoprograma .
          "\r\nNombre programa: " . $nombreprograma .
          "\r\n\r\n\r\nM�s informaci�n en http://www.ajpdsoft.com";
       $from = 'ajpdsoft@ajpdsoft.com';
       $headers = "From: $from";
       $resultado = @mail("ajpdsoft@ajpdsoft.com",
           "Petici�n de compra de programa: " . $codigopeticion, $mensaje, $headers);
       mostrarTexto ("Proceso realizado",
         "Su petici�n de compra ha sido enviada correctamente. En breve
         recibir� un mensaje con los datos del programa y la forma de pago
         (si est� interesado).");
    }
    else
    {
      mostrarTextoError ("Error",
          "Faltan datos necesarios para enviar la petici�n de compra.");
    }
  }
  else //enviar
  {

?>

<FORM name="FormProgramaComprar" ACTION = "programacomprar.php" METHOD = "POST">
<div align="left" style="width: 677; height: 368">
<font color="#008080"><span style="font-family: Arial"><font size=2><b>Petici�n de compra de programa [

  <?
    echo $nombreusuario;
  ?>

]</b></span></font><div class=MsoNormal align=center style='text-align:center; width:657; height:28'>
<hr size=2 width="100%" align=center>
</div>
<font size="2" color="#333366" face="Verdana">Esta petici�n de compra no
supondr� compromiso alguno por su parte.<br> Nos pondremos en contacto con
usted para enviarle toda la informaci�n del programa
(precio, caracter�sticas, ...) mediante su direcci�n de E-Mail:
  <?
    echo " " . $emailusuario . ". Si no es correcta o la ha cambiado,
      <A href=\"usuariodatos.php\">pulse aqu�</A> para cambiar su E-Mail por
      uno v�lido.<br><br> Seleccione el programa por el que est� interesado
      y pulse en \"Enviar petici�n\" </font><b><br>
    <select size=\"1\" name=\"codigoprograma\">";
    conectarbd ("bd");
    //mostrar s�lo los programas de pago
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
<font size="3" face="Arial"><b><input type="submit" name="enviar" value="Enviar petici�n"></b></td>
</form>

<?

} //end if

?>

</body>

</html>
