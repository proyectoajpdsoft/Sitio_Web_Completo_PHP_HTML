<?
  include ("funciones.php");

  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
//  $tipoletranormal = "<font face=\"verdana\" style=\"font-size: 10pt\">";
  $encabezadoaviso = "<font size=\"2\" color=\"#008080\"><span style=\"font-family: Arial\"><b>Aviso</b></span></font><hr size=2 width=\"100%\" align=center>";
  $encabezadoerror = "<font size=\"2\" color=\"#008080\"><span style=\"font-family: Arial\"><b>Error</span></b></font><hr size=2 width=\"100%\" align=center>";

  conectarbd ("bd");

  //seg�n el usuario mostrar p�gina personal
  $encabezadopersonal = "<font size=\"2\" color=\"#008080\"><span style=\"font-family: Arial\"><b>Gesti�n de incidencias [ "
      . $nombreusuario . " ]</b></span></font><hr size=2 width=\"100%\" align=center>";
  echo $encabezadopersonal;
  if ($tipousuario == "Administrador")  //si es el administrador
  {
    echo "<A href=\"incidenciaresolver.php\">Resolver incidencia</A><br>";
  }
  echo "<br><A href=\"incidenciacrear.php\">Crear incidencia de programa</A><br>";
  $verincidenciatipo = "todas";
  echo "<A href=\"incidenciaver.php?ver=" . $verincidenciatipo .
      "\">Mostrar todas las incidencias creadas</A><br>";
  $verincidenciatipo = "noresueltas";
  echo "<A href=\"incidenciaver.php?ver=" . $verincidenciatipo .
      "\">Mostrar las incidencias NO resueltas</A><br>";
  $verincidenciatipo = "siresueltas";
  echo "<A href=\"incidenciaver.php?ver=" . $verincidenciatipo .
      "\">Mostrar las incidencias resueltas</A><br>";
?>

<form method="POST" action="incidenciarealizar.php">
   <table border="1" cellpadding="3" cellspacing="0" style="border-collapse: collapse" bordercolor="#808080" width="89%" id="AutoNumber1" height="156">
    <tr>
      <td width="63%" bgcolor="#C0C0C0" bordercolor="#808080" height="35"><b>
      <font face="Tahoma" size="2">Acci�n</font></b></td>
      <td width="20%" bgcolor="#C0C0C0" height="35">
      <p align="center"><b><font face="Tahoma" size="2">C�digo incidencia</font></b></td>
      <td width="20%" bgcolor="#C0C0C0" height="35">
      <p align="center"><b><font face="Tahoma" size="2">Realizar</font></b></td>
    </tr>
    <tr>
      <td width="63%" height="44"><font face="Tahoma" size="2"><b>Cancelar</b>
      incidencia (si cancela una incidencia se marcar� como eliminada) </font>
      <sup><font face="Tahoma" size="2">(*)</font></sup></td>
      <td width="20%" height="44">
      <p align="center">&nbsp;<input type="text" name="codigocancelar" size="8"></td>
      <td width="20%" height="44">
      <p align="center"><input type="submit" value="Realizar" name="opCancelar"></td>
    </tr>
    <tr>
      <td width="63%" height="55"><font face="Tahoma" size="2"><b>Reactivar</b>
      incidencia (si realiza esta acci�n la incidencia se marcar� como NO
      resuelta para su posterior resoluci�n y si estaba cancelada se activar�)
      </font><sup><font face="Tahoma" size="2">(*)</font></sup></td>
      <td width="20%" height="55">
      <p align="center">&nbsp;<input type="text" name="codigoreactivar" size="8"></td>
      <td width="20%" height="55">
      <p align="center">
      <input type="submit" value="Realizar" name="opReactivar"></td>
    </tr>
    <tr>
      <td width="63%" height="55"><font face="Tahoma" size="2">Mostrar <b>
      detalle</b> de una incidencia (muestra los datos de la incidencia:
      descripci�n, fecha, motivo, estado, con posibilidad de impresi�n de la
      misma) </font><sup><font face="Tahoma" size="2">(*)</font></sup></td>
      <td width="20%" height="55">
      <p align="center">&nbsp;<input type="text" name="codigodetalle" size="8"></td>
      <td width="20%" height="55">
      <p align="center"><input type="submit" value="Realizar" name="opDetalle"></td>
    </tr>
    <tr>
      <td width="63%" height="55"><font face="Tahoma" size="2"><b>Estado</b> de
      una incidencia (muestra si se encuentra resuelta, pendiente de resoluci�n,
      cancelada, ...) </font><sup><font face="Tahoma" size="2">(*)</font></sup></td>
      <td width="20%" height="55">
      <p align="center">&nbsp;<input type="text" name="codigoestado" size="8"></td>
      <td width="20%" height="55">
      <p align="center"><input type="submit" value="Realizar" name="opEstado"></td>
    </tr>
    <tr>
      <td width="63%" height="55"><font face="Tahoma" size="2"><b>Enviar</b>
      incidencia a su correo electr�nico (enviar� la incidencia seleccionada a
      su direcci�n de E-Mail con todos los datos de la misma) </font><sup>
      <font face="Tahoma" size="2">(*)</font></sup></td>
      <td width="20%" height="55">
      <p align="center">&nbsp;<input type="text" name="codigoenviar" size="8"></td>
      <td width="20%" height="55">
      <p align="center"><input type="submit" value="Realizar" name="opEnviar"></td>
    </tr>
    
    <?
      // si el usuario es administrador mostrar
      if ($tipousuario == "Administrador")
      {
        echo "<tr>
            <td width=\"63%\" height=\"55\"><font face=\"Tahoma\" size=\"2\"><b>Eliminar</b>
            incidencia</font><sup>
            <font face=\"Tahoma\" size=\"2\">(*)</font></sup></td>
            <td width=\"20%\" height=\"55\">
            <p align=\"center\">&nbsp;<input type=\"text\" name=\"codigoeliminar\" size=\"8\"></td>
            <td width=\"20%\" height=\"55\">
            <p align=\"center\"><input type=\"submit\" value=\"Realizar\" name=\"opEliminar\"></td>
          </tr>";
      }
    ?>
    
  </table>
</form>
<p><font face="Tahoma" size="2">(*) Si no recuerda el c�digo de la
incidencia, obtenga una lista de incidencias en &quot;Gesti�n de incidencias de
programas&quot; donde aparecer� el c�digo de todas las incidencias.</font></p>

</body>
