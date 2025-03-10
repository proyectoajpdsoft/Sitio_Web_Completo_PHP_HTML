<?
  include ("funciones.php");
  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  // según el usuario mostrar página personal
  $encabezadopersonal = "<font size=\"2\" color=\"#008080\"><span style=\"font-family: Arial\">Gestión de usuarios ["
      . $nombreusuario . "]</span></font><hr size=2 width=\"100%\" align=center>";
  echo $encabezadopersonal;
  if ($tipousuario != "Administrador")  //si no es el administrador
  {
    mostrarTextoError("Error de acceso", "No tiene permisos para realizar esta operación.");
  }
?>

<form method="POST" action="usuariorealizar.php">
  <table border="1" cellpadding="3" cellspacing="0" style="border-collapse: collapse" bordercolor="#808080" width="89%" id="AutoNumber1" height="156">
    <tr>
      <td width="63%" bgcolor="#C0C0C0" bordercolor="#808080" height="35"><b>
      <font face="Tahoma" size="2">Acción</font></b></td>
      <td width="20%" bgcolor="#C0C0C0" height="35">
      <p align="center"><b><font face="Tahoma" size="2">Código usuario</font></b></td>
      <td width="20%" bgcolor="#C0C0C0" height="35">
      <p align="center"><b><font face="Tahoma" size="2">Realizar</font></b></td>
    </tr>
    <tr>
      <td width="63%" height="44"><font face="Tahoma" size="2">Seleccione el <b>tipo</b> de usuario a cambiar: </b></font>
      <select size="1" name="opTipoUsuario">
      <option value="Usuario" selected>Usuario</option>
      <option value="Administrador">Administrador</option>
      <option value="Lista">Lista</option>
      <option value="Pago">Pago</option>
      <option value="Pago-Lista">Pago-Lista</option>
      <option value="Usuario-Lista">Usuario-Lista</option></select>
      </select>
      </td>
      <td width="20%" height="44">
      <p align="center">&nbsp;<input type="text" name="codigocambiartipo" size="8"></td>
      <td width="20%" height="44">
      <p align="center"><input type="submit" value="Realizar" name="opCambiar"></td>
    </tr>
    <tr>
      <td width="63%" height="55"><font face="Tahoma" size="2"><b>Eliminar</b>
      usuario</font><sup><font face="Tahoma" size="2">(*)</font></sup></td>
      <td width="20%" height="55">
      <p align="center">&nbsp;<input type="text" name="codigoeliminar" size="8"></td>
      <td width="20%" height="55">
      <p align="center">
      <input type="submit" value="Realizar" name="opEliminar"></td>
    </tr>
    <tr>
      <td width="63%" height="55"><font face="Tahoma" size="2">Seleccione programa a
      <b> asignar</b> (para actualizaciones, incidencias, descarga de instalación) </font><sup>
      <font face="Tahoma" size="2">(*)</font></sup>
      <select size="1" name="opCodigoProgramaAsignar">
      <?
        conectarbd ("bdajpdsoft");
        //se selecciona los programas
        $sqlConsulta = "SELECT nombre, codigo FROM programas";
        $sqlResultado = mysql_query($sqlConsulta);
        while ($row = mysql_fetch_row($sqlResultado))
        {
          echo "<option value=\"" .  $row[1] . "\">" . $row[0] . "</option>";
        }
      ?>

      </select>
      </td>
      <td width="20%" height="55">
      <p align="center">&nbsp;<input type="text" name="codigoasignar" size="8"></td>
      <td width="20%" height="55">
      <p align="center"><input type="submit" value="Realizar" name="opAsignar"></td>
    </tr>
  </table>
</form>
<p><font face="Tahoma" size="2">(*) Si no recuerda el código del
usuario, obtenga una lista de usuarios en &quot;Lista de Usuarios&quot;
donde aparecerá el código de todos los usuarios.</font></p>

</body>
