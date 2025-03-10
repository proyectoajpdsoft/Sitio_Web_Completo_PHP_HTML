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
    if (empty($codigoprograma))
    {
      $seguir = false;
      mostrarTextoError("Error",
          "No ha introducido el Programa.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    if (empty($tipo))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "No ha introducido el Tipo de incidencia.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    if (empty($comentario))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "No ha introducido el comentario de la incidencia.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    //FIN VALIDACION DATOS
    if ($seguir == true)  //si la validación es correcta
    {
      //obtener la fecha y hora actual
      $fecha = fechaactual();
      $hora = horaactual();
      conectarbd ("bd");
      $estado = "Pendiente resolución";
      $sql = "INSERT INTO incidencias (fecha, hora, codigousuario,
          codigoprograma, tipo, comentario, estado)";
      $sql .= "VALUES ('$fecha', '$hora', '$codigousuario', '$codigoprograma',
          '$tipo', '$comentario', '$estado')";
      $result = mysql_query($sql);
      if (!($result))
      {
        mostrarTextoError ("Error",
            "No se ha podido crear la incidencia. Inténtelo en otro momento.");
      }
      //para obtener el código de la incidencia creada
      $sql = "SELECT incidencias.*, programas.nombre NombrePrograma
              FROM incidencias, programas
              WHERE incidencias.codigousuario='" . $codigousuario .
              "' AND incidencias.codigoprograma='" . $codigoprograma .
              "' AND programas.codigo=incidencias.codigoprograma
              ORDER BY incidencias.codigo DESC";
      $result = mysql_query($sql);
      $creado = false;
      if ($row = mysql_fetch_array($result))
      {
        $creado = true;
        $codigo = $row["codigo"];
        //mostramos la incidencia
        detalleincidencia($row["codigo"], $row["tipo"], $row["fecha"],
            $row["NombrePrograma"], $row["estado"], $nombreusuario,
            $row["comentario"], $row["fecharesolucion"],
            $row["comentarioresolucion"], SiNo($row["resuelta"]));
      }
      if ($creado == true)
      {
        $mensaje = "Código incidencia: " . $row["codigo"] . "\r\nCódigo Usuario: " .
            $codigousuario . "\r\nNombre: " . $nombreusuario . "\r\nE-Mail: " .
            $emailusuario . "\r\nCódigo programa: " . $codigoprograma .
            "\r\nNombre programa: " . $row["NombrePrograma"] . "\r\nComentario:\r\n" .
            "**********************************\r\n" . $row["comentario"]  .
            "\r\n**********************************" .
            "\r\n\r\n\r\nMás información en http://www.ajpdsoft.com";

            $from = $emailusuario;
            $headers = "From: $from";
            $resultado = @mail("incidencias@ajpdsoft.com",
                "Incidencia AjpdSoft: " . $row["codigo"], $mensaje, $headers);
        if ($resultado == true)
        {
          //echo $tipoletranormal ."<br><br>La incidencia no ha podido enviarse";
        }
      }
      else
      {
        mostrarTextoError ("Error",
            "<br>La incidencia NO ha sido enviada, compruebe
            los datos e inténtelo en otro momento.");
      }
    }
    else
    {
      mostrarTextoError ("Error",
          "Faltan datos necesarios para enviar la incidencia.");
    }
    echo $tipoletranormal . "<A href=\"incidenciagestionar.php\">
        Gestión de Incidencias de programas</A><br>";
  }
  else //enviar
  {

?>

<FORM name="FormCrearIncidencia" ACTION = "incidenciacrear.php" METHOD = "POST">
<div align="left" style="width: 677; height: 368">
<font color="#008080"><span style="font-family: Arial"><font size=2><b>Crear incidencia [

  <?
    echo $nombreusuario;
  ?>

]</b></span></font><div class=MsoNormal align=center style='text-align:center; width:657; height:28'>
<hr size=2 width="100%" align=center>
</div>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="97%" id="AutoNumber1">
    <tr>
      <td width="19%" height="26"><b><font face="Tahoma">
      <font size="2">Programa</font><font size="2" color="#333366">:</font></font></b></td>
      <td width="85%" height="26"><select size="1" name="codigoprograma">

      <?
        conectarbd("bd");
        $tipoletranormal = "<font face=\"verdana\" style=\"font-size: 10pt\">";
        //mostrar sólo los programas gratuitos
        if ($tipousuario == "Usuario" | $tipousuario == "Usuario-Lista" | $tipousuario == "Lista")
        {
          $sql = "SELECT nombre, codigo, libre
                  FROM programas
                  WHERE libre=1
                  ORDER BY nombre";
        }
        if ($tipousuario == "Administrador") //mostrar todos los programas
        {
          $sql = "SELECT nombre, codigo
                  FROM programas
                  ORDER BY nombre";
        }
        //mostrar sólo los programas que haya pagado
        if ($tipousuario == "Pago" | $tipousuario == "Pago-Lista")
        {
          $sql = "SELECT programas.nombre, usuariosprograma.codigoprograma
                  FROM usuariosprograma, programas
                  WHERE usuariosprograma.codigoprograma=programas.codigo AND
                  usuariosprograma.codigousuario= " . $codigousuario;
        }
        $result = mysql_query($sql);
        while ($row = mysql_fetch_row($result))
        {
          echo "<option value=\"" .
              $row[1] . "\">" . $row[0] . "</option>";
        }
        //mostrar también los programas gratuitos
        if ($tipousuario == "Pago" | $tipousuario == "Pago-Lista")
        {
          $sql = "SELECT nombre, codigo
                  FROM programas
                  WHERE libre=1
                  ORDER BY nombre";
          $result = mysql_query($sql);
          while ($row = mysql_fetch_row($result))
          {
            echo "<option value=\"" .
                $row[1] . "\">" . $row[0] . "</option>";
          }
        }
     ?>
      
      </select></td>
    </tr>
    <tr>
      <td width="19%" height="24"><b><font face="Tahoma" size="2">Tipo:</font></b></td>
      <td width="85%" height="24"><select size="1" name="tipo">
      <option selected>Error</option>
      <option>Modificación</option>
      <option>Duda</option>
      <option>Sugerencia/Mejora</option>
      <option>Otro</option>
      </select></td>
    </tr>
    <tr>
      <td width="19%" align="left" valign="top" height="24"><b>
      <font face="Tahoma" size="2">Incidencia:</font></b></td>
      <td width="85%" height="24">
      <textarea name="comentario" cols="64" rows="10"></textarea></td>
    </tr>
    <tr>
      <td width="19%" height="31">&nbsp;</td>
      <td width="85%" height="31">
      <p align="center"><font size="3" face="Arial"><b><input type="submit" name="enviar" value="Enviar incidencia"></b></td>
    </tr>
  </table><br>
<font size="2" color="#333366" face="Verdana">&nbsp;· Los campos en negrita son obligatorios.</font><b><br>
</form>

<?

} //end if

?>

</body>

</html>
